<#
.SYNOPSIS
    Deploys SRJ website files to staging or production over SSH.

.DESCRIPTION
    Local working copy is the source of truth. This script pushes changed
    files to the server and then VERIFIES the transfer by comparing byte
    sizes, because on July 20 2026 a 69KB file was uploaded in place of a
    990KB config and took most of the AI Governance library offline for
    roughly an hour. A size check would have caught it in two seconds.

    Uses OpenSSH (scp / ssh), which ships with Windows 10 and 11. No
    WinSCP or third-party client required.

.PARAMETER Target
    staging (default) or production. Staging first is the standing rule.

.PARAMETER Path
    One or more paths relative to the repo root, e.g.
    wp-content/themes/srj-consulting/footer.php
    Directories are pushed recursively.

.PARAMETER All
    Push the whole tracked tree: theme, SRJ mu-plugins, robots.txt, llms.txt.

.PARAMETER DryRun
    Show exactly what would transfer and stop. Nothing is written.

.PARAMETER SkipVerify
    Skip the post-transfer size check. Not recommended.

.EXAMPLE
    .\deploy.ps1 -Path wp-content/themes/srj-consulting/footer.php -DryRun

.EXAMPLE
    .\deploy.ps1 -Target production -Path wp-content/mu-plugins/srj-ai-tools.php

.EXAMPLE
    .\deploy.ps1 -Target staging -All
#>

[CmdletBinding()]
param(
    [ValidateSet('staging','production')]
    [string]   $Target = 'staging',
    [string[]] $Path,
    [switch]   $All,
    [switch]   $DryRun,
    [switch]   $SkipVerify
)

$ErrorActionPreference = 'Stop'

# ---------------------------------------------------------------------------
# Configuration. Fill in the two TODO values once, then leave alone.
# ---------------------------------------------------------------------------
$Servers = @{
    staging = @{
        Host       = '1166798.us17.ssh.myftpupload.com'
        User       = 'TODO-staging-ssh-user'
        RemoteRoot = '/html'
        Url        = 'https://1166798.us17.myftpupload.com'
    }
    production = @{
        Host       = 'TODO-production-ssh-host.secureserver.net'
        User       = 'TODO-production-ssh-user'
        RemoteRoot = '/html'
        Url        = 'https://srjconsultingservices.com'
    }
}

# Paths pushed by -All, relative to repo root.
$TrackedPaths = @(
    'wp-content/themes/srj-consulting',
    'wp-content/mu-plugins',
    'robots.txt',
    'llms.txt'
)

# mu-plugins we own. Everything else in that folder belongs to the host.
$MuPluginPrefix = 'srj-'

# ---------------------------------------------------------------------------
$RepoRoot = Split-Path -Parent $MyInvocation.MyCommand.Definition
$Server   = $Servers[$Target]
$SshDest  = "$($Server.User)@$($Server.Host)"

function Write-Head($text) { Write-Host "`n$text" -ForegroundColor Cyan }
function Write-Ok($text)   { Write-Host "  $text" -ForegroundColor Green }
function Write-Warn($text) { Write-Host "  $text" -ForegroundColor Yellow }
function Write-Err($text)  { Write-Host "  $text" -ForegroundColor Red }

if ($Server.User -like 'TODO-*' -or $Server.Host -like 'TODO-*') {
    Write-Err "Server details for '$Target' are not filled in. Edit the `$Servers block at the top of this script."
    exit 1
}

# ---------------------------------------------------------------------------
# Build the file list
# ---------------------------------------------------------------------------
if (-not $Path -and -not $All) {
    Write-Err "Nothing to do. Pass -Path <file> or -All."
    exit 1
}

$roots = if ($All) { $TrackedPaths } else { $Path }
$files = New-Object System.Collections.Generic.List[object]

