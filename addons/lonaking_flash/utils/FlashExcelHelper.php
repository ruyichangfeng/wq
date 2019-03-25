<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

class FlashExcelHelper
{
    /**
     * @param $header array('column'=>'name',...)
     * @param $data
     */
    public static function dump($header, $data = null, $filename = '')
    {
        goto l9LDv;
        BtKbX:
        if (is_null($data)) {
            goto WrZbd;
        }
        goto oNz9a;
        fdnUk:
        $i++;
        goto mp0EQ;
        rTrhf:
        xiUl3:
        goto OogDI;
        yKom9:
        $write->save("\160\150\x70\72\57\57\x6f\x75\164\x70\x75\164");
        goto TCXht;
        Zeu4z:
        $i = 2;
        goto xpW4Y;
        AfSQK:
        OvsrS:
        goto miyKR;
        XWbey:
        $j = 0;
        goto Iv6bD;
        XJ4v3:
        header("\x43\157\156\x74\x65\156\x74\55\x54\162\141\156\163\146\x65\162\55\x45\156\x63\157\144\x69\x6e\x67\x3a\x62\151\x6e\x61\162\171");
        goto yKom9;
        vG0dk:
        $filename = $filename . date("\x59\x2d\155\55\x64\40\150\x2d\x69\55\163");
        goto xlbZ0;
        RSX4f:
        if (!($i < count($tableheader))) {
            goto SQacY;
        }
        goto rE0b7;
        AtXdM:
        goto EQ8QN;
        goto hutWg;
        hutWg:
        SQacY:
        goto BtKbX;
        TWYGb:
        $tableheader = array();
        goto lORW2;
        EQimS:
        header("\103\157\x6e\164\x65\x6e\164\55\x54\x79\x70\145\x3a\141\160\x70\x6c\151\143\141\164\x69\157\x6e\x2f\146\157\x72\x63\145\55\x64\x6f\167\x6e\154\x6f\x61\144");
        goto hYxDE;
        hYxDE:
        header("\x43\157\x6e\164\145\x6e\x74\x2d\x54\x79\160\x65\x3a\x61\160\160\x6c\x69\143\141\164\151\x6f\156\x2f\166\156\144\56\x6d\x73\55\x65\170\145\x63\154");
        goto eq604;
        ie_Ia:
        kXpAc:
        goto fdnUk;
        AUJl6:
        header("\103\141\x63\150\x65\55\x43\x6f\x6e\164\162\157\154\72\x6d\165\x73\164\x2d\162\145\x76\141\x6c\x69\x64\x61\164\145\54\40\160\x6f\x73\164\x2d\x63\150\145\143\x6b\x3d\60\54\x20\160\162\145\x2d\143\x68\145\x63\153\x3d\x30");
        goto EQimS;
        eq604:
        header("\103\x6f\156\164\145\x6e\x74\55\124\x79\x70\x65\x3a\x61\x70\160\154\151\x63\x61\164\151\x6f\x6e\57\x6f\x63\x74\x65\x74\55\x73\164\162\145\x61\x6d");
        goto avPKV;
        Iv6bD:
        foreach ($tableData[$i - 2] as $key => $value) {
            goto XUfsQ;
            XUfsQ:
            $excel->getActiveSheet()->setCellValue("{$letter[$j]}{$i}", "{$value}");
            goto RtcwB;
            Ii60s:
            YFtPr:
            goto xoOPa;
            RtcwB:
            $j++;
            goto Ii60s;
            xoOPa:
        }
        goto Qs7YE;
        iMeiD:
        fYLsy:
        goto gKWqR;
        vRP4e:
        if (!($i <= count($tableData) + 1)) {
            goto OvsrS;
        }
        goto XWbey;
        lORW2:
        foreach ($header as $column => $name) {
            $tableheader[] = $name;
            pVFoc:
        }
        goto rTrhf;
        oNz9a:
        $tableData = array();
        goto DuBme;
        xpW4Y:
        AslVR:
        goto vRP4e;
        miyKR:
        WrZbd:
        goto pIt8m;
        mp0EQ:
        goto AslVR;
        goto AfSQK;
        jNJRT:
        AV8gA:
        goto Zeu4z;
        OogDI:
        $i = 0;
        goto rbMZQ;
        gKWqR:
        $i++;
        goto AtXdM;
        rE0b7:
        $excel->getActiveSheet()->setCellValue("{$letter[$i]}\61", "{$tableheader[$i]}");
        goto iMeiD;
        Imyql:
        header("\x43\157\156\164\x65\x6e\164\55\104\x69\163\x70\157\163\151\x74\151\157\x6e\72\141\164\164\x61\x63\150\x6d\145\x6e\x74\x3b\146\x69\154\x65\x6e\x61\155\145\x3d\x22" . $filename . "\56\143\x73\166\x22");
        goto XJ4v3;
        l9LDv:
        require dirname(__FILE__) . "\x2f\x2e\56\57\x2e\x2e\57\56\x2e\57\x66\x72\x61\155\x65\167\x6f\x72\153\57\x6c\x69\x62\162\x61\x72\x79\x2f\160\150\x70\145\x78\x63\145\x6c\57\x50\110\120\x45\x78\x63\x65\x6c\x2e\160\150\x70";
        goto TXU8m;
        avPKV:
        header("\103\157\156\164\145\x6e\164\x2d\x54\x79\160\145\72\x61\160\x70\x6c\x69\x63\141\x74\151\157\x6e\x2f\x64\x6f\167\x6e\154\157\x61\x64");
        goto Imyql;
        TXU8m:
        $excel = new PHPExcel();
        goto KlPzp;
        pIt8m:
        $write = new PHPExcel_Writer_CSV($excel);
        goto C85n8;
        rbMZQ:
        EQ8QN:
        goto RSX4f;
        C85n8:
        ob_end_clean();
        goto vG0dk;
        cdiOn:
        header("\105\x78\160\151\x72\145\163\72\x20\x30");
        goto AUJl6;
        KlPzp:
        $letter = self::getLetters($header);
        goto TWYGb;
        DuBme:
        foreach ($data as $d) {
            goto PDTZ9;
            pwJsq:
            foreach ($header as $column => $name) {
                $tmp_data[] = $d[$column];
                fYILa:
            }
            goto XuCNw;
            XuCNw:
            jKYyd:
            goto LxQy8;
            NL5hr:
            L0VNW:
            goto s48mV;
            LxQy8:
            $tableData[] = $tmp_data;
            goto NL5hr;
            PDTZ9:
            $tmp_data = array();
            goto pwJsq;
            s48mV:
        }
        goto jNJRT;
        Qs7YE:
        NeAIc:
        goto ie_Ia;
        xlbZ0:
        header("\x50\162\141\147\x6d\x61\72\40\160\165\x62\154\x69\143");
        goto cdiOn;
        TCXht:
    }
    public static function excel2array($filePath = '', $sheet = 0)
    {
        goto JgKGu;
        QDUwz:
        $addr = $colIndex . $rowIndex;
        goto CKUWP;
        Ejx3g:
        die("\146\x69\154\x65\x20\x6e\x6f\164\40\145\170\151\163\x74\x73");
        goto gyqMm;
        P74r9:
        $allColumn = $currentSheet->getHighestColumn();
        goto Vdy1X;
        fgM7W:
        $data[$rowIndex][$colIndex] = $cell;
        goto pdTwm;
        EvO10:
        goto RFoPe;
        goto s_l8h;
        IhZRD:
        if ($PHPReader->canRead($filePath)) {
            goto x5hyf;
        }
        goto XRV2f;
        C04Qy:
        if ($PHPReader->canRead($filePath)) {
            goto e2Gqy;
        }
        goto AINem;
        pdTwm:
        sI_lK:
        goto jGYOQ;
        tiePb:
        if (!($rowIndex <= $allRow)) {
            goto zsscI;
        }
        goto C9te6;
        CKUWP:
        $cell = $currentSheet->getCell($addr)->getValue();
        goto sMXy4;
        Vdy1X:
        $allRow = $currentSheet->getHighestRow();
        goto mc_iW;
        mc_iW:
        $data = array();
        goto midE5;
        BugXq:
        lDA82:
        goto e_wS_;
        uE_lz:
        goto yipTe;
        goto AoFXl;
        midE5:
        $rowIndex = 1;
        goto MfmDM;
        AoFXl:
        zsscI:
        goto B7kti;
        Pdp12:
        die("\344\270\215\346\x98\xaf\145\x78\x63\x65\x6c\xe6\x96\207\xe4\xbb\xb6");
        goto BugXq;
        P1Bw0:
        if (!(empty($filePath) or !file_exists($filePath))) {
            goto ONDd2;
        }
        goto Ejx3g;
        L3Vfy:
        if ($PHPReader->canRead($filePath)) {
            goto lDA82;
        }
        goto Pdp12;
        jGYOQ:
        $colIndex++;
        goto EvO10;
        MfmDM:
        yipTe:
        goto tiePb;
        C9te6:
        $colIndex = "\x41";
        goto ekbXm;
        wG7qm:
        Lbmem:
        goto fgM7W;
        s_l8h:
        jt0Ft:
        goto EJVRq;
        xU7VR:
        $PHPExcel = $PHPReader->load($filePath);
        goto jrWPL;
        EJVRq:
        otlju:
        goto Squ8N;
        Lnkia:
        if (!($colIndex <= $allColumn)) {
            goto jt0Ft;
        }
        goto QDUwz;
        ML_I1:
        $PHPReader = new PHPExcel_Reader_Excel2007();
        goto C04Qy;
        gyqMm:
        ONDd2:
        goto ML_I1;
        ekbXm:
        RFoPe:
        goto Lnkia;
        e_wS_:
        x5hyf:
        goto Tx7Z3;
        XRV2f:
        $PHPReader = new PHPExcel_Reader_CSV();
        goto L3Vfy;
        JgKGu:
        require dirname(__FILE__) . "\x2f\56\x2e\57\56\x2e\x2f\56\56\57\x66\x72\141\155\x65\167\157\x72\x6b\x2f\154\x69\142\x72\x61\162\171\x2f\x70\x68\x70\145\170\143\145\x6c\x2f\120\110\120\105\x78\x63\x65\x6c\56\160\x68\x70";
        goto P1Bw0;
        B7kti:
        return $data;
        goto cdM_h;
        jrWPL:
        $currentSheet = $PHPExcel->getSheet($sheet);
        goto P74r9;
        Squ8N:
        $rowIndex++;
        goto uE_lz;
        AINem:
        $PHPReader = new PHPExcel_Reader_Excel5();
        goto IhZRD;
        sMXy4:
        if (!$cell instanceof PHPExcel_RichText) {
            goto Lbmem;
        }
        goto mQ2bK;
        Tx7Z3:
        e2Gqy:
        goto xU7VR;
        mQ2bK:
        $cell = $cell->__toString();
        goto wG7qm;
        cdM_h:
    }
    public static function excel2clean($data, $template)
    {
        goto xB4_M;
        PNyo8:
        $headerIndex = array();
        goto t5XpK;
        qY5_2:
        foreach ($headerIndex as $title => $letter) {
            $letterFiledMap[$letter] = $templateIndex[$title];
            FsgNp:
        }
        goto HJIcm;
        yw0VE:
        $templateIndex = array();
        goto IBNDX;
        Vwe7h:
        foreach ($tmpData as $tmpLetter => $tmpValue) {
            $arr[$letterFiledMap[$tmpLetter]] = $tmpValue;
            wpt2N:
        }
        goto Z_ND3;
        F_B3H:
        $i = 2;
        goto Ij8wR;
        n4MaT:
        $arr = array();
        goto Vwe7h;
        fQE02:
        $i++;
        goto jPErF;
        xRPJh:
        $tmpData = $data[$i];
        goto n4MaT;
        EFvZq:
        if (!($i <= sizeof($data))) {
            goto JYVtd;
        }
        goto xRPJh;
        jaUne:
        $resultData = array();
        goto F_B3H;
        k59WY:
        $letterFiledMap = array();
        goto qY5_2;
        JbES4:
        FDYj4:
        goto WOgHe;
        XkZ3Z:
        $resultData[] = $arr;
        goto NU71u;
        qfcOV:
        return $resultData;
        goto e4jEl;
        WOgHe:
        foreach ($headerIndex as $key => $letter) {
            goto imjb3;
            imjb3:
            $exits = array_key_exists($key, $templateIndex);
            goto uYEQf;
            GFVbJ:
            ofYsv:
            goto tkDSJ;
            tkDSJ:
            ERL6V:
            goto hcrJ5;
            uYEQf:
            if ($exits) {
                goto ofYsv;
            }
            goto fAMbA;
            fAMbA:
            die("\344\270\212\344\xbc\xa0\xe6\226\207\344\273\xb6\344\270\x8e\xe6\226\x87\xe4\273\266\xe6\xa8\241\xe6\235\277\344\270\x8d\xe4\xb8\200\xe8\207\264\xef\xbc\214\xe8\257\xb7\xe4\275\277\347\224\xa8\xe4\xb8\x8b\350\xbd\xbd\346\250\241\346\x9d\xbf\345\xaf\xb9\xe7\205\xa7\344\xb8\x8d\344\xb8\200\xe8\x87\264\347\x9a\204\345\x9c\xb0\xe6\226\271\xef\xbc\214\xe4\xbf\xae\346\224\xb9\xe5\x90\216\xe9\207\x8d\346\x96\xb0\344\xb8\x8a\xe4\xbc\240" . $key);
            goto GFVbJ;
            hcrJ5:
        }
        goto SVSkM;
        Ij8wR:
        Tb06G:
        goto EFvZq;
        A4ALF:
        ispVN:
        goto yw0VE;
        IBNDX:
        foreach ($template as $field => $title) {
            $templateIndex[$title] = $field;
            SBOYh:
        }
        goto JbES4;
        Z_ND3:
        zlMEf:
        goto XkZ3Z;
        NU71u:
        WBS4T:
        goto fQE02;
        t5XpK:
        foreach ($data[1] as $letter => $title) {
            $headerIndex[$title] = $letter;
            gOmoh:
        }
        goto A4ALF;
        xB4_M:
        $header = $data[1];
        goto PNyo8;
        BRlH1:
        JYVtd:
        goto qfcOV;
        jPErF:
        goto Tb06G;
        goto BRlH1;
        SVSkM:
        bc_gF:
        goto k59WY;
        HJIcm:
        EE_hu:
        goto jaUne;
        e4jEl:
    }
    private static function getLetters($header)
    {
        goto EbEB2;
        B2Xpn:
        $count = sizeof($header);
        goto csZVh;
        csZVh:
        return array_slice($letters, 0, $count);
        goto qh4Hi;
        EbEB2:
        $letters = array("\101", "\102", "\103", "\x44", "\x45", "\x46", "\x47", "\110", "\111", "\112", "\113", "\114", "\x4d", "\x4e", "\117", "\120", "\x51", "\x52", "\123", "\x54", "\125", "\x56", "\x57", "\130", "\131", "\132");
        goto B2Xpn;
        qh4Hi:
    }
}
