<header class="banner navbar navbar-default navbar-static-top" role="banner">

  <div class="container">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a href="#" class="mobile-search pull-right hidden-lg hidden-md">
        <span class="glyphicon glyphicon-search"></span>
      </a>

      <a class="navbar-brand" href="<?php echo home_url(); ?>/"></a>

    </div>

    <nav class="collapse navbar-collapse" role="navigation">

      <div class="hidden-sm hidden-xs">
      <?php get_search_form(); ?>
      </div>

      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation',
                            'menu_class' => 'nav navbar-nav'));
        endif;
      ?>

    </nav>

  </div>

  <div class="mobile-search-text hidden-md hidden-lg">
    <?php get_search_form(); ?>
  </div>

</header>
