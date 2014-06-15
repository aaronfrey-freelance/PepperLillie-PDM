$(function() {

    // If the Category Sidebar is present
    if($('#sidebar-category').length) {

      // Set the first link to be active
      $('#sidebar-category').find('li:first').addClass('active');
    }

    // Functionality for the article sidebar
    $(document).on('click', 'li.post', function(e) {

      e.preventDefault();

      var li = $(this);

      // Set this link to active and all others to inactive
      li.addClass('active').siblings('li').removeClass('active');

      // Get the post ID
      var post_id = li.data('post-id');

      // Find the article with this ID and show it, while hiding all other articles
      $('article.'+post_id).show().siblings('article').hide();
    });

});