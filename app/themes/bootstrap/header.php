<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= single_post_title() ?> <?= site_title() ?></title>
    <link rel="alternate" type="application/rss+xml" title="<?= site_title() ?>'s Feed" href="/feed" />
    <!-- Theme: WP Bootstrap -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/app/themes/bootstrap/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="blog-masthead">
    <div class="container">
        <nav class="blog-nav">
            <div class="navbar-form navbar-right">
                <?php get_search_form() ?>
            </div>
            <ul>
                <li class="blog-nav-item"><?= home_link('Home') ?></li>
                <?php foreach(get_pages() as $page) { ?>
                    <?php if(count($page['children']) > 0) { ?>
                        <li class="blog-nav-item dropdown">
                            <?= page_link($page) ?>
                            <ul class="dropdown-menu">
                                <?php foreach($page['children'] as $subpage) { ?>
                                    <?= page_link($subpage) ?>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="blog-nav-item">
                            <?= page_link($page) ?>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>

<div class="container">

    <div class="blog-header">
        <h1 class="blog-title"><?= site_title() ?></h1>
        <p class="lead blog-description"><?= site_description() ?></p>
    </div>

    <div class="row">

        <div class="col-sm-8 blog-main">
