<?php
  $this->layout('main');
?>


<?php while(have_posts()) : the_post() ?>
  <div id="post-<?php the_ID(); ?>" <?php post_class('post container-fluid py-5 px-5 shadow-container'); ?>>
         <div class="featured float-end"><?php the_post_thumbnail(); ?></div>
        <h1><?php the_title(); ?></h1>
      <div class="date">
        <?php the_date(); ?>
      </div>

      <?php the_content(); ?>
  </div>

  <?php echo tr_view('components/comments'); ?>

<?php endwhile; ?>