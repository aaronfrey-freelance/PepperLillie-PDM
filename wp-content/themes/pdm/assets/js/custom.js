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

  /* Project Slider */

  // If there are images present
  if(jQuery('#ngg-image-0').length) {

    jQuery('.advance-bar, .advance-arrow').on('click', function(e) {
      var btn = jQuery(this);
      var sliderViewable = jQuery('.slider-content');
      var sliderContent = jQuery('.ngg-galleryoverview');
      var imageWidth = jQuery('#ngg-image-0').outerWidth(true);

      // Get the width of the viewable slider window
      var viewWidth = sliderViewable.width();

      // Calculate how many full images are present
      var fullImages = Math.floor(viewWidth / imageWidth);

      // Get the width of the total slideshow
      var totalWidth = jQuery('.ngg-gallery-thumbnail-box').length * imageWidth;

      // Get the current left position of the slider
      var currentLeft = jQuery('.ngg-galleryoverview').position().left;

      var remining = 0;
      var slide = 0;
      var desiredSlide = 0;

      if(btn.hasClass('left')) {
        remaining = Math.abs(currentLeft);
        desiredSlide = fullImages * imageWidth;
        slide = remaining < desiredSlide ? remaining : desiredSlide;
        sliderContent.animate({
          left: "-=-"+slide
        }, 1000, function() {
          // Animation complete.
        });
      } else if(btn.hasClass('right')) {
        // Calculate the remaining width left to slide
        remaining = totalWidth + currentLeft - viewWidth;
        desiredSlide = fullImages * imageWidth;
        slide = remaining < desiredSlide ? remaining : desiredSlide;
        sliderContent.animate({
          left: "+=-"+slide
        }, 1000, function() {
          // Animation complete.
        });
      }

    });
  }
});