foreach ($r in $roots) {
    $full = Join-Path $RepoRoot $r
    if (-not (Test-Path $full)) { Write-Warn "Not found, skipping: $r"; continue }

    if (Test-Path $full -PathType Container) {
        Get-ChildItem $full -Recurse -File | ForEach-Object {
            $rel = $_.FullName.Substring($RepoRoot.Length).TrimStart('\','/') -replace '\\','/'
            $files.Add([pscustomobject]@{ Local = $_.FullName; Rel = $rel; Size = $_.Length })
        }
    } else {
        $item = Get-Item $full
        $rel  = $item.FullName.Substring($RepoRoot.Length).TrimStart('\','/') -replace '\\','/'
        $files.Add([pscustomobject]@{ Local = $item.FullName; Rel = $rel; Size = $item.Length })
    }
}

# ---------------------------------------------------------------------------
# Guards. These encode the July 20 2026 failures.
# ---------------------------------------------------------------------------
$blocked = @()
$final   = New-Object System.Collections.Generic.List[object]

foreach ($f in $files) {
    $name = Split-Path $f.Rel -Leaf

    # Guard 1: browser download artifacts must never reach the server.
    if ($name -match '\(\d+\)') { $blocked += "$($f.Rel)  [browser (n) filename]"; continue }

    # Guard 2: backups and stray copies are local-only.
    if ($name -match '\.(old|bak|orig|rej)$' -or $name -match '\.pre-migration\.bak$') {
        $blocked += "$($f.Rel)  [backup file]"; continue
    }

    # Guard 3: never push secrets.
    if ($name -eq 'wp-config.php' -or $name -match '\.(env|pem|key)$') {
        $blocked += "$($f.Rel)  [secret]"; continue
    }

    # Guard 4: in mu-plugins, only push files we own.
    if ($f.Rel -match '^wp-content/mu-plugins/') {
        $sub = $f.Rel -replace '^wp-content/mu-plugins/',''
        if ($sub -notlike "$MuPluginPrefix*") { $blocked += "$($f.Rel)  [host-owned mu-plugin]"; continue }
    }

    # Guard 5: PHP syntax check when php is available locally.
    if ($name -match '\.php$' -and (Get-Command php -ErrorAction SilentlyContinue)) {
        $lint = & php -l $f.Local 2>&1
        if ($LASTEXITCODE -ne 0) { $blocked += "$($f.Rel)  [PHP SYNTAX ERROR: $lint]"; continue }
    }

    $final.Add($f)
}

# ---------------------------------------------------------------------------
# Report
# ---------------------------------------------------------------------------
Write-Head "SRJ deploy  ->  $Target  ($($Server.Url))"
Write-Host "  repo:   $RepoRoot"
Write-Host "  remote: $SshDest`:$($Server.RemoteRoot)"

if ($blocked.Count) {
    Write-Head "BLOCKED ($($blocked.Count))"
    $blocked | ForEach-Object { Write-Err $_ }
}

if (-not $final.Count) { Write-Head "Nothing to transfer."; exit 0 }

Write-Head "Files to transfer ($($final.Count))"
$final | ForEach-Object { Write-Host ("  {0,10:N0}  {1}" -f $_.Size, $_.Rel) }

if ($DryRun) { Write-Head "DRY RUN. Nothing was written."; exit 0 }

if ($Target -eq 'production') {
    Write-Head "This is PRODUCTION."
    $ans = Read-Host "  Type 'deploy' to continue"
    if ($ans -ne 'deploy') { Write-Warn "Aborted."; exit 0 }
}

# ---------------------------------------------------------------------------
# Transfer
# ---------------------------------------------------------------------------
Write-Head "Transferring"
$dirs = $final | ForEach-Object { Split-Path $_.Rel -Parent } | Where-Object { $_ } | Sort-Object -Unique
foreach ($d in $dirs) {
    $remoteDir = "$($Server.RemoteRoot)/$($d -replace '\\','/')"
    & ssh $SshDest "mkdir -p '$remoteDir'" | Out-Null
}

$sent = 0; $failed = @()
foreach ($f in $final) {
    $remotePath = "$($Server.RemoteRoot)/$($f.Rel)"
    & scp -q $f.Local "$SshDest`:$remotePath"
    if ($LASTEXITCODE -eq 0) { $sent++; Write-Ok "sent  $($f.Rel)" }
    else { $failed += $f.Rel; Write-Err "FAIL  $($f.Rel)" }
}

# ---------------------------------------------------------------------------
# Verify by size. This is the step today's outage needed.
# ---------------------------------------------------------------------------
if (-not $SkipVerify) {
    Write-Head "Verifying sizes on server"
    $mismatch = @()
    foreach ($f in $final) {
        if ($failed -contains $f.Rel) { continue }
        $remotePath = "$($Server.RemoteRoot)/$($f.Rel)"
        $remoteSize = (& ssh $SshDest "stat -c %s '$remotePath' 2>/dev/null || echo MISSING").Trim()
        if ($remoteSize -eq 'MISSING') { $mismatch += "$($f.Rel)  [not on server]" }
        elseif ([int64]$remoteSize -ne $f.Size) {
            $mismatch += "$($f.Rel)  [local $($f.Size) vs remote $remoteSize]"
        }
    }
    if ($mismatch.Count) {
        Write-Head "SIZE MISMATCH ($($mismatch.Count))"
        $mismatch | ForEach-Object { Write-Err $_ }
        Write-Err "Do not flush cache. Investigate before the site serves these files."
    } else {
        Write-Ok "All $sent file(s) match local size."
    }
}

# ---------------------------------------------------------------------------
Write-Head "Done. $sent sent, $($failed.Count) failed, $($blocked.Count) blocked."
Write-Host ""
Write-Host "  Next: flush the GoDaddy cache from the admin bar." -ForegroundColor Yellow
if ($final.Rel -match 'ai-governance-config|ai-glossary|ai-tools') {
    Write-Host "  Config-driven page changed: rebuild the Relevanssi index." -ForegroundColor Yellow
}
Write-Host "  Verify: $($Server.Url)" -ForegroundColor Yellow
Write-Host ""
