jQuery(function() {

  // Mobile Search Dropdown
  jQuery('.mobile-search').on('click', function(e) {
    e.preventDefault();
    jQuery('.mobile-search-text').slideToggle();
  });


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

  jQuery('div.project-image').imgLiquid();

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

    var title = $next.data('title');
    var location = $next.data('location');

    jQuery('.project-info').fadeOut(500,function() {
      jQuery('#project-title').text(title);
      jQuery('#project-location').text(location);
    }).fadeIn(500);

    $next.css('z-index',2); //move the next image up the pile
    $active.fadeOut(1000,function() { //fade out the top image
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
  var sliderViewable = jQuery('.slider-content');
  var sliderContent = jQuery('.ngg-galleryoverview');
  var imageWidth = jQuery('#ngg-image-0').outerWidth(true);

  function getFullImages(getWidth) {
    // Get the width of the viewable slider window
    var viewWidth = sliderViewable.width();

    // Calculate how many full images are present
    var fullImages = Math.floor(viewWidth / imageWidth);

    return getWidth ? fullImages * imageWidth : fullImages;
  }

  // If there are images present
  if(jQuery('#ngg-image-0').length) {

    // Remove unneeded elements
    jQuery('.slideshowlink').remove();
    jQuery('.ngg-clear').remove();

    // Set the minimum amount fo images
    var minimum = 16;
    var images = sliderContent.find('.ngg-gallery-thumbnail-box');
    var totalImages = images.length;

    while(totalImages < minimum) {
      images.clone().appendTo(sliderContent);
      totalImages = totalImages + images.length;
    }

    // Set the left to negative width of full images shown
    sliderContent.css('left', -getFullImages(true));

    jQuery('.advance-bar, .advance-arrow').on('click', function(e) {
      var btn = jQuery(this);

      // Get the width of the viewable slider window
      var viewWidth = sliderViewable.width();

      // Calculate how many full images are present
      var fullImages = getFullImages();

      // Get the width of the total slideshow
      var totalWidth = jQuery('.ngg-gallery-thumbnail-box').length * imageWidth;

      // Get the current left position of the slider
      var currentLeft = jQuery('.ngg-galleryoverview').position().left;

      if(btn.hasClass('left')) {
        sliderContent.animate({
          left: parseInt(jQuery('.ngg-galleryoverview').css('left'), 10) + getFullImages(true)
        }, 1000, function() {
          /* when sliding to left we are moving the last item before the first item */
          jQuery('.ngg-galleryoverview div.ngg-gallery-thumbnail-box:first').before(jQuery('.ngg-galleryoverview > div.ngg-gallery-thumbnail-box:gt('+-parseInt(fullImages+1)+')'));
          /* and again, when we make that change we are setting the left indent of our unordered list to the default -210px */
          jQuery('.ngg-galleryoverview').css({'left' : -getFullImages(true)});
        });
      } else if(btn.hasClass('right')) {
        sliderContent.animate({
          left: "+=-"+getFullImages(true)
        }, 1000, function() {
          // Get the first n divs and put them after the last div
          jQuery('.ngg-galleryoverview div.ngg-gallery-thumbnail-box:last').after(jQuery('.ngg-galleryoverview div.ngg-gallery-thumbnail-box:lt('+fullImages+')'));
          // Set the left indent to the default 0
          jQuery('.ngg-galleryoverview').css({'left' : -getFullImages(true)});
        });
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

  if(!jQuery('#ngg-image-0').length) {
    jQuery('.open-gallery').hide();
  }

  // Open the Project gallery on mobile
  jQuery('.open-gallery').on('click', function(e) {
    e.preventDefault();
    jQuery('#ngg-image-0').find('a').click();
  });
});