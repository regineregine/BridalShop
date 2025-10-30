(function($){
  $(function(){
    var $nav = $('nav').first();
    if (!$nav.length) return;
    var shadowClass = 'shadow-md';
    function checkScroll(){
      if ($(window).scrollTop() > 10) {
        if (!$nav.hasClass(shadowClass)) $nav.addClass(shadowClass);
      } else {
        $nav.removeClass(shadowClass);
      }
    }
    checkScroll();
    $(window).on('scroll', checkScroll);
  });
})(jQuery);
