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

  jQuery(document).click(function(e) {
      var isTeaserLinks = !jQuery(e.target).parents('ul#teaser-links').length;
      var isWhiteBox = !jQuery(e.target).parents('div#white-box').length;
      if(isTeaserLinks && isWhiteBox) {
        jQuery('#white-box').hide();
        jQuery('#blue-box').show();
      }
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

  // Projects Dropdown Menu
  jQuery('.dropdown-menu').addClass('hidden-sm hidden-xs');

  jQuery('.dropdown').on('mouseover', function(e) {
    jQuery(this).addClass('open');
  });

  jQuery('.dropdown').on('mouseout', function(e) {
    jQuery(this).removeClass('open');
  });

  // Front Page Full Size Slider

  var total = 0;
  var current = 0;

  function processBg(full_screen, fade) {
    // Get all the parameters
    var background = jQuery(full_screen).data('background');
    var title = jQuery(full_screen).data('title');
    var location = jQuery(full_screen).data('location');
    var page = jQuery('#front-page');

    if(!fade) {
      jQuery('#project-title').text(title);
      jQuery('#project-location').text(location);
      page.css('background-size', 'cover');
      page.css('background-image', 'url(' + background + ')');
    } else {
      page.fadeOut("slow", function() {
        jQuery('#project-title').text(title);
        jQuery('#project-location').text(location);
        page.css('background-size', 'cover');
        page.css('background-image', 'url(' + background + ')');
      }).fadeIn();
    }
  }

  function getPrevious() {
    if(current === 0) {
      current = total - 1;
    } else {
      current = current - 1;
    }
  }

  function getNext() {
    if(current === total - 1) {
      current = 0;
    } else {
      current = current + 1;
    }
  }

  if(jQuery('#front-page').length) {

    var bg_array = jQuery('.full-screen');
    total = bg_array.length;

    processBg(bg_array[current], false);

    jQuery('.full-screen-controls a').on('click', function(e) {
      e.preventDefault();

      var btn = jQuery(this);
      if(total > 0) {
        if(btn.hasClass('previous')) {
          getPrevious();
        } else if(btn.hasClass('next')) {
          getNext();
        }
        processBg(bg_array[current], true);
      }
    });
  }

});