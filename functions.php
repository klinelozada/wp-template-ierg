<?php
// Composer
if(file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

// Define Theme Directory
define('THEME_URI', get_template_directory_uri() );

$manifest = \TypeRocket\Utility\Manifest::cache(
    __DIR__ . '/public/mix-manifest.json',
    'theme'
);

// Theme Assets
add_action('wp_enqueue_scripts', function() use ($manifest) {
    wp_enqueue_style( 'main-style', THEME_URI . '/public' . $manifest['/theme/theme.css'] );
    wp_enqueue_script( 'main-script', THEME_URI . '/public' . $manifest['/theme/theme.js'], [], false, true );
});

// Admin Assets
add_action('admin_enqueue_scripts', function() use ($manifest) {
    wp_enqueue_style( 'admin-style', THEME_URI . '/public' . $manifest['/admin/admin.css'] );
    wp_enqueue_script( 'admin-script', THEME_URI . '/public' . $manifest['/admin/admin.js'], [], false, true );
});

// Supports
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );
register_nav_menu( 'main', 'Main Menu' );

  add_action('after_setup_theme', 'remove_admin_bar');
  function remove_admin_bar() {
    if (current_user_can('administrator')) {
      show_admin_bar(true);
    }
  }

// Templates
apply_filters( 'comments_template', function() {
    return tr_views_path('comments.php');
});


  /**
   * Register Custom Navigation Walker
   */
  function register_navwalker(){
    require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
  }
  add_action( 'after_setup_theme', 'register_navwalker' );

  // https://wordpress.stackexchange.com/questions/307650/highlight-current-post-ancestor-parent-menu-items
  add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );
  function add_menu_parent_class( $items ) {

    $parents = array();
    foreach ( $items as $item ) {
      if ( in_array('current-post-ancestor', $item->classes)  ) {
        $parents[] = $item->menu_item_parent;
      }
    }

    foreach ( $items as $item ) {
      if ( in_array( $item->ID, $parents ) ) {
        $item->classes[] = 'current-menu-ancestor';
      }
    }

    return $items;
  }


  /**
   * Sugar Calendar Legacy Theme Event List.
   *
   * @since 1.0.0
   */

