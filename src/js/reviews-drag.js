(function($){
  $(function(){
    var $row = $('#reviews-row');
    if (!$row.length) return;
    var isDown = false, startX, scrollLeft;

    $row.on('mousedown', function(e){
      isDown = true;
      $row.addClass('cursor-grabbing');
      startX = e.pageX - $row.offset().left;
      scrollLeft = $row.scrollLeft();
      e.preventDefault();
    });
    $(document).on('mousemove', function(e){
      if (!isDown) return;
      var x = e.pageX - $row.offset().left;
      var walk = (startX - x);
      $row.scrollLeft(scrollLeft + walk);
    });
    $(document).on('mouseup', function(){
      isDown = false;
      $row.removeClass('cursor-grabbing');
    });

    $row.on('touchstart', function(e){
      isDown = true;
      startX = e.originalEvent.touches[0].pageX - $row.offset().left;
      scrollLeft = $row.scrollLeft();
    });
    $row.on('touchmove', function(e){
      if (!isDown) return;
      var x = e.originalEvent.touches[0].pageX - $row.offset().left;
      var walk = (startX - x);
      $row.scrollLeft(scrollLeft + walk);
    });
    $row.on('touchend touchcancel', function(){
      isDown = false;
    });

    function slideBy(dir) {
      var $items = $row.find('figure');
      var itemW = $items.first().outerWidth(true);
      var target = $row.scrollLeft() + dir * itemW;
      $row.animate({scrollLeft: target}, 500, 'swing');
    }
    $('#reviews-prev').on('click', function(e){ e.preventDefault(); slideBy(-1); });
    $('#reviews-next').on('click', function(e){ e.preventDefault(); slideBy(1); });
  });
})(jQuery);
