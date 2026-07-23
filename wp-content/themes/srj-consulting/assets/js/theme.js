(function(){
  'use strict';

  /* Floating CTA: show after hero, hide near footer / final CTA */
  function initFloatingCta(){
    var fc = document.getElementById('floatingCta');
    if(!fc) return;
    var hero = document.querySelector('.page-hero, .hero');
    var ctaSection = document.getElementById('contact');
    var footer = document.querySelector('footer');

    function update(){
      var scrolled = window.scrollY > (hero ? hero.offsetHeight * 0.6 : 400);
      var nearFooter = false;
      if(ctaSection){
        var rect = ctaSection.getBoundingClientRect();
        if(rect.top < window.innerHeight * 0.85) nearFooter = true;
      }
      if(footer){
        var rect2 = footer.getBoundingClientRect();
        if(rect2.top < window.innerHeight * 0.9) nearFooter = true;
      }
      if(scrolled && !nearFooter){
        fc.classList.add('is-visible');
      } else {
        fc.classList.remove('is-visible');
      }
    }
    window.addEventListener('scroll', update, {passive:true});
    window.addEventListener('resize', update);
    update();
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', initFloatingCta);
  } else {
    initFloatingCta();
  }
})();
