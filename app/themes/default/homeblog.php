<?php get_header() ?>

<div class="blog-header home" style="background-image: url(<?= blog_home_image_url() ?>)">

  <div class="wrapper">

    <h1 class="blog-title"><?= blog_home_title() ?></h1>

    <p class="lead blog-description"><?= blog_home_description() ?></p>

  </div>

</div>

<div class="container blog-main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php get_template_part('content'); ?>

<?php endwhile; else : ?>

    <p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

<?php previous_posts_link() ?>

<?php next_posts_link() ?>

</div>

<?php get_footer() ?>
