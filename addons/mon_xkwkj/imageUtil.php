<?php
/**
 * Created by IntelliJ IDEA.
 * User: wanglu
 * Date: 2017/12/6
 * Time: 13:52
 */
/**
 * Created by wanglu on 2017/12/6.
 */

class ImageUtil {


    public function createPoster($bg, $savepath, $qrlink, $item_datas)
    {
        set_time_limit(0);
        @ini_set('memory_limit', '256M');

        $size = getimagesize(tomedia($bg));
        $target = imagecreatetruecolor($size[0], $size[1]);
        $bg = $this->imagecreates(tomedia($bg));
        imagecopy($target, $bg, 0, 0, 0, 0,$size[0], $size[1]);
        imagedestroy($bg);
        $img = $this->saveImage($qrlink);

        foreach ($item_datas as $value) {
            $value = $this->trimPx($value);
            if ($value['type'] == 'qr'){
                $this->mergeImage($target,$img,array('left'=>$value['left'],'top'=>$value['top'],'width'=>$value['width'],'height'=>$value['height']));

            }  elseif ($value['type'] == 'sfont')  {
                $this->mergeText($target, $value['content'], array('size'=>$value['size'],'color'=>$value['color'],'left'=>$value['left'],'top'=>$value['top']));
            }
        }

        @unlink($img);
        $this->_mk_dir(dirname($savepath));
        imagejpeg($target, $savepath);
        imagedestroy($target);

        return $savepath;
    }

    private function _mk_dir($dir, $mode = 0755) {
        if (is_dir($dir) || @mkdir($dir, $mode))
            return true;
        if (!$this->_mk_dir(dirname($dir), $mode))
            return false;
        return @mkdir($dir, $mode);
    }

    function mergeImage($target, $imgurl , $data) {
        $img = $this->imagecreates($imgurl);
        $w = imagesx($img);
        $h = imagesy($img);
        imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h);
        imagedestroy($img);
        return $target;
    }


    function trimPx($data) {
        $data['left'] = intval(str_replace('px', '', $data['left'])) * 2;
        $data['top'] = intval(str_replace('px', '', $data['top'])) * 2;
        $data['width'] = intval(str_replace('px', '', $data['width'])) * 2;
        $data['height'] = intval(str_replace('px', '', $data['height'])) * 2;
        $data['size'] = intval(str_replace('px', '', $data['size'])) * 2;
        $data['src'] = tomedia($data['src']);
        return $data;
    }


    function mergeText($target ,$text , $data) {
        $font = IA_ROOT . '/web/resource/fonts/msyhbd.ttf';//字体文件
        $colors = $this->hex2rgb($data['color']);
        $color = imagecolorallocate($target, $colors['red'], $colors['green'], $colors['blue']);
        imagettftext($target, $data['size'], 0, $data['left'], $data['top'] + $data['size'], $color, $font, $text);
        return $target;
    }

    function hex2rgb($colour) {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array('red' => $r, 'green' => $g, 'blue' => $b);
    }


    function imagecreates($bg) {
        $bgImg = @imagecreatefromjpeg($bg);
        if (FALSE == $bgImg) {
            $bgImg = @imagecreatefrompng($bg);
        }
        if (FALSE == $bgImg) {
            $bgImg = @imagecreatefromgif($bg);
        }
        return $bgImg;
    }

    function saveImage($url, $tag = '') {
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        ob_start ();
        curl_exec ( $ch );
        $return_content = ob_get_contents ();
        ob_end_clean ();
        $return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
        $filename = IA_ROOT."/attachment/temp".random(32).".jpg";
        $fp= @fopen($filename,"a"); //将文件绑定到流 
        fwrite($fp,$return_content); //写入文件
        return $filename;
    }

}