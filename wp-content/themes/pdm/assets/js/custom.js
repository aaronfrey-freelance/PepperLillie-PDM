jQuery(function() {

  function resizeSidebar() {
    var center_content_height = jQuery('.center-content .main').outerHeight();

    if(center_content_height > jQuery('aside.sidebar').outerHeight()) {
      jQuery('aside.sidebar').height(center_content_height + 50);
    } else {
      jQuery('aside.sidebar').height('auto');
    }
  }

  resizeSidebar();

  // jQuery(window).resize(function() {
  //   resizeSidebar();
  // });

  /* Teaser Links */
  jQuery('#teaser-links li').on('click', function(e) {
    e.preventDefault();

    jQuery('#white-box').show();
    jQuery('#blue-box').hide();

    var btn = jQuery(this);
    btn.siblings('li').removeClass('active');
    btn.addClass('active');

    var pane = btn.find('a').data('type');

    jQuery('#'+pane).show().siblings('div').hide();
  });

  // Resize project Images
  jQuery(window).resize(function() {
    // Get project images
    jQuery('div.project-image').each(function( index ) {
      var container = jQuery(this);
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