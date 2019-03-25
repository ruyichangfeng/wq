<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * 断言:该类所有的方法用法都相同,每个方法调用都可以传入一个message和code 当断言出错则抛出相应提示和错误码的异常信息
 * User: leon
 * Date: 15/9/4
 * Time: 上午1:05
 */
require_once dirname(__FILE__) . "\x2f\56\56\57\145\x78\x63\x65\160\x74\x69\x6f\156\x2f\x41\163\x73\145\162\164\x45\170\x63\145\160\164\151\157\x6e\x2e\160\150\160";
class FlashAssert
{
    public static function not_empty($data, $message = '', $code = 0)
    {
        goto KKjLA;
        KNmwJ:
        $message = empty($message) ? "\346\x95\260\346\x8d\256\344\xb8\xba\347\xa9\272" : $message;
        goto RRBks;
        RRBks:
        throw new AssertException($message, $code);
        goto pCQod;
        KKjLA:
        if (!(empty($data) || is_null($data))) {
            goto fYuWr;
        }
        goto KNmwJ;
        pCQod:
        fYuWr:
        goto uwcrP;
        uwcrP:
    }
    public static function is_number($data, $message = '', $code = 0)
    {
        goto pSmHw;
        pSmHw:
        if (!is_numeric($data)) {
            goto TgsYt;
        }
        goto nyzUx;
        nyzUx:
        $message = empty($message) ? "\xe4\xb8\x8d\xe6\230\xaf\xe6\x95\260\345\xad\227" : $message;
        goto hUr1L;
        hUr1L:
        throw new AssertException($message, $code);
        goto QD4kI;
        QD4kI:
        TgsYt:
        goto uMgsl;
        uMgsl:
    }
    public static function is_mobile($data, $message = '', $code = 0)
    {
        goto xLcch;
        fjsJg:
        xB8Oo:
        goto TSFqd;
        xLcch:
        if (preg_match("\57\x31\133\63\64\65\70\135\x7b\x31\x7d\134\144\173\x39\x7d\44\57", $data)) {
            goto xB8Oo;
        }
        goto M5YbZ;
        M5YbZ:
        $message = empty($message) ? "\350\xaf\xb7\xe8\276\223\345\205\245\xe6\xad\243\xe7\241\xae\xe7\232\x84\xe6\x89\x8b\xe6\x9c\272\345\217\xb7\347\240\201" : $message;
        goto hE03e;
        hE03e:
        throw new AssertException($message, $code);
        goto fjsJg;
        TSFqd:
    }
    public static function not_null($data, $message = '', $code = 0)
    {
        goto Cyqv_;
        Cyqv_:
        if (!($data == null)) {
            goto axqML;
        }
        goto WX0zz;
        WX0zz:
        $message = "\345\206\x85\xe5\xae\271\344\270\272\347\xa9\xba";
        goto PgDOY;
        qXTuJ:
        axqML:
        goto d7YqP;
        PgDOY:
        throw new AssertException($message, $code);
        goto qXTuJ;
        d7YqP:
    }
}
