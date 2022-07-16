<?php
  $this->layout('main');
?>

  <?php while(have_posts()) : the_post() ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php the_content(); ?>
    </div>
  <?php endwhile; ?>