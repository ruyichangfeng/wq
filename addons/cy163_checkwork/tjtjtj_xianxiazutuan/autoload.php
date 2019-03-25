<?php

/**
 * ���
 * User: TT
 * Date: 2016/3/3
 * Time: 12:38
 */

class autoload {
    public static function load( $className ) {
        include_once sprintf( '%s.php', str_replace('\\', '/', $className) );
    }
}

spl_autoload_register( 'autoload::load' );
