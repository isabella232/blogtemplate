
<div class="blog-post">
    <h2 class="blog-post-title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    <p class="blog-post-meta">
        <span class="fa fa-calendar" aria-hidden="true"></span> <?= the_date_link() ?>
        <span class="fa fa-user" aria-hidden="true"></span> <?= the_author_link() ?>
        <span class="fa fa-folder-open" aria-hidden="true"></span> <?php the_category(', ') ?>
        <span class="fa fa-tags" aria-hidden="true"></span> <?php the_tags('', ', ') ?>
    </p>

    <div class="post-thumbnail">
        <?php the_post_thumbnail('medium') ?>
    </div>
    <?php the_excerpt() ?>
</div>