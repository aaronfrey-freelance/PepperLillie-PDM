<header class="banner navbar navbar-default navbar-static-top" role="banner">
  <div class="container">
    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a href="#" class="pull-right hidden-lg hidden-md">
        <span class="glyphicon glyphicon-search"></span>
      </a>

      <a class="navbar-brand" href="<?php echo home_url(); ?>/"></a>
    </div>

    <nav class="collapse navbar-collapse" role="navigation">

      <form role="search" method="get" class="navbar-form navbar-right hidden-sm hidden-xs" action="<?php echo home_url('/'); ?>">
        <div class="form-group">
          <span class="glyphicon glyphicon-search"></span>
          <label class="hide"><?php _e('Search for:', 'roots'); ?></label>
          <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="form-control" placeholder="Search...">
        </div>
        <button type="submit" class="hide btn btn-default"><?php _e('Search', 'roots'); ?></button>
      </form>

      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation',
                            'menu_class' => 'nav navbar-nav'));
        endif;
      ?>

    </nav>
  </div>
</header>
