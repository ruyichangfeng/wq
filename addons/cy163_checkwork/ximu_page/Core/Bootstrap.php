<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-05-27 10:26:52              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 spl_autoload_register("\171\x41\165\164\x6f\x6c\x6f\141\x64"); function yAutoload($class) { goto gdyq0; Cy_tl: wQpoE: goto UDoZL; gdyq0: $class = str_replace("\x5c", "\57", str_replace("\x43\157\162\x65\134", '', $class)); goto Zhwt7; Yr6M_: $classFile = __DIR__ . "\x2f" . $class; goto WzKsr; WzKsr: if (!file_exists($classFile)) { goto wQpoE; } goto yIxdl; yIxdl: require_once $class; goto Cy_tl; Zhwt7: $class = $class . "\x2e\x70\x68\x70"; goto Yr6M_; UDoZL: }