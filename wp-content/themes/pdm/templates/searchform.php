<form role="search" method="get" class="navbar-form navbar-right" action="<?php echo home_url('/'); ?>">
  <div class="form-group">
    <span class="glyphicon glyphicon-search hidden-sm hidden-xs"></span>
    <label class="hide"><?php _e('Search for:', 'roots'); ?></label>
    <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="form-control" placeholder="Search...">
  </div>
  <button type="submit" class="hide btn btn-default"><?php _e('Search', 'roots'); ?></button>
</form>