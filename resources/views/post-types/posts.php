<?php
  $this->layout('main');
?>

<div class="posts shadow-container">
    <?php while(have_posts()) : the_post() ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class('post container-fluid py-5 px-6'); ?>>
            <div class="row">
                <?php $thumb = get_the_post_thumbnail(); ?>

                <?php if($thumb): ?>
                    <div class="col-md-3">
                        <?php the_post_thumbnail(); ?>
                    </div>
                <?php endif; ?>

                <div class="col <?php if($thumb): ?> col-md-9<?php endif; ?>">


                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="date">
                      <?php the_date(); ?>
                    </div>

                    <?php the_excerpt(); ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
