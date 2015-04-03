<?php get_header() ?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="blog-header single" style="background-image: url(<?= post_thumbnail_url() ?>)">
    <div class="wrapper">
       <?php single_post_date() ?>
       <h1 class="blog-title"><?= single_post_title() ?></h1>
       <?php single_post_shortlede() ?>
       <?php single_post_author() ?>
    </div>
</div>

<div class="blog-main single container" <?= single_wio_attributes() ?>>

    <?php the_content() ?>

    <?php previous_post_link() ?>

    <?php next_post_link() ?>

</div>

<?php endwhile; ?>

<footer class="blog-footer single">
    <?php single_prev_post_link() ?>
    <?php single_next_post_link() ?>
</footer>

<!-- Prismic toolbar -->
<script src="//www.google-analytics.com/cx/api.js?experiment=<?=current_experiment_id()?>"></script>
<script src="//static.cdn.prismic.io/prismic.min.js"></script>
<?php if(current_experiment_id()) { ?>
<script>prismic.startExperiment("<?=current_experiment_id()?>", cxApi);</script>
<?php }?>

<!-- Hamburger menu -->
<script src="/app/static/jquery.panelslider.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#menu-hamburger').panelslider({side: 'right', duration: 200 });
  });
</script>
