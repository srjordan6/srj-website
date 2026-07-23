<?php
/**
 * Service detail sidebar renderer.
 * Renders the sticky aside listing sibling services in the current pillar.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function srj_render_service_aside( $section, $current_slug ) {
    $home = trailingslashit( home_url() );
    $business_services = array(
        array( '01', 'AI Business Enablement Audit', 'ai-business-enablement-audit' ),
        array( '02', 'AI Readiness & Performance Assessment', 'ai-readiness-performance' ),
        array( '03', 'AI Risk & Governance Review', 'ai-risk-governance-review' ),
        array( '04', 'AI Efficiency & Process Optimization', 'ai-efficiency-process' ),
    );
    $security_services = array(
        array( '01', 'AI IT Security Audit', 'ai-it-security-audit' ),
        array( '02', 'AI IT Security Implementation & Strategy', 'ai-security-implementation' ),
    );
    $services = $section === 'business' ? $business_services : $security_services;
    $section_title = $section === 'business' ? 'AI Business Services' : 'AI Risk Governance & Security';
    $pillar = $section === 'business' ? 'business-services' : 'risk-governance-security';
    ?>
    <aside class="service-aside">
      <h4><?php echo esc_html( $section_title ); ?></h4>
      <ul>
        <?php foreach ( $services as $svc ) :
            list( $num, $title, $slug ) = $svc;
            $is_current = ( $slug === $current_slug );
        ?>
        <li<?php echo $is_current ? ' class="is-current"' : ''; ?>>
          <?php if ( $is_current ) : ?>
            <?php echo esc_html( $num . '. ' . $title ); ?>
          <?php else : ?>
            <a href="<?php echo esc_url( $home . 'services/' . $pillar . '/' . $slug . '/' ); ?>" style="color:inherit;text-decoration:none"><?php echo esc_html( $num . '. ' . $title ); ?></a>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
      <a href="<?php echo esc_url( srj_get_booking() ); ?>" target="_blank" rel="noopener" class="aside-cta">Schedule a Free AI Consultation</a>
    </aside>
    <?php
}
