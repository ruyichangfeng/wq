<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('25B83E504756B040AAQAAAAXAAAABJAAAACABAAAAAAAAAD/CB92X+8zBsPTnfwT+MQXdhZgtFi0PRvvDjbqOgiYd6zvbjuqzWKbXw3xFetP8dRP6rus/yv4xLn+9ufDV1fq4kLdKmy4G1A+wnHYBvjOSufuqqQ7Td59b2Fi802Dh6dvhDTeUq458CjF333gIH4pUMN7cf2x6ZYiW3QCzEciMSgJFZtS34SAfriBSa3o1ia8NwAAAPgHAAD9RWoYI52YKui+BJUDYzJseuw/zkEeaO1kivLm5U0MaabjZNdB1dHKffuafneLn9tnlhU9Aiu+POKwFntHuRUnPttptHRFa02VkdhpOCSNBFayp+5zEIzX+jkjJaOQYzMxNDxptnw8mxmXaIchINuC4LND0Q7cjITXnYzpp+CO4mYrla8fiu7Rz9Hngw20nkSzEVY0tf8Ane6ecRVrwY8o+MqdFNU2CAzK7Feai0aGKo730g+KvL/Z+njgAu90G8WmcFQdhQTl9zHDXCMmtjl0zVKjCjCdLUZF6+x16PzBAF4BeZ0yaV1nOOsvoSqv+7mp75L2U34Aa/14oWvXtE/jr5WMHlLGWWqZcIaTbDLZMna6tiUWdNC3SS4JluEmEPYzuxmr4Iau+mSczV2SeziBxuebK8VBGdfZv4zn0vI3dztU1QzxvEPppgAKzTRO81Y5PF5aNnA3ifn/Idx0CLWgPSQfzMjCKAGRdNkwy31quU1ItVZ5LjkQIoqavsZTm/p57qaogqisDBxWe23FQyB5vLe/cgxcgxtCfXwBWB541tHm7xBzR5OJ6xG5VvwA4GtHKxtJJGUuF+u48g3iQo8wEWTKxKf2oc0i76xiB8zARESEXUyno6I1N/FzA4IazgcpO5De1AFCCuSFPxKWBjYK38hztzJFU0sbehY/E1uozqhbfD+5ThnVPdjXxWgybydb4Au3GRfNAOzlAQ9p8c07kMiDOCri966nJCnt6OdFqDjrzBxjIXYwNtV3Lo+uAD6CKMj9GX8nUSQndNCDB+KhlWyCqbNXE7mwzuQ4NRbaMCrKf1qh/MB6UfQvkuUAgl4Y2dApg90SAgs0nXvSivpBQqjaIMb/iKiGKtSKOWCO0aKeJT90kDnWHZLaiu9VS1hdXpVm/guMsZxm49MoYFYnmXpuSxvwLtObImgJPd8eIfm6CSDw8jvau88QhtMnGlBd5y62xWlTHjF3Sq0YV8KlmZfBORFnqMeDClrAKX2TmHRXxZ5joM8DEALTLN+NvmZpc8T1zZxGy7EAozcPm3px/bteQ7T0xBMh/laKoSXi2QjqH17+1nAYpZtv7vhkLcxDpyIwZO8tDXgBGxMg581lZvno374pJjSVXPNbsT8hJiblwRkfx3efphYDsCE7qSKjcDe3q/fBwNuzaTo1zmVfRoRwCNhGrmbYbnFtSl6h8yNltwkPciClc/xoXrn+ZOpEQIYIFsVe0yIAlctyLfOzQY534ERGbNU9pvtuk1enjqt5SqOUgTmW2AVvYf2J8X0fH1cIYObae2zx4ZJAMkX5orEXFtksL4FCpggr+SDw+c3SZkOV8GQVYaVVby9DXsk0JmkWLHpAXJb63xuiNP/tgkMB5FmOHR+nqKMI+f43mJgo76xVodufAt6W6s9ejP+KpO/yyxuWH2J5X97bSMsKG+4E6m+bvK9uS3PMIm++XSyJTnVw+jPirRWJEmOPIZ0tAvoIeZwi+8PKaqOidvF9iGLjRLHKyIDzugHapV9vIBRKPK6jMo9215Hicnjes4X0HkIfVZkrKe9PxpVxAvAhM0NBIk6Il2PJGQoSN0WP6FkR+SxEZKlii1SpHo1Dn0JLDBRya4rjQakrEcByJOX7RkGsXcSZy9yF05hfMaB0EN21FSYW49Y/BEwSoOG1knByaV/2SWQTihF6RjyR8tNYitytLDRBZqy7zyKqGyRQ9Sg/nkflAsfe++MK6Z5q33CYOo/mbYNKuMrbYv7ZccqPyxtAYJ+wLUTvfxi8DbiwV1DBU/zuGW2RxeX1m9FM3HkCIXIaERowv+t57rtt7vooMtTOJE1luGRR6wUPOtPRIFiZwUHYHISaqpTDM6E2cMdq/+HbAABiU9Y4tOoTKLJREMr9g1KvYomD+ondTdSIlj2MxxUWz95mySSWg7tHTCE7pem96EzyDYyZgtYwkME/rhEG5TMreTQrVBDtl6uAHN6tjc8fKOo79i/RFAC63nJpzfZBcor34RsVp5JFmpV9pK2icuFJkDJi0dLa6IZuBY8NC9rWb+gyZFaSRkFJJakbIu2Cw59oLWwxQmDqtroZQUcoAjgOQWgdxDh8S6aaSBulqgrdacmt/RiFoCj8WJh+ogA3x6h5OANJx91/t2lg5vsvhCAC2ncUAOoRKDeQVmjUw6dDRGwQUpLvI4rmlZIUg+HNg4ZPWWFXYGUBCyTy6wkNM9SI3kp7w+yhHLTs0TUZoDydxUyzf+4dqf9w9I/sZlKb3Ru6hBYOP4XVGVCZz2a/o7re5ghj2kSPE6AyCfy2bVrUHr8chGevyGlNfaA63DTiKiim8JOYnFBOfv4IFPOXwYahQ2Txy3d3lhYsmgLWBcqc1oxfu7oJ6Lfv7nLE+qjKIN71GTl2o5zklyLeapMNrLKAW7noBx7Omw0O6Lr0MGJzTRoSgee4yjvdNYvVEldv/mKERQqghUJd3C5VxorvSmWxBVar4cA4XMa03DRu5A0ZjO17XCHjpioUW7aJ4JvRBJbP7fJIc9KPgDJwp7XxOKF2E7xZXxtlZyXanu3P8wwlUMcXjT/GBzXLR8ya+Q75ZkxUBLiNLbM+K0/SpEoeA363AEtjE2pqJlmAmCcYRCw2UpVSoF9E1S1MZko9IdMgTXin4VhwQCsEeHdTG0z9Ddp0Bd+3j6t5hFIU0wEBsvmBmkza3drq/5M6z4WxDYbB9IeHQBIHiYHiAG0xtlpy5ksTNKg4AAAA8AcAAAQtRnh7UGS43AT0bTGqZBERhkvtYDChmRtuT0dg0T0dZOvbpWpGaBfBmCTUfmkJZ+awh2oyXnSsn9jKuAbYqy4vEFhvglzdFvTCtmYTliHOlQYYpNy2iAaoK1Wm5ThxrizTfplu1Lp3y7buGXU6MN+4fFTxjqRjhfMjHm8zx3RImShhNk2cAkeSBeawdQes3818qIDPrzTaSTCPsNMH15l4w8OMAUSp2LhrWd0dlkX1GCd3kcTq67lAmKK8FZ9VLWtJZq/laU7rEUB6oqud3F06Yb34Ldioc8uBmlyjC4/n3qcm5+X+0vYmvNjDM8o4MbtTVQhTR0IEfzNJycJCZ0EHcHCHj6kPA25xW6jVVVKsjob/4k6mbfmza5VyzYmXL7URZ8N+TdmqbDDE5FGDQsezoQPgoZBnKY4pL+WvA4eUMb/3G2nPhInWgP0OhF0EInuBtYt2osgJIstJGZUNi3BsnbS2dLrJSFx2b135S1KKJsb7gFaUWp6ei339BYn6L5Sm7BD703Qw41ujTvRfo39OnTImfHQRxBynd4K8v6PBAn8/3CiNiUu12xGAETWhOZ8P/0NNMFx8Z8oMGD+ZZa/vQyMhnMhOOE1atqASS+BBuQYWCewAwoLWWy8JWq8aAz5ju1NWLcbUGO+SPyYv4IAPY9qN0/sHB8RzeCe0FX9w/keQoKYsrXlcs+9fJbUNDtuzBEJaIoIn6uNyujiL7HXcD0rQfko2+bXSrOautOT+Pnu4rRdUdPllzdavCCRDEJbObek052vodjlljGRUlUEZ05EWw2setWuOuxN9UfMUdh9IghDk6bjcgkJMo3/ERnzgYSLk5vP7EED+xqEmtwRD7GfrS2e9WC9ZhXKTkapT+RMgy+S/OHg9ZuZV1CyHO7djWNS68SpiAU0oyRRTyexq9EBvkSGTp24kW64MMBzltugCDoaJTMduP8gFZ0IP14Vvqdoh1NTgaNEACRfCepdydJsYm/j3ZpUrpQ00vo8WDBXqw3z1SHtmFVQ7Ua/8GaX61iUsUC+taWULw/Wl8f6dhvRm/GW5+BUnncINjM+9ZJWV1qkmbknFwyBWCzAxAsSVtS2Eho5ZdBXB7vj6H+nwNLAmnVCiw0x9d0GlIQkM/ddHjaPY86lPOWfDVU0/7vi6eb63mABMshqCBxym+SZ0lNBtjX4aFf/SMCfyppGVhkkOHKRqPFE0fgEqh1GyHy67zcYbSQ7UmCcosbxtKPGQPQ6hoRXYPrDrQfUqqyb/JcIMA0Eq4zGefV6UhI+qdw0uimwUbMXQU6U5LMcsxT/EHBJxAJeTO1ABwh3rYlJ9VXDvhpVfVSvjttVmrW9tQmB8GwdXD+WApVGSVGd5TT6vCbi0BR2XYcDaEUMBK67HUAvwlOvj4NnEfCOiJDT9QhTgQrWHJFKmC/HL1TCI/J/7SuhmWlzZH3hgkGE1+b+WvTL411EJHGtYChjLdWx83aLkemIgrQRcW3xzxLGvXUnSMXKDtZWdNqVNONs5v5hnQFZlXC93YKAKI/BIrD9ojiRb2EpXeI0ofl8mprHpX9//MVsYHBLJP44P/D/NK/v2xbTq9dDhNTlj1xyut9V6KOFXBa+h8mWJvEinJTzJGWRC8O/MGChrdOBbKd7p1dLg8EJGUes/99oia+ZU9bOjxpAuDNF6NRbMiRc8rePOT1FxcaXDrR7TwCc9932gsNAjHvd9KyDceWJ/0Z5MIKiW1RAigOYnVXwDFECNbOkKI83CIYuLxJ54eqX+6J4UeirJ3FaEyFK4sKPach+YcOVYZSZx+YACZG7aCOEEia92Zi0l8ib8HfW8ZnpgajQHYpQpXWC/BjJRp3YR40l9W1NhEKBBobRSY0/OGW90NGgirC8dr96cvjM5WodxPTbgCwt0EM6cBfUfDSNM4V27GNVZaiGRzKiz/SYDY+BUhVzq4BVFASrv7xnV9l878kAM8d7+WhybhLTrcS8tDrGXC1tlOJ+7V94RDz5MD6qWWlzfiKshqWkfrF93PwyR/bwjON2EKpjJi33iK9F2wL5DPCiQYIHIv0NyltNbhlfJ8RA8P5AcK0UM+up8I6BiUv1WA1lHYgXIblhHWZKVSsIEAbArSvtwGoj70zEckHqtPhhMnYu3XWh1N6rSdQ3xfNYTpGq4qS07EHCPqJy1B7W/TDEpV7b0fh33C8HvVZEtZNkwmomza6vO6YXPy/v9hk0AmZ2TNlYtR/s9pJXo6a/ZwaaKspUN+vJzBlvYl1kVH0a9pbB8gsXnXMwLSiUFrGtCDuebRW2NlhoO9BXf9Jvl00fkn/83Cm75OLYosA+EbKa2D2vXxT6+TWDfSQULIfwRVWoxFbjFunajRfRN7RrTeks1pvzzhx0/E7zGyCWwv2YFPj9EvErvWXk6bg72Z/NuCTlDc0JVwIVw5Fctuerw5ltFgyR3Woj1YwbX+Qxk2VaVPo9q2n3fgtb8q824BTVX+PJF8PAdR5Ux+tGFC1FsKAtAKku/JlhevLcjd2UW4HBOM7V2muMhHnKvwun0koHJGp4k4RHte7rciQzBo6OSyyqqtcFvapmXg5B5E6x3zpfsfaVIwh2irrkS35WkF6CLZgn4TM5cN4bWnis4yEDHUtSU2toGpZvswnalUjjaAxGTHQxkgse1f7lNbr4j+CxaUWrSPJIJ5/Zno0rkpKqtoOo6eaH6UuONOUqfilY79ZI0PvoHAAAAOAYAAFIBlhhQo2uVuv9MIM1gI7pmBzfpbSVAo5ie0o8CcKqbuwKC5RRc1rA/Rvz5YNVV0HEC/3nx3z4D4THyHNTjT8lUlGjdWmNJFYtk0KYQgU39cd7TvM8+AaIBXbPcsdxbtma9q3E/CJFXslI6fyTV/J30MTYP/HsShatsYA8R2Bb7rP6MtpShNfAvBVrrQ9BK7izrmtUpTLVjLN7IotcZMQMC+rxbxlHrwSiIquiZnvXzAV3fxMiLjVSTTMyBB5KJUi4cPNCuUGKXrNVqjixNMzsKpP5vMMGaMH3DWd94D5jcIZ7cWfW/dsvRMZY3prH/pftplhfDfPxrzQdLZNj8ISEr2+1SdOgpuUgQ4LRKTCTHDq2PZAb9SMLjRokGifZ4W4UId7hH05Ts0V4V9zrYsXHrKo+RIad1gdTZNzyDoILNAjW2u1oqOglJynBx5TxK/+JMTsJkjABdh91wFqBltm5IoK/GnUzq2u4zLhuJlqjHSL9mjwPC5pYKJyb2Gi8xMswF0w1XLg0J5pj7rQYqjlsktd8+VqxOjnLFLmhbg0SfyZZVqg+exbq7oOzm781eIOECUhzLOWyzepWMbX+bDeTWmFhgpVinuv2pj99aF7oLUbwfUZbCTfXr1w/9vDMwWBVBTar+5CLKNewak/LVOyUG1JXiRzrPCCNgDEoS9iTI6hj2Syvpl/LmXefce6Ur1JlEZj2r9NLsn06yDRDvh9/znywZ9t3TQCNi9mwjxT1u/EQlveYDXAM3D9/966jBcC8s0uSnhleBC4UhO+gtkwQQrEjc4tGvrChnTPNjs/tjekHv6KbFg/xNIxBEtBwyIqgkXKai0BdQRkm5hSBTnwi+KNYRd/315a1Fw2++BcPiicp8Jn22Bqa8H1pUW2oBTF6CY9byADMowNm9xhdxL69sBOLyTd7shRPw+Ae7FDE98S/a4RGJqzNUKxYOjGPATf0YkyKEmPi7tUSIKazGgeW1cjvmjI8vSCUyiK37SoZP1opHWf7sTSK/CItFC7tKYBXy6sHgHSTDjpOGL+pp6sfcZdHtz3G/PEUE6D9zb4NxvtgmaGdFd7Wv+Lpo3WhjDvrCOJn4MBfSewz/3SBdJHwjBznD0yS9XTwY0oCKvemV31HdBIKt0GM5UH4asrOQKreoZCIMzNL6AB6OGWHdsX/oJcgSTITx99KikkJq3u8ghMe2QTNn6JBEnOMHr2rwBYJgDcXBvfasws1kUg60okEACH6KYC93hhxemJfiQuhYy2gz5lmtqmUaWLKBgoJnHLQe2mP8XM9QN/Kr3QDRcytMPImlkQNMnFGWS+lVmr+KlKbh/emcelBcRJmP1CtnU0Qt5WIqUVeK5w05LI3aWcgxT9COZzoEOdJ3wW1h/rXnW8+hOdcIM91iRYfvdDh9AjlbIZm8Cngx1lNFl28fHazL3nCmqpd02vIWENXwalO4A0If+z/okONopgMtp25MbgFow6RM1Z+uNp/cYuEDZd8sNCwPr+tCTfjFiTOCpsWms1geEgAoSft8IMP6CNgF25GxpckuAPF3VVtE6Go5k5tD61iWxvv9f6dBfiQ2OKOJy7DXZnvoxcWUSif9Mr+khI/QCabpIpuQTfmp+Hb5kzhF3zvQiFD7m7bwoSupHDdubo3xnSIfrt22ehKRCDjGABXwwfXp4B+JHTBfGOq7d2wchIhV7hPzUh3zF2t7NUqzRzg2IO2GABFy+0OY2SaYmYhB6DuniTTO6WQf8nefJph9VDUz/XFZJpETMIau+cyNq/0h6YA8Nhe7Fvz8eN3WwD6NO/b9VuvFFaQB75qNUYElMBccOZt7Eadm6o+c89jIyP65l1u4yWnliwAU1psBQ/nogiMlyOq1y+u//0cZ9e9JGJAtKafqcfVKBJrPlH6YuQ8cMacHPzyx+1ch37P78DVs0bo3cnZ8KmHc3Cgeaxeng+rz1AZVxay88xM18uAk1e9tIP8qL1TQXXJy0sLiU1jJhitm8z3HGyUOZJvu9da+cmdvD15IQN1uiu5dpl4bgr8mFm5pvJ/K+wpzqOfQ3jH+Sy+wu3aEEVEioUZsyy9DnvdyWiSKgDZR5nHhZ+xG4/TK352sEchWCrXuvTThSK/zvkwwVYoPRwAAACAGAADmBoV+k8F4Ee2LSgfzIm+3B4UGttp7R5ZTDIYfb/rilDmLxt3LcZerkGOmWQLsL/f9pVYgD41YJVy4VAWry331TVK2AY2ZzAFd7wiTd8CAOE4TkFbcY4Mq6ibmCDV7hgKy5e3wGyhKW7ncWLh/A2e9Ia8kUCesiO3t7Ldm2x2fjm2jqk4uUv4OQlPNKPhcodVslEFyJLL4jDqWNK+ipFZ1qZmXLtKz+lb/yAPIZG0XfZX9+VF4cknYdeGjEWSKN/Eua4q9IZmXR7pMSjDlI1BVmcG+UaF6I1WW6SMg1yzD+RONR0CbKX4iEvv+NYHZ4YJC8hpJf+2I5q1uPQS5R/jMrOBo0YIJwrLURtzHuFqq/Zyey+RIhA54IQaL/I+yKWngG6CsVXH8w18VbKIL50tsCYHdPbTEbaWE2PPqLjKA5m9/2ZDXFTnZW0ls8CyzIR7qtSvNnZjyseJ964BkzCbsQ+4ky6hWMXMRTrfjIWcW+XxAlq118AUmjfO2IHOJcMLAIptmgh6NfKWGWmW37GVk+rI2z4acgz3kb5NMvXbpiK8eyVPOPe7vOQp4AFTXeVomBIyEIKeuG/f0qgb/idep8sZMhyN2b7D0X3V3uFnoMYL3jZsdig1eVkbWr7GRmQ7IapcW+Kt7cu3AWTTk9SLY8ZWqoqyzI72QRVaeg0dgjijrAvzR+oLrWkuhhh/kgqipHuTTelwntsousb9rH01H0ZcWOhPeCS/B8StjhvA2IBSZ0EjCipykR4qRTpdCo+1iEYddEEadKLgTUymy0rKkk3oegt8QVale2bBIGUvgOfvswpEKFB0L0yadTNYdY44aro3uTg1FOB4CWQ/F/hbXaT9tYJkJVNZ512ObFBnOo2naBATNzWIIJdWMZHLhD72aNVGmhQ3oaV7eiKK0eGw2VEfOVVFATrySU+eVROTX38lWYMb/6JFwd7q7TA0isYoelkLfwyfAY41l4EIQEVQbr9P4VycWXz9Z0Rm/imArbvg20tlSgyA/iyt1Mk7vW9R3GcjHnGfDvkgvak0tl9ou3kYvmowczNS3YPcssUbKxiQLe/o2meBEeGNETOK8QRqlX1wJ/b7RoCrZ7CL8OD7icz5u7MkZIf2OfOP3REt3td7AuO+fR1rr2Zvgw69BqJMbsVILkQT1L+5K88yi28SrUFXnCQ7IJPbKWu385amQlU4UjnpR0JjAyfmvw+0i2U5BWHIfIJa7/bf7xQ0UPNR7Llbi+4bDDDdf1kWsOSvzUN3//DkgEBKJ3Wr9HZ4rMjWyO0XKwIsQwr/yvTBtwgytZF1qDOSFgrp6bb9hg3Ii9hRLW4CNtSEAca0pGvF+Funv6BVdVHs2Yq097qpP2e+MdYDtNcvxZIk+8J9p7qzD8OVzJjGWiW9rj2M+1nusmpA4nkk3x3+ODdJqtEkk3TvvtNWR+OdocXEUCrfAgNR0OUGI3WPRwye85CaGKnqCTz8Q3GKo5TkJ72JCv1+iBg93IWVAb2bUgDu+iaiAbFynB89FAlUw1bJW2OtxRHNxpCgEQ7pvu7xc2MpLuxVGeS04uJ72psrsbPsOPhSvnXxeYaXkAIK3YUHnYXA+ipbMhnWorLMh5urGTnRT5IFrVWOzxnWtC2nh5S4Pws6iePzHV6KmGuRpJFlGX8SDO61gDpXyX2Kv1yjq7dodJFXcIMDxi+FUsHe5rFrcttBrGyLqaAxVRWeNYcllKnjnqWbyrhq2P66H/dNzOwy29h/6lu26DFELw/JfFIaPrAtjY3gjLDdBRlHj+4evYV1T5mYg1b+d4dro4VKaJiRqokRyrbx961/wWTIBQyaPYD8RV5neocK2XeGf7P4dcmLesRWEuwUPsdzGmyjye24YiPGxi5BkZ9mYp1WwAwpuIXcU68cARBjLDyLse+nXPf5Q3UyJ0KQhKqA+tJywYc+pjK7H0yog2403CDz1MoO0Lr7Ayho/blylhdGUwleJIM7q9zyVv//rg0Ti6AICcQidWiy+IHIq+lR5yiCKUxUVHttVzDJ5xy4msrmSIRPz7rB7pEKuQiQOuJoysdY1dYgvALl1AVeC+ZGpIf6WtIoHqabHGXRbtEgAAAAgBgAAuvwnX5rzifY+o0Qrv/0P+/mCZXpA1Z7v7EpDqNRpScTBZxjfDwFNZXcHInlWR/virw7k7IQuqtMK1WACT+RM8uAwu5hDfjLd9Xsx3AviMSWGkY67gYKHDXYRpKmPoORU/PQGoVoP9b02CGBf/SuXdn4C53CBREc2iAwE2BibypIjNBPMhhf26NvTpfgSZMqe5Ibb0IvQ0ALsdnY/hT1OMOLmOd2+0BlzjMGjYbtJRexaAUQfOZgtJWURDSmE1XJPcPo+fGyt74d6t7PbJ1JvNy21qkQ4fhPJbasYtHe5A4cPPU9QB6gradNL1xeCWhZbeImrTXRViYQ7aV0ERmV/vC69riYMfEFvsDx3ikIZx7nX/JQppr2+CG9RiPyyFweMZfRYvutEqZ7ZY+oUFEVYxSxQm7ndZUrn53lmSvMyT8IYr5+hQNSCP0BKNebrdbGW35YfryEqtWoFMvSAWeKvIbyFu0bV2P9+RlangzLRyIH9tqiz8RjDsCYfszcUwpNKWomyikIhsPgt44fnqZ+7DQQhWUaJlhaqo4+D2O7iye/1F6Is06STBM8ouRgblgpH2It2rz3sIEK9dRQHqRZs+FM+WaCM8ofMBm3IGa4pLod6Qz00LjJ3KZQcB5eGvXF9Klt1NdwdhaRkBPdq5AaH6d74iPvO4729LJnLnE/6FVcLgBroksUkzcA2pGWCaKysKnbbQBqES4QjFDCp+SxDsrtbIBTUZLoPpr+F84qbBoM4BXv6O4fsS3tsyFhPoPne2CEWl6p9BgbRiXmHRXZdmz1AjsmTNHvMpb+1H1eHcohrgZ80xl67BVXNsKaCydMYa20kolAs+5FXDp1gciH2qFNWJBp71ka2TTGvLoD4VbWCFl3hIIvOypCOKB7jn8h/0oKxR95oKTZfRmxBPrlBvszwCBpSFCQNCel8Nlv+lwt9vcZ20qB+m/91zbEDapA/rL7bMwFvW+i0tJJ5VvaQb2ABSsoL6YKKD2LdmKJUVyECaucR66rWejfenbu7f4+IBBm6cPVC38l4alFl5bsSlC2a/y9rPGw45fHnzEBzPYGHSkhmBH1K4UuYvOoFEqOqc9/jNQcdKFC22ew17prbMeEtanUU5EZT5RI0ujjoHJuQFnkbj5tbE37OZXSEJdt+Lbmp4LlDe0Apj3P8SNAZXIINy6DqGcB9qTAHv6lyIh92WFA4adI63xrLk4ZkWc5r/IzqQxQOdL6CNxdihDgkyamfRhaPAIAHqWAMdddxjtEsahdIWqcLxPJVu3/xHdeXyFd7o/8JWdU3JQftkRPmmqtyoIAHAuTXeOIyA8THOkz4Wk//5Cr166ICs/l96R8ycE5fgIab8MwOvU3Xbnvji63YN+kKRfbuk2JkUWfx/Vn2Ymfa6aCPqlpf9oOxaGbaOBtXuWeSXbzg2a++eNs8UAMoTh7MS0UhPiHNQV6ZuetjRNAtfnEjfDm16goi0JYA8dgUSiWRerjkseL7kT52W9cIVQQUeVYPPonneEgsFZYyZnD/OSd7LZ2lN9OYa163/uScrv6kd1FMiyF/eYhJf4QRFyqhGZEDLz6W+F2EqfXbIQFgQIjdkGWF+pRa7+ysO0ww3onuYyFgiLJ6wWbjR3fo3LpP3NpR3X0TJSCNLUtVkaGKJI19zzUu5nFLhg1YwOzUAadWjAdDB0hqAYw5ELW9HcMhvqH8yQlxiBM3S5Vy22tOSS+jbggTMzeJRGdkLc11wwNxWCpUVf3//bG3MBUF/JQ5Ed0ihmk5H//HzVACUAdc8GsK9gDp+2Ct32i6idwDB67VcL5v48FH4dFSJbaSfaHspLLbM7Fj43juSrDHaAuhanbH190rgIogyub2Gb54mgha14dWeMuesczEBm2GTExuW2wmyiYgQfnnDc3kUfzUg70C8CGYlez9y7BEDffNvkTC1lO/QW25NdopPH4ZSRjOX2kVnNqU95wmg/DYjUSDqDltAqN41pa1SswUgPknlxL3FYBclmaZR4dFBRGdTuT7Y+ciDwB7TxvYuWrLgsEgUOoUzR/gckTh6o+mFCQ2pqxY1su38KprxP3LQ3TpV2svdmucXs2op9gxuOMAAAAA');