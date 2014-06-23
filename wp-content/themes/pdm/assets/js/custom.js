$(function() {

  var center_content_height = $('.center-content').outerHeight();
  var padding_bottom = $('.center-content').css('padding-bottom');

  $('aside.sidebar').height(center_content_height);
  $('aside.sidebar').css('margin-bottom', -parseInt(padding_bottom, 10));

});