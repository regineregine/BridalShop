

(function($){
  $(function(){
    var $carousel = $('#featured-carousel');
    if (!$carousel.length) return;

    var $track = $carousel.find('.carousel-track');
    var $slides = $track.find('.carousel-slide');
    var $indicators = $carousel.find('.indicator');
    var total = $slides.length;
    var current = 0;
    var interval = 2000; 
    var timer = null;
    var animating = false;

    
    function setup(){
      $track.css({
        'width': (100 * total) + '%',
        'display': 'flex'
      });
      $slides.css({
        'width': (100 / total) + '%'
      });
      goTo(current, false);
    }

    function updateIndicators(){
      $indicators.removeClass('bg-white/90 scale-105').addClass('bg-white/50');
      $indicators.eq(current).removeClass('bg-white/50').addClass('bg-white/90');
    }

    function goTo(index, animated){
      if (index < 0) index = total - 1;
      if (index >= total) index = 0;
      current = index;
      var percent = -(100 / total) * index;
      if (!animated) {
        $track.css('transition-duration', '0ms');
      } else {
        $track.css('transition-duration', '700ms');
      }
      $track.css('transform', 'translateX(' + percent + '%)');
      updateIndicators();
    }

    function next(){
      goTo(current + 1, true);
    }

    function prev(){
      goTo(current - 1, true);
    }

    function startTimer(){
      stopTimer();
      timer = setInterval(function(){
        next();
      }, interval);
    }

    function stopTimer(){
      if (timer) {
        clearInterval(timer);
        timer = null;
      }
    }

    $carousel.find('#carousel-next').on('click', function(e){
      e.preventDefault();
      next();
      startTimer();
    });
    $carousel.find('#carousel-prev').on('click', function(e){
      e.preventDefault();
      prev();
      startTimer();
    });

    $indicators.on('click', function(){
      var idx = parseInt($(this).attr('data-slide'), 10);
      goTo(idx, true);
      startTimer();
    });

    var startX = null;
    $carousel.on('touchstart', function(e){
      var t = e.originalEvent.touches && e.originalEvent.touches[0];
      if (t) startX = t.clientX;
    });
    $carousel.on('touchend', function(e){
      if (startX === null) return;
      var t = e.originalEvent.changedTouches && e.originalEvent.changedTouches[0];
      if (!t) return;
      var diff = t.clientX - startX;
      if (Math.abs(diff) > 30) {
        if (diff < 0) { next(); } else { prev(); }
        startTimer();
      }
      startX = null;
    });

    $carousel.attr('tabindex', '0');
    $carousel.on('keydown', function(e){
      if (e.key === 'ArrowLeft') { prev(); startTimer(); }
      if (e.key === 'ArrowRight') { next(); startTimer(); }
    });

    setup();
    startTimer();

    $(window).on('resize', function(){
      setup();
    });

  });
})(jQuery);
