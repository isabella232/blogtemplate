<?php get_header() ?>

<div class="blog-author-header">
    <div class="container">
        <div class="author-image" style="background-image: url(<?= single_author_image_url() ?>)"></div>
        <h1 class="author-name-title"><?= single_author_name() ?></h1>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12 blog-main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php get_template_part('content'); ?>
<?php endwhile; else : ?>
<?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer() ?>
