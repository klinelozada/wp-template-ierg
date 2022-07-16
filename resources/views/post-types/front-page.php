<?php
  $this->layout('main');

  global $post;

  $recent_posts = get_posts( array(
    'posts_per_page' => 5,
  ) );

  //recent discussions
  // https://wordpress.stackexchange.com/questions/222636/wp-query-posts-with-comments-only
  function my_has_comments_filter( $where ) {
    $where .= ' AND comment_count > 0 ';
    return $where;
  }
  add_filter( 'posts_where', 'my_has_comments_filter' );
  $discussions = new WP_Query( array(
    'post_type' => 'post',
    'posts_per_page' => 5,
    'order' => 'dsc',
  ) );
  // Don't filter future queries.
  remove_filter( 'posts_where', 'my_has_comments_filter' );




    $events = sugar_calendar_get_events(
      array(
        'display'         => 'upcoming',
        'order'           => '',
        'number'          => '5',
        'category'        => null,
        'show_date'       => null,
        'show_time'       => null,
        'show_categories' => null,
        'show_link'       => null,
      )
    );


?>


<div class="row my-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Recent News
                <a class="action float-end" href="/news">View all</a>
            </div>

            <div class="list-group list-group-flush">


              <?php

                if ( $recent_posts ):
                  foreach ( $recent_posts as $post ) :
                    setup_postdata( $post ); ?>
                      <a class="list-group-item" href="<?php the_permalink(); ?>">
                          <div class="featured float-start"><?php the_post_thumbnail(); ?></div>
                        <?php the_title(); ?><br/>
                          <span>
                              <small class="text-muted">
                                <?php the_date(); ?>
                            </small>
                            </span>
                      </a>
                  <?php
                  endforeach;
                  wp_reset_postdata();
                endif;
              ?>




            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Upcoming Events
                <a class="action float-end" href="/calendar">View all</a>
            </div>

            <div class="list-group list-group-flush">
             <?php echo sc_get_events_list_card(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Recent Discussions
                <a class="action float-end" href="/news">View all</a>
            </div>

            <div class="list-group list-group-flush">

              <?php

                if ( $discussions ):
                  while ( $discussions->have_posts() ):
                  $discussions->the_post();
                  ?>
                      <a class="list-group-item" href="<?php the_permalink(); ?>">
                          <span class="float-md-end">
                            <small class="text-muted">
                              <?php echo get_comments_number(); ?> comments
                            </small>
                          </span>
                          <div class="featured float-start"><?php the_post_thumbnail(); ?></div>
                        <?php the_title(); ?><br/>

                          <span>
                              <small class="text-muted">
                                <?php the_date(); ?>
                            </small>
                        </span>

                      </a>
                  <?php
                  endwhile;
                  wp_reset_postdata();
                endif;
              ?>




            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                IERG Staff
                <a class="action float-end" href="/companies/24815/">View all</a>
            </div>


              <?php

                $members = new WP_User_Query(
                  array(
                    'meta_key' => 'company',
                    'meta_value' => 24815
                  )
                );
                ?>

                <ul class="list-group list-group-flush">
                  <?php
                    if ( ! empty( $members->get_results() ) ) {
                      foreach ( $members->get_results() as $user ) {
                        echo '<li class="list-group-item position-relative"><a class="stretched-link" href="/members/' .$user->ID. '">' . $user->first_name . ' ' . $user->last_name . '</a></li>';
                      }
                    } else {
                      echo '<li class="list-group-item">No users found</li>';
                    }
                  ?>
                </ul>
        </div>
    </div>
</div>
