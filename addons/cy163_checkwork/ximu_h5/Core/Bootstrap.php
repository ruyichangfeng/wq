<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-05-26 11:06:46              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 spl_autoload_register("\x79\101\x75\164\157\x6c\x6f\x61\x64"); function yAutoload($class) { goto R8pTN; Y_nKb: kALtY: goto ytICA; B1f2w: $class = $class . "\56\160\x68\160"; goto mfOoW; oicLt: if (!file_exists($classFile)) { goto kALtY; } goto E79Xk; R8pTN: $class = str_replace("\134", "\57", str_replace("\103\157\162\x65\134", '', $class)); goto B1f2w; E79Xk: require_once $class; goto Y_nKb; mfOoW: $classFile = __DIR__ . "\57" . $class; goto oicLt; ytICA: }