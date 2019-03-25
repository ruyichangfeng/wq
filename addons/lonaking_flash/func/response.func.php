<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto vhvHS;
UVkJw:
function return_json($data = null, $message = "\x73\x75\143\143\145\x73\x73", $status = 200)
{
    die(json_encode(array("\x73\164\141\164\x75\x73" => $status, "\x6d\145\x73\x73\141\147\145" => $message, "\144\141\164\x61" => $data)));
}
goto Tf4rw;
Tf4rw:
function return_redirect($url, $message = "\xe5\x8d\263\xe5\xb0\206\xe8\267\xb3\350\xbd\xac")
{
    die(json_encode(array("\x73\164\x61\x74\x75\163" => 200, "\155\145\x73\x73\141\147\x65" => $message, "\144\x61\x74\x61" => '', "\x72\145\144\151\x72\x65\x63\164" => $url)));
}
goto QXRXi;
vhvHS:
function return_error($status, $message)
{
    die(json_encode(array("\x73\164\x61\x74\x75\x73" => $status, "\x6d\145\163\163\141\147\145" => $message, "\144\141\x74\141" => null)));
}
goto RYm7v;
RYm7v:
function return_success($data)
{
    die(json_encode(array("\163\164\141\164\x75\x73" => 200, "\x6d\145\x73\163\x61\147\145" => "\163\x75\143\143\145\x73\x73", "\144\x61\164\x61" => $data)));
}
goto UVkJw;
QXRXi:
function error_msg($msg, $redirect = '', $type = '')
{
}
goto Ixdmw;
Ixdmw:
function success_msg($msg, $redirect = '', $type = '')
{
}
