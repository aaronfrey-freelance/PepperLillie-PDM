$(function() {

  var center_content_height = $('.center-content').outerHeight();
  var padding_bottom = $('.center-content').css('padding-bottom');

  $('aside.sidebar').height(center_content_height);
  $('aside.sidebar').css('margin-bottom', -parseInt(padding_bottom, 10));

  /* Teaser Links */
  $('#teaser-links a').on('click', function(e) {
    e.preventDefault();

    $('#white-box').show();
    $('#blue-box').hide();

    var btn = $(this);
    btn.parent('li').siblings('li').removeClass('active');
    btn.parent('li').addClass('active');
  });

});