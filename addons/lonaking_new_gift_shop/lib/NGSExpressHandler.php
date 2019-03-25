<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * Created by PhpStorm.
 * User: leon
 * Date: 16/3/24
 * Time: 下午6:25
 */
class NGSExpressHandler
{
    private $company_en;
    private $trans_num;
    private $company_name;
    private $last_update_time;
    private $last_content;
    public function __construct($trans_num)
    {
        $this->trans_num = $trans_num;
        $this->getLastInfo();
    }
    /**
     * 获取运单承运公司
     * @param $transNum
     */
    private function prepareCompanyName($transNum)
    {
        goto xwWtu;
        xwWtu:
        $pinyin = $this->get_express_name($transNum);
        goto wd70I;
        yNvWo:
        $this->company_name = $company[$company_en];
        goto X49BU;
        H5dLN:
        include_once "\143\157\x6d\160\141\156\x79\56\x70\x68\x70";
        goto yNvWo;
        wd70I:
        $this->company_en = $pinyin;
        goto nt1Jq;
        nt1Jq:
        $company_en = $pinyin;
        goto H5dLN;
        X49BU:
    }
    /**
     * 获取最后一次状态
     * time : 最后更新时间
     * content : 最后更新内容
     * @return array|string
     */
    private function getLastInfo()
    {
        goto BU5pt;
        eDHyQ:
        $express_info = $this->transfer_express_info($tmp);
        goto eMRQ1;
        BU5pt:
        $tmp = $this->get_express_info($this->trans_num);
        goto eDHyQ;
        eMRQ1:
        $this->last_update_time = $express_info["\164\151\155\x65"];
        goto cfU5J;
        cfU5J:
        $this->last_content = $express_info["\143\157\x6e\x74\x65\156\164"];
        goto hhzMY;
        hhzMY:
    }
    private function transfer_express_info($info)
    {
        $detail = $this->get_last_update($info);
        return $detail;
    }
    private function get_express_info($express_id)
    {
        goto BHwhl;
        xBmss:
        return $detail;
        goto pp1PQ;
        xxsL4:
        $detail = $this->get_detail($express_id);
        goto xBmss;
        pp1PQ:
        euZ_1:
        goto zpMzP;
        BHwhl:
        if (!($express_id != '' || null != $express_id)) {
            goto euZ_1;
        }
        goto xxsL4;
        zpMzP:
    }
    private function get_express_name($order)
    {
        goto irica;
        xMXYm:
        $expres_pinyin_name = "\346\234\xaa\347\237\245";
        goto B93Fh;
        RzSyT:
        if (!($expres_pinyin_name == '' || $expres_pinyin_name == null)) {
            goto MLjI6;
        }
        goto xMXYm;
        BCfS2:
        $expres_pinyin_name = $json_result[0]["\143\x6f\x6d\103\x6f\144\145"];
        goto RzSyT;
        RrSHT:
        $json_result = json_decode($name, true);
        goto BCfS2;
        B93Fh:
        MLjI6:
        goto u6p3R;
        u6p3R:
        return $expres_pinyin_name;
        goto ipAR7;
        irica:
        $name = $this->get("\150\x74\164\x70\x3a\57\57\x77\x77\167\56\x6b\x75\x61\x69\x64\151\x31\x30\60\56\143\x6f\155\x2f\141\x75\x74\157\x6e\x75\155\142\145\x72\57\x61\x75\x74\x6f\77\156\x75\155\75" . $order);
        goto RrSHT;
        ipAR7:
    }
    private function get_detail($express_id)
    {
        goto Sy6tX;
        ICwoU:
        return $result;
        goto JaDrW;
        QxuGh:
        $result = json_decode($json_result, true);
        goto ICwoU;
        Sy6tX:
        $express_name = $this->get_express_name($express_id);
        goto fMSFW;
        Fwo0P:
        $json_result = $this->get($url);
        goto QxuGh;
        fMSFW:
        $url = "\x68\x74\x74\160\x3a\x2f\57\167\x77\x77\x2e\153\165\141\x69\144\x69\61\60\60\56\143\157\155\57\x71\165\x65\162\x79\x3f\164\x79\x70\x65\x3d" . $express_name . "\x26\x70\157\163\164\151\x64\75" . $express_id;
        goto Fwo0P;
        JaDrW:
    }
    private function get_last_update($json)
    {
        goto JLUN9;
        y5q_g:
        return array("\164\151\155\145" => $last_update_time, "\143\x6f\x6e\x74\x65\x6e\x74" => $last_content);
        goto pMLgO;
        oTM9H:
        $last_content = $express_detail[0]["\143\157\x6e\164\x65\x78\x74"];
        goto y5q_g;
        oYpwe:
        $len = count($express_detail);
        goto SnsdM;
        JLUN9:
        $express_detail = $json["\144\141\x74\x61"];
        goto oYpwe;
        SnsdM:
        $last_update_time = $express_detail[0]["\164\151\155\x65"];
        goto oTM9H;
        pMLgO:
    }
    private function get($url)
    {
        goto uNX6o;
        vSkeg:
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        goto X_NbJ;
        GakAp:
        curl_close($ch);
        goto yUw1z;
        IQvRY:
        curl_setopt($ch, CURLOPT_URL, $url);
        goto mtSf9;
        yUw1z:
        return $content;
        goto tcC1a;
        X_NbJ:
        $content = curl_exec($ch);
        goto GakAp;
        uNX6o:
        $ch = curl_init($url);
        goto IQvRY;
        mtSf9:
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        goto vSkeg;
        tcC1a:
    }
    /**
     * @return mixed
     */
    public function getTransNum()
    {
        return $this->trans_num;
    }
    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }
    /**
     * @return mixed
     */
    public function getLastUpdateTime()
    {
        return $this->last_update_time;
    }
    /**
     * @return mixed
     */
    public function getLastContent()
    {
        return $this->last_content;
    }
}
