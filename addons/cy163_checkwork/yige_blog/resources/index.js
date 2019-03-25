/**
 * Main JS file for Casper behaviours
 */

/*globals jQuery, document */
(function($) {
    "use strict";

    $(document).ready(function() {

        /* AD */

        if ($('body').hasClass('home-template')) {
            console.log('home');
            var source = $('#ad-template').html();
            var template = Handlebars.compile(source);

            var topHtml = template({
                    ads: ads.slice(0, 2)
                }),
                bottomHtml = template({
                    ads: ads.slice(2)
                });

            $('#post-list').prepend(topHtml);
            $('#post-list').append(bottomHtml);

        }

        /* Post list in Home */

        $('.home-template .post, .archive-template .post').each(function() {

            if ($(this).hasClass('ad')) return;

            var siteUrl = $(this).find('.post-content a').last().attr('href');

            if (siteUrl) {
                $(this).find('a').attr('href', siteUrl);
            }

            $(this).find('.post-content').remove();

        });


        /* lazyload */

        // $(".thumbnail > img").lazyload();

        //open outgoing links in new window
        //$('a[href^="http://"]').add('a[href^="https://"]').attr('target','_blank');
    });

}(jQuery));