// Exit if accessed directly
  defined('ABSPATH') || exit;

  /**
   * Get a formatted list of upcoming or past events from today's date.
   *
   * @param string $display
   * @param null   $category
   * @param int    $number
   * @param array  $show
   *
   * @return string
   * @since 1.0.0
   * @see   sc_events_list_widget
   *
   */
  function sc_get_events_list_card($display = 'upcoming', $category = null, $number = 5, $show = array(), $order = '')
  {

    // Get today, to query before/after
    $today = sugar_calendar_get_request_time('mysql');

    // Mutate order to uppercase if not empty
    if (!empty($order))
    {
      $order = strtoupper($order);
    } else
    {
      $order = ('past' === $display)
        ? 'DESC'
        : 'ASC';
    }

    // Maybe force a default
    if (!in_array(strtoupper($order), array('ASC', 'DESC'), true))
    {
      $order = 'ASC';
    }

    // Upcoming
    if ('upcoming' === $display)
    {
      $args = array(
        'object_type' => 'post',
        'status'      => 'publish',
        'orderby'     => 'start',
        'order'       => $order,
        'number'      => $number,
        'end_query'   => array(
          'inclusive' => true,
          'after'     => $today
        )
      );

      // Past
    } elseif ('past' === $display)
    {
      $args = array(
        'object_type' => 'post',
        'status'      => 'publish',
        'orderby'     => 'start',
        'order'       => $order,
        'number'      => $number,
        'end_query'   => array(
          'inclusive' => true,
          'before'    => $today
        )
      );

      // All events
    } else
    {
      $args = array(
        'object_type' => 'post',
        'status'      => 'publish',
        'orderby'     => 'start',
        'order'       => $order,
        'number'      => $number
      );
    }

    // Get the IDs
    $pt = sugar_calendar_get_event_post_type_id();
    $tax = sugar_calendar_get_calendar_taxonomy_id();

    // Maybe filter by taxonomy term
    if (!empty($category))
    {
      $args[$tax] = $category;
    }

    // Do not query for all found rows
    $r = array_merge($args, array(
      'no_found_rows' => true
    ));

    // Query for events
    $events = sugar_calendar_get_events($r);

    // Bail if no events
    if (empty($events))
    {
      return '';
    }

    // Start an output buffer to store these result
    ob_start();

    do_action('sc_before_events_list');

    // Start an unordered list
    //echo '<ul class="sc_events_list">';

    // Loop through all events
    foreach ($events as $event)
    {

      // Get the object ID and use it for the event ID (for back compat)
      $event_id = $event->object_id;

      //echo '<li class="' . str_replace('hentry', '', implode(' ', get_post_class($pt, $event_id))) . '">';

      do_action('sc_before_event_list_item', $event_id);

      echo '<a href="' . get_permalink($event_id) . '" class="sc_event_link list-group-item">';
      echo '<span class="sc_event_title">' . get_the_title($event_id) . '</span>';


        $date_tag = sugar_calendar_get_time_tag(array(
          'time'     => $event->start,
          'timezone' => $event->start_tz,
          'format'   => sc_get_date_format(),
          'dtformat' => 'Y-m-dO'
        ));
        echo '<br/><span><small class="text-muted">';
        echo '<span class="sc_event_date">' . $date_tag . '</span>';




      if (isset($show['time']) && $show['time'])
      {
        $start_time = sc_get_event_start_time($event_id);
        $end_time = sc_get_event_end_time($event_id);
        $tf = sc_get_time_format();

        // Output all day
        if ($event->is_all_day())
        {
          echo '<span class="sc_event_time">' . esc_html__('All-day', 'sugar-calendar') . '</span>';

          // Output both
        } elseif ($end_time !== $start_time)
        {

          $start_tag = sugar_calendar_get_time_tag(array(
            'time'     => $event->start,
            'timezone' => $event->start_tz,
            'format'   => $tf
          ));

          $end_tag = sugar_calendar_get_time_tag(array(
            'time'     => $event->end,
            'timezone' => $event->end_tz,
            'format'   => $tf
          ));

          echo '<span class="sc_event_time">' . $start_tag . '&nbsp;&ndash;&nbsp;' . $end_tag . '</span>';

          // Output only start
        } elseif (!empty($start_time))
        {

          $start_tag = sugar_calendar_get_time_tag(array(
            'time'     => $event->start,
            'timezone' => $event->start_tz,
            'format'   => $tf
          ));

          echo '<span class="sc_event_time">' . $start_tag . '</span>';
        }
      }

      echo '</small></span>';

      if (!empty($show['categories']))
      {
        $event_categories = get_the_terms($event_id, $tax);

        if ($event_categories)
        {
          $categories = wp_list_pluck($event_categories, 'name');
          echo '<span class="sc_event_categories">' . join($categories, ', ') . '</span>';
        }
      }

      do_action('sc_after_event_list_item', $event_id);

      echo '</a>';

    }

    // Close the list
    //echo '</ul>';

    // Reset post data - we'll be looping through our own
    wp_reset_postdata();

    do_action('sc_after_events_list');

    // Return the current buffer and delete it
    return ob_get_clean();
  }


//  POST TYPES

  $cptCompany = tr_post_type('Company');
  $cptCompany ->setSupports(['title', 'thumbnail']);

//  $cptCompany->setTitleForm(function(){
//    $form = tr_form();
//    echo $form->text('Author');
//  });

  $cmbCompanyDetails = tr_meta_box('Company Details');
  $cmbCompanyDetails->addScreen('company');
  $cmbCompanyDetails->setCallback(function(){
    $form = tr_form();

    $repeater = $form->repeater('Locations')->setFields([
      $form->text('Location Name'),
      $form->location('Address'),
      $form->input('Phone')->setType('tel'),
      $form->input('Email')->setType('email'),
    ]);

    echo $repeater;
  });


  //USER PROFILES

  add_action('typerocket_user_fields', function($form) {
//    $company = new \App\Models\Company();
//    $companies = $company->findAll()->published()->get();
//
//    foreach($companies as $company){
//
//    }

    $form->select('Gender')->setOptions($options);

    //$model_class = '\App\Models\Company';
    echo $form->search('Company')->setPostTypeOptions('company'); //->setModelOptions($model_class);
    echo $form->text('Position');
    echo $form->input('Phone')->setType('tel');
    echo $form->textarea('Address');
  });


  // 