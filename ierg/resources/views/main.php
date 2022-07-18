<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>




<div class="container-fluid min-vh-100">
    <div class="row min-vh-100">
        <div id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar p-0 min-vh-100">
            <div class="sticky-md-top">
                <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                    <img src="<?php echo get_template_directory_uri(); ?>/public/img/logo.png">
                </a>

                <?php
                    wp_nav_menu( array(
                    'theme_location'  => 'main',
                    'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                    'container'       => 'div',
                    'container_class' => '',
                    'container_id'    => 'sidebar-nav',
                    'menu_class'      => 'nav flex-column',
                    //'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                    //'walker'          => new WP_Bootstrap_Navwalker(),
                    ) );
                ?>
            </div>
        </div>
        <div id="main" class="col-md-9 ms-sm-auto col-lg-10 p-0">

            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <div class="navbar-brand">
                      <?php
                        if(isset($topbar)){
                            echo $topbar;
                        } elseif(is_front_page()){
                            echo 'Dashboard';
                        }elseif(get_post_type() == 'page'){
                          the_title();
                        } elseif(get_post_type() == 'post'){
                          echo 'News';
                        } elseif(get_post_type() == 'survey'){
                          echo 'Surveys';
                        }

                        ?>
                    </div>
                    <div class="d-flex">
<!--                        <form>-->
<!--                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="s" id="s">-->
<!--                        </form>-->
<!--                        <div class="collapse navbar-collapse" id="navbarNav">-->
<!--                            <ul class="navbar-nav">-->
<!--                                <li class="nav-item">-->
<!--                                    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Disabled</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
                    </div>

                </div>
            </nav>

            <div class="container-fluid py-md-4 px-md-5">
              <div class="row">
                    <div class="col-md-9">
                      <div id="content">
                        <?php $this->yield('main'); ?>
                      </div>
                    </div>
                  <div id="ads" class="col-md-3">
                    <?php echo tr_view('components/ads'); ?>
                  </div>
              </div>
            </div>

        </div>
    </div>
</div>

<?php wp_footer(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>