
(function($){
  $(function(){
    var selector = '.scroll-fade, section, .card, img, h1, h2, h3, h4, h5, h6, p, button, .btn-primary, .btn-secondary';
    var $targets = $(selector).not('.scroll-fade-init');
    $targets.each(function(){
      var $el = $(this);
      $el.addClass('opacity-0 translate-y-10 transition-all duration-700 ease-in-out scroll-fade-init');
    });
    function reveal(){
      $targets.each(function(){
        var $el = $(this);
        if ($el.hasClass('active')) return;
        var rect = this.getBoundingClientRect();
        if (rect.top < window.innerHeight - 40) {
          $el.addClass('active opacity-100 translate-y-0').removeClass('opacity-0 translate-y-10');
        }
      });
    }
    $(window).on('scroll resize', reveal);
    $(window).on('load', reveal);
    setTimeout(reveal, 100); 
  });
})(jQuery);
