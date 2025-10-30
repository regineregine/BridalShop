$(document).ready(function () {
  var path = window.location.pathname;
  var page = path.substring(path.lastIndexOf('/') + 1);

  if (page === '' || page === 'index.php') page = 'home.php';

  var activeClass = 'text-pink-500 border-b-2 border-pink-500 pb-1 transition-all duration-300 ease-in-out';
  var activeClasses = activeClass.split(' ');

  $('#nav-menu a').each(function () {
    var $link = $(this);
    var href = $link.attr('href');
    if (!href) return;
    var hrefPage = href.substring(href.lastIndexOf('/') + 1);

    $link.removeClass(activeClasses.join(' '));

    if (hrefPage === page) {
      $link.addClass(activeClasses.join(' '));
    }
  });
});