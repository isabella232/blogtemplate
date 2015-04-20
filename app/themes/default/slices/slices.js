$(function(){

  "use strict";

  (function Slider() {

    var duration = 400;

    function previous(e) {
      e.preventDefault();

      var $slides = $(this).parent('.slides');

      if(!$slides.is('.moving')) {

        var $current = $slides.find('.slide.active');
        var $prev = $current.prev('.slide');

        if (!$prev.length) {
          $prev = $slides.find('.slide:last');
        }

        $slides.addClass('moving');

        Zanimo($prev[0], 'transform', 'translate3d(-100%, 0, 0)', 0).then(function() {
          Zanimo($current[0], 'transform', 'translate3d(100%, 0, 0)', duration);
          Zanimo($prev[0], 'transform', 'translate3d(0, 0, 0)', duration).fin(function() {
            $slides.removeClass('moving');
          });
        });

        $current.removeClass('active');
        $prev.addClass('active');

      }
    }

    function next(e) {
      e.preventDefault();

      var $slides = $(this).parent('.slides');

      if(!$slides.is('.moving')) {

        var $current = $slides.find('.slide.active');
        var $next = $current.next('.slide');

        if (!$next.length) {
          $next = $slides.find('.slide:first');
        }

        $slides.addClass('moving');

        Zanimo($next[0], 'transform', 'translate3d(100%, 0, 0)', 0).then(function() {
          Zanimo($current[0], 'transform', 'translate3d(-100%, 0, 0)', duration);
          Zanimo($next[0], 'transform', 'translate3d(0, 0, 0)', duration).fin(function() {
            $slides.removeClass('moving');
          });
        });

        $current.removeClass('active');
        $next.addClass('active');

      }
    }

    var $init = $('.slides .slide:first');
    $init.addClass('active');
    Zanimo($init[0], 'transform', 'translate3d(0, 0, 0)', 0);

    $('.slides .arrow-prev').on('click', previous);
    $('.slides .arrow-next').on('click', next);

  })();

  (function FeaturedItemPreview() {

    function select() {
      var $previewPane = $(this).parents('.featured-preview').find('.preview-pane');
      var url = $(this).data('illustration');
      $previewPane.find('img').attr('src', url);
    }

    $('.featured-preview [data-illustration]:not(:first-child)').each(function() {
      var url = $(this).data('illustration');
      var image = new Image();
      image.src = url;
    });

    $('.featured-preview [data-illustration]').on('click', select);
    $('.featured-preview [data-illustration]').first().map(select);

  })();

});