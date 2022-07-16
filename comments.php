<div id="comments" class="comments-area">

  <?php if ( have_comments() ) : ?>
    <h3 class="comments-title">
      Discussion
    </h3>

    <ol class="comment-list">
      <?php
        wp_list_comments( array(
          'style'       => 'ul',
          'short_ping'  => true,
          'avatar_size' => 32,
        ) );
      ?>
    </ol><!-- .comment-list -->

  <?php endif; // have_comments() ?>

  <?php comment_form(); ?>

</div><!-- #comments -->