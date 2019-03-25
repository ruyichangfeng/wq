<?php

include_once dirname(__FILE__) .'/BaiduNews.php';
include_once dirname(__FILE__) .'/ToutiaoNews.php';
include_once dirname(__FILE__) .'/BaiduNewsSearch.php';

include_once dirname(__FILE__) . "/BaseHandler.php";
include_once dirname(__FILE__) . "/Category.php";
class Index {
    static function getCategory() {
        return [
            BaiduNews::$NAME => [
                'name'     => BaiduNews::$NAME,
                'value'    => BaiduNews::$VALUE,
                'category' => BaiduNews::$CATEGORY,
            ],
            ToutiaoNews::$NAME => [
                'name'     => ToutiaoNews::$NAME,
                'value'    => ToutiaoNews::$VALUE,
                'category' => ToutiaoNews::$CATEGORY,
            ],
            BaiduNewsSearch::$NAME => [
                'name'     => BaiduNewsSearch::$NAME,
                'value'    => BaiduNewsSearch::$VALUE,
                'category' => BaiduNewsSearch::$CATEGORY,
            ]
        ];
    }

    public static function run() {

        $category = self::getCategory();
        $handler = BaseHandler::getHandler();
        $sql = "select * from ims_wg_sales_category where del=0";
        $result = DBMysqlNamespace::query($handler, $sql);
        $runData = [];
        foreach ($result as $value) {
            $source = json_decode($value['source'], true);
            if($source) {
                foreach($source as $s) {
                    $d    = explode('_',$s);
                    $name = $d[0];
                    $id   = $d[1];
                    if(isset($category[$name]['category'][$id])) {
                        $runData[$category[$name]['name']][$id][] = 'ims_wg_sales_article_news_'.$value['id'];
                        $runData[$category[$name]['name']][$id] = array_unique($runData[$category[$name]['name']][$id]);
                    }else {
                        $runData[$category[$name]['name']][$id][] = 'ims_wg_sales_article_news_'.$value['id'];
                        $runData[$category[$name]['name']][$id] = array_unique($runData[$category[$name]['name']][$id]);
                    }
                }
            }
        }


       foreach($runData as $key => $value) {
            if(class_exists($key)) {
                $class = new $key();
                foreach ($value as $k => $v) {
                    $class->run($k,$v);
                }
            }

       }
    }
}

