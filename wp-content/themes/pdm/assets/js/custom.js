$(function() {

  function resizeSidebar() {
    var center_content_height = $('.center-content').outerHeight();
    var padding_bottom = $('.center-content').css('padding-bottom');

    if(center_content_height > $('aside.sidebar').outerHeight()) {
      $('aside.sidebar').height(center_content_height);
      $('aside.sidebar').css('margin-bottom', -parseInt(padding_bottom, 10));
    } else {
      $('aside.sidebar').height('auto');
    }
  }

  resizeSidebar();

  // $(window).resize(function() {
  //   resizeSidebar();
  // });

  /* Teaser Links */
  $('#teaser-links li').on('click', function(e) {
    e.preventDefault();

    $('#white-box').show();
    $('#blue-box').hide();

    var btn = $(this);
    btn.siblings('li').removeClass('active');
    btn.addClass('active');

    var pane = btn.find('a').data('type');

    $('#'+pane).show().siblings('div').hide();
  });

  // Resize project Images
  $(window).resize(function() {
    // Get project images
    $('div.project-image').each(function( index ) {
      var container = $(this);
      var containerRatio = container.height() / container.width();
      var img = container.find('img');
      var imgRatio = img.height() / img.width();

      if(containerRatio > imgRatio) {
        img.css('height', '100%');
        img.css('width', 'auto');
      } else {
        img.css('height', 'auto');
        img.css('width', '100%');
      }
    });

  });

});