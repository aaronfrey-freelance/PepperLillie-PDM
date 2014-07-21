jQuery(function() {

  var myTimer;
  var interval = 5000;

  jQuery(window).load(function() {
    jQuery('#front-page .full-screen-container').fadeIn(1500);
    // run every 5s
    myTimer = setInterval(cycleImages, interval);
  });

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
  function cycleImages(reverse) {
    var $active = jQuery('#front-page .full-screen-container .active');
    var $next;

    if(reverse) {
      $next = (jQuery('#front-page .full-screen-container .active').prev().length > 0) ? jQuery('#front-page .full-screen-container .active').prev() : jQuery('#front-page .full-screen:last');
    } else {
      $next = (jQuery('#front-page .full-screen-container .active').next().length > 0) ? jQuery('#front-page .full-screen-container .active').next() : jQuery('#front-page .full-screen:first');
    }

    $next.css('z-index',2); //move the next image up the pile
    $active.fadeOut(1500,function() { //fade out the top image
      $active.css('z-index',1).show().removeClass('active'); //reset the z-index and unhide the image
      $next.css('z-index',3).addClass('active');//make the next image the top one
    });
  }

  if(jQuery('#front-page').length) {

    var bg_array = jQuery('.full-screen');
    total = bg_array.length;

    jQuery.each(bg_array, function() {
      var background = jQuery(this).data('background');
      jQuery(this).css('background-size', 'cover');
      jQuery(this).css('background-image', 'url(' + background + ')');
    });

    jQuery('.full-screen-controls a').on('click', function(e) {
      e.preventDefault();

      var btn = jQuery(this);
      if(total > 0) {
        clearInterval(myTimer);
        if(btn.hasClass('previous')) {
          cycleImages(true);
        } else if(btn.hasClass('next')) {
          cycleImages();
        }
        myTimer = setInterval(cycleImages, interval);
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
        var reset = totalWidth - viewWidth;
        if(remaining === 0) {
          sliderContent.animate({
            left: "-"+reset
          }, "fast", function() {
            // Animation complete.
          });
        } else {
          desiredSlide = fullImages * imageWidth;
          slide = remaining < desiredSlide ? remaining : desiredSlide;
          sliderContent.animate({
            left: "-=-"+slide
          }, 1000, function() {
            // Animation complete.
          });
        }
      } else if(btn.hasClass('right')) {
        // Calculate the remaining width left to slide
        remaining = totalWidth + currentLeft - viewWidth;
        if(remaining === 0) {
          sliderContent.animate({
            left: "0"
          }, "fast", function() {
            // Animation complete.
          });
        } else {
          desiredSlide = fullImages * imageWidth;
          slide = remaining < desiredSlide ? remaining : desiredSlide;
          sliderContent.animate({
            left: "+=-"+slide
          }, 1000, function() {
            // Animation complete.
          });
        }
      }
    });
  }

  // Show More Links
  jQuery('.show-more').on('click', function(e) {
    e.preventDefault();
    var link = jQuery(this);
    link.toggleClass('open');
    if(link.hasClass('open')) {
      link.text('Hide Menu');
    } else {
      link.text('Show Menu');
    }
    jQuery('.menu-dropdown').slideToggle();
  });

});