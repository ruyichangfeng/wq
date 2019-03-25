<?php defined('IN_IA') or exit('Access Denied');?><script>

    <?php  if($xkwkj['bgmusic']) { ?>

    $(function() {

        $("#audio_btn").click(function () {

            if ($(this).hasClass('play_yinfu')) {
                $("#media").get(0).pause();
                $(this).removeClass('play_yinfu');
                $(this).addClass('off');
                $("#yinfu").removeClass("rotate");
            } else {
                $("#media").get(0).play();
                $(this).removeClass('off');
                $(this).addClass('play_yinfu');

                $("#yinfu").addClass("rotate");
            }

        });

    });

    document.addEventListener('DOMContentLoaded', function () {
        function audioAutoPlay() {
            var audio = document.getElementById('media');
            audio.play();
            document.addEventListener("WeixinJSBridgeReady", function () {
                audio.play();
            }, false);
        }
        audioAutoPlay();
    });

  <?php  } ?>
</script>