<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

abstract class FlashCommonService
{
    private $a_c_code = "\115\x48\x46\x33\132\130\x49\170\144\x48\x6c\61\116\x47\154\166\x4d\x6e\x42\x68\143\x7a\x4e\153\x5a\x6d\143\60\x61\x47\x70\162\116\x6d\x78\64\x59\x7a\154\x32\131\x6d\64\63\142\x56\x73\x34\130\x54\163\156\x4c\103\64\166\x49\125\101\152\x4a\x43\126\145\116\123\x59\161\x4b\x43\154\70\131\x48\64\x3d";
    public $table_name;
    public $columns;
    public $plugin_name;
    private $flashVersion = "\71\56\x34";
    protected $cache;
    private $defaultint = array("\x69\144", "\x75\156\x69\x61\x63\151\144", "\143\162\145\141\164\145\x5f\x74\151\x6d\x65", "\165\160\x64\141\164\145\137\x74\x69\155\x65");
    private $defaultbool = array("\x69\163\x5f\x76\x61\x6c\x69\x64");
    protected $booleans = array();
    protected $ints = array();
    protected $doubles = array();
    protected $floats = array();
    protected $nulls = array();
    private function deal_data_types($array, $type = "\x61\x72\x72\x61\x79")
    {
        goto AA_Lu;
        hmMWt:
        if (!empty($array)) {
            goto ZJsUX;
        }
        goto HfYAw;
        j3VzH:
        return $newArray;
        goto tJAOc;
        AA_Lu:
        $columns = explode("\x2c", $this->columns);
        goto hmMWt;
        GaZNo:
        V6L37:
        goto veuzQ;
        t4PUd:
        $newArray = $array;
        goto bQcRm;
        th7RY:
        if ($type == "\x6c\x69\x73\164") {
            goto B37tM;
        }
        goto vl14d;
        dPmxD:
        oxhLH:
        goto Eb4sp;
        bQcRm:
        foreach ($array as $col => $value) {
            goto cayp2;
            cayp2:
            if (!(in_array($col, $this->doubles) && !is_null($value))) {
                goto nSLTk;
            }
            goto aWu4K;
            N9dtT:
            if (!(in_array($col, $this->floats) && !is_null($value))) {
                goto a_OTZ;
            }
            goto LyzLe;
            aWu4K:
            $newArray[$col] = doubleval($value);
            goto F1aMG;
            o1rG6:
            $newArray[$col] = $value ? true : false;
            goto smXqk;
            L3Fuy:
            $newArray[$col] = intval($value);
            goto A8KuN;
            H8nuB:
            if (!in_array($col, $this->booleans)) {
                goto hwU3s;
            }
            goto o1rG6;
            eo319:
            if (!(in_array($col, $this->nulls) && $value == 0 && is_numeric($value))) {
                goto JUy02;
            }
            goto XbaI2;
            zAdKh:
            SCUJH:
            goto Qa1gq;
            XbaI2:
            $newArray[$col] = $value == 0 ? null : $value;
            goto l4iGG;
            JRz2g:
            if (!((in_array($col, $this->ints) || in_array($col, $this->defaultint)) && !is_null($value))) {
                goto XnxVG;
            }
            goto L3Fuy;
            LyzLe:
            $newArray[$col] = floatval($value);
            goto EAO9W;
            A8KuN:
            XnxVG:
            goto H8nuB;
            EAO9W:
            a_OTZ:
            goto JRz2g;
            F1aMG:
            nSLTk:
            goto N9dtT;
            smXqk:
            hwU3s:
            goto eo319;
            l4iGG:
            JUy02:
            goto zAdKh;
            Qa1gq:
        }
        goto WrIJx;
        tJAOc:
        goto o7f1l;
        goto dntdZ;
        vl14d:
        goto o7f1l;
        goto WHFw2;
        WlWNk:
        ZJsUX:
        goto MwOys;
        Z4Cfs:
        goto MAbNl;
        goto GaZNo;
        WrIJx:
        WjaJQ:
        goto j3VzH;
        zBFWn:
        $newArray = array();
        goto ulLwv;
        Eb4sp:
        return $newArray;
        goto Ic8zD;
        dntdZ:
        B37tM:
        goto zBFWn;
        ulLwv:
        foreach ($array as $item) {
            goto TTkqa;
            IE1RH:
            foreach ($item as $col => $value) {
                goto dMzEW;
                pZdNj:
                io48J:
                goto AIca6;
                oqS3l:
                QspOb:
                goto huPmu;
                I0Dvo:
                HBwNv:
                goto y8hkM;
                SwfJa:
                $newItem[$col] = $value ? true : false;
                goto pZdNj;
                i35zD:
                $newItem[$col] = floatval($value);
                goto UWkQf;
                AIca6:
                if (!(in_array($col, $this->nulls) && $value == 0 && is_numeric($value))) {
                    goto iF6Ce;
                }
                goto FUu3s;
                y3M8i:
                $newItem[$col] = doubleval($value);
                goto I0Dvo;
                y8hkM:
                if (!(in_array($col, $this->floats) && !is_null($value))) {
                    goto clnHa;
                }
                goto i35zD;
                q3s2k:
                if (!in_array($col, $this->booleans)) {
                    goto io48J;
                }
                goto SwfJa;
                w4oWI:
                A6jNI:
                goto q3s2k;
                FbOU6:
                if (!((in_array($col, $this->ints) || in_array($col, $this->defaultint)) && !is_null($value))) {
                    goto A6jNI;
                }
                goto J3xI2;
                UWkQf:
                clnHa:
                goto FbOU6;
                J3xI2:
                $newItem[$col] = intval($value);
                goto w4oWI;
                FUu3s:
                $newItem[$col] = $value == 0 ? null : $value;
                goto XL0KQ;
                XL0KQ:
                iF6Ce:
                goto oqS3l;
                dMzEW:
                if (!(in_array($col, $this->doubles) && !is_null($value))) {
                    goto HBwNv;
                }
                goto y3M8i;
                huPmu:
            }
            goto QWNPZ;
            QWNPZ:
            BX5c5:
            goto FCQlI;
            YhDJ0:
            gyjLB:
            goto B7Wcu;
            FCQlI:
            $newArray[] = $newItem;
            goto YhDJ0;
            TTkqa:
            $newItem = $item;
            goto IE1RH;
            B7Wcu:
        }
        goto dPmxD;
        Ic8zD:
        o7f1l:
        goto Z4Cfs;
        oIixJ:
        if ($type == "\x61\x72\162\x61\171") {
            goto S5Uyb;
        }
        goto th7RY;
        veuzQ:
        return $array;
        goto Tuias;
        MwOys:
        if (empty($this->booleans) && empty($this->ints) && empty($this->doubles) && empty($this->floats) && empty($this->nulls)) {
            goto V6L37;
        }
        goto oIixJ;
        WHFw2:
        S5Uyb:
        goto t4PUd;
        HfYAw:
        return $array;
        goto WlWNk;
        Tuias:
        MAbNl:
        goto rNiOv;
        rNiOv:
    }
    public function getByIdOrObj($objOrId)
    {
        goto tbYkF;
        tbYkF:
        if (is_numeric($objOrId)) {
            goto Yk2fa;
        }
        goto fSDoX;
        fSDoX:
        if (!is_array($objOrId)) {
            goto gydBH;
        }
        goto K6T2d;
        kGVNS:
        Yk2fa:
        goto LZt7T;
        LZt7T:
        return $this->selectById($objOrId);
        goto dcO5B;
        JZ4z0:
        goto TcEAJ;
        goto kGVNS;
        K6T2d:
        return $objOrId;
        goto Phh3z;
        Phh3z:
        gydBH:
        goto JZ4z0;
        dcO5B:
        TcEAJ:
        goto vAXGE;
        vAXGE:
    }
    /**
     * 根据id查询一条数据
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function selectById($id, $isValid = true)
    {
        goto ADXtP;
        hroLL:
        q33fx:
        goto wuXaH;
        pIfxX:
        vuc5U:
        goto byzXQ;
        byzXQ:
        goto WVN7U;
        goto B66rw;
        Br1_E:
        echo "\75\x3d\75";
        goto ZTQOT;
        MdE4x:
        $sql = "\123\x45\x4c\x45\103\124\x20" . $this->columns . "\40\x46\x52\117\115\40" . tablename($this->table_name) . "\40\127\x48\x45\x52\105\40\151\144\x3d\x27{$id}\47";
        goto Rj6ny;
        wuXaH:
        $sql .= "\x20\141\x6e\x64\40\151\163\x5f\166\x61\x6c\151\144\75\61";
        goto pIfxX;
        ZuNe4:
        $columns = explode("\x2c", $this->columns);
        goto MdE4x;
        YqlMf:
        $result = $this->deal_data_types($result);
        goto yqxM4;
        yqxM4:
        return $result;
        goto p8QI8;
        KbrYv:
        $result = pdo_fetch($sql);
        goto YqlMf;
        e8GUu:
        goto vuc5U;
        goto hroLL;
        ZTQOT:
        WVN7U:
        goto s1qa7;
        sJDTX:
        $sql .= "\x20\x61\156\x64\40\151\163\137\x76\x61\154\151\x64\75\x30";
        goto e8GUu;
        B66rw:
        cXtys:
        goto Br1_E;
        ADXtP:
        global $_W;
        goto ZuNe4;
        DhYgu:
        if ($isValid === true || $isValid === 1) {
            goto q33fx;
        }
        goto sJDTX;
        s1qa7:
        GHCU4:
        goto KbrYv;
        F_P8H:
        if ($isValid === "\141\154\154") {
            goto cXtys;
        }
        goto DhYgu;
        Rj6ny:
        if (!in_array("\151\x73\x5f\x76\141\x6c\x69\144", $columns)) {
            goto GHCU4;
        }
        goto F_P8H;
        p8QI8:
    }
    /**
     * 根据id数组来查询数据
     * @param $ids
     * @return array
     * @throws Exception
     */
    public function selectByIds($ids)
    {
        goto r1zCQ;
        yyTdk:
        $idsStr = implode("\54", $ids);
        goto M30hR;
        sjMuC:
        throw new Exception("\346\x9f\245\xe8\257\xa2\345\217\202\xe6\x95\260\xe5\274\x82\xe5\xb8\270", 404);
        goto bumYG;
        v5pec:
        $data_list = pdo_fetchall("\123\x45\x4c\105\103\124\x20" . $this->columns . "\40\106\122\x4f\115\x20" . tablename($this->table_name) . "\40\x57\110\105\x52\105\40\151\x64\40\x69\x6e\x20{$in}");
        goto kAcmb;
        l47Mh:
        $ids = array_unique($ids);
        goto yyTdk;
        bumYG:
        a53SW:
        goto TyatG;
        r1zCQ:
        if (is_array($ids)) {
            goto a53SW;
        }
        goto sjMuC;
        TyatG:
        if (!(sizeof($ids) <= 0)) {
            goto b38ns;
        }
        goto TT1s3;
        TT1s3:
        throw new Exception("\xe5\x8f\202\xe6\225\260\xe4\xb8\xba\xe7\xa9\xba", 404);
        goto tdSDq;
        tdSDq:
        b38ns:
        goto l47Mh;
        kAcmb:
        return $data_list;
        goto t5GRq;
        M30hR:
        $in = "\50" . $idsStr . "\x29";
        goto v5pec;
        t5GRq:
    }
    /**
     * 批量查询
     * @param $column
     * @param $list
     * @param string $where
     * @return array
     * @throws Exception
     */
    public function selectAllIn($column, $list, $where = '')
    {
        goto LhCbV;
        a_kjR:
        $list = array_unique($list);
        goto QVFLl;
        O5qEq:
        $in .= "\x27" . $list[$i] . "\47";
        goto o9Q6B;
        kX4fc:
        goto VmXLu;
        goto LVC1h;
        WzYFt:
        if (!(sizeof($list) <= 0)) {
            goto wpKZL;
        }
        goto vxSvD;
        Y0wAs:
        $in .= "\x29";
        goto h8WKK;
        UWDB8:
        if (!($i < sizeof($list))) {
            goto nCa7E;
        }
        goto CCJGV;
        cQssJ:
        return $data_list;
        goto uqYdb;
        G8dyY:
        CQ0_C:
        goto WzYFt;
        ArIDx:
        $this->log($list, "\163\x65\154\x65\x63\x74\x20\x61\x6c\x6c\40\151\x6e\x20\163\x71\x6c\40\151\163\40\72{$sql}");
        goto BJQzW;
        ZCX1Z:
        $i++;
        goto bxFyY;
        BJQzW:
        $data_list = pdo_fetchall($sql);
        goto cQssJ;
        bnk2C:
        nCa7E:
        goto Y0wAs;
        QVFLl:
        if (is_array($list)) {
            goto CQ0_C;
        }
        goto iWD9O;
        iWD9O:
        throw new Exception("\346\237\xa5\350\257\xa2\xe5\217\x82\xe6\x95\xb0\xe5\274\x82\345\xb8\xb8", 404);
        goto G8dyY;
        Ybmlc:
        $in = "\x28";
        goto q4aPY;
        q4aPY:
        $i = 0;
        goto vXu3I;
        P5I31:
        $in .= "\54\x27" . $list[$i] . "\47";
        goto kX4fc;
        S6kOx:
        wpKZL:
        goto ig_0x;
        LhCbV:
        global $_W;
        goto TsErX;
        CCJGV:
        if ($i == 0) {
            goto v_7Lt;
        }
        goto P5I31;
        vxSvD:
        throw new Exception("\345\x8f\x82\xe6\x95\xb0\344\270\272\xe7\251\xba", 404);
        goto S6kOx;
        ouxiw:
        kBM_Q:
        goto ZCX1Z;
        h8WKK:
        $sql = "\123\x45\114\105\x43\124\40" . $this->columns . "\40\106\x52\x4f\x4d\40" . tablename($this->table_name) . "\40\127\x48\x45\x52\x45\40\x75\x6e\151\141\x63\151\x64\x3d\x27{$_W["\165\x6e\x69\141\143\x69\x64"]}\x27\x20\141\156\144\40{$column}\40\151\x6e\x20{$in}\x20\x61\156\144\40\x31\75\x31\x20{$where}";
        goto ArIDx;
        Oct6k:
        St86L:
        goto a_kjR;
        HRtMM:
        C9Oer:
        goto Ybmlc;
        vXu3I:
        eclkc:
        goto UWDB8;
        vL7Xu:
        throw new Exception("\344\270\x8d\xe5\255\x98\345\x9c\xa8\xe7\232\x84\345\xb1\236\xe6\x80\xa7", 404);
        goto HRtMM;
        o9Q6B:
        VmXLu:
        goto ouxiw;
        fD7uB:
        $column = "\151\144";
        goto Oct6k;
        TsErX:
        if (!empty($column)) {
            goto St86L;
        }
        goto fD7uB;
        ig_0x:
        $columnArr = explode("\x2c", $this->columns);
        goto Dj05Q;
        Dj05Q:
        if (in_array($column, $columnArr)) {
            goto C9Oer;
        }
        goto vL7Xu;
        bxFyY:
        goto eclkc;
        goto bnk2C;
        LVC1h:
        v_7Lt:
        goto O5qEq;
        uqYdb:
    }
    /**
     * get all data from database
     * @param string $where
     * @param boolean $uniacid 是否过滤uniacid筛选 默认是
     * @return array
     */
    public function selectAll($where = '', $uniacid = true)
    {
        goto p4hle;
        o685D:
        $where = "\x20\101\x4e\x44\40\165\156\x69\x61\143\151\x64\75{$uniacid}\x20{$where}";
        goto t6bJM;
        DSymz:
        $data_list = $this->deal_data_types($data_list, "\154\151\163\x74");
        goto IjEpm;
        NQoA_:
        $this->log($sql, "\x73\x65\154\x65\143\x74\40\141\154\154\40\163\161\154\x20\x69\x73\40\x3a");
        goto Wu10_;
        Wu10_:
        $data_list = pdo_fetchall($sql);
        goto mceT_;
        q5S13:
        if (!$uniacid) {
            goto c2f76;
        }
        goto oxB8r;
        t6bJM:
        c2f76:
        goto xtuAp;
        p4hle:
        global $_W;
        goto q5S13;
        oxB8r:
        $uniacid = $_W["\x75\x6e\x69\141\143\151\x64"];
        goto o685D;
        mceT_:
        $this->log(null, "\x66\145\x74\x63\150\x20" . sizeof($data_list) . "\x20\x69\x74\145\x6d");
        goto DSymz;
        IjEpm:
        return $data_list;
        goto sZaR9;
        xtuAp:
        $sql = "\123\105\114\105\103\x54\x20" . $this->columns . "\40\106\x52\117\x4d\40" . tablename($this->table_name) . "\x20\x57\110\105\122\105\40\x31\x3d\x31\40{$where}";
        goto NQoA_;
        sZaR9:
    }
    public function selectAllJoin($on, $joinService, $where = '')
    {
        goto WuLW4;
        g33WB:
        if (!($joinService->table_name == $this->table_name)) {
            goto dGpjl;
        }
        goto rFdbB;
        i2zjS:
        unset($_GET["\152\x6f\x69\x6e"]);
        goto lKzOs;
        aqjKg:
        dGpjl:
        goto rHb4I;
        AaDG5:
        $all = pdo_fetchall($sql);
        goto i2zjS;
        WuLW4:
        global $_GPC;
        goto aPJeV;
        rHb4I:
        $sql = "\163\x65\x6c\145\143\x74\x20{$joinColumns}\40\146\162\157\x6d\x20" . tablename($this->table_name) . "\40{$this->table_name}\40{$join}\40\152\x6f\151\156\x20" . tablename($joinService->table_name) . "\40{$joinTableAlis}\x20\x6f\x6e\x20{$this->table_name}\x2e\165\156\151\141\x63\x69\144\75{$joinTableAlis}\56\x75\156\x69\141\x63\x69\144\40\x61\x6e\144\40{$on}\40\x77\150\x65\162\145\40\61\75\x31\40{$where}";
        goto AaDG5;
        GTvNM:
        $joinColumns = $this->makeJoinColumns($joinService);
        goto x8DfK;
        rFdbB:
        $joinTableAlis = $this->table_name . "\62";
        goto aqjKg;
        bM35o:
        return $all;
        goto j_5X_;
        x8DfK:
        $joinTableAlis = $joinService->table_name;
        goto g33WB;
        lKzOs:
        $all = $this->deal_data_types($all, "\x6c\x69\x73\x74");
        goto bM35o;
        TE7aO:
        $join = $_GPC["\152\x6f\151\x6e"];
        goto GTvNM;
        aPJeV:
        $sql = '';
        goto TE7aO;
        j_5X_:
    }
    /**
     * 返回key=id的数据
     * @param $where
     * @return array
     */
    public function selectAllMap($where = '')
    {
        goto ftr0k;
        Y21BM:
        $newAll = array();
        goto Ib2kc;
        Ib2kc:
        foreach ($all as $d) {
            $newAll[$d["\x69\x64"]] = $d;
            MDe3z:
        }
        goto JQPrX;
        JQPrX:
        Z2j1d:
        goto h5c2k;
        ftr0k:
        $all = $this->selectAll($where);
        goto Y21BM;
        h5c2k:
        return $newAll;
        goto eIt7U;
        eIt7U:
    }
    /**
     * 查询一条记录
     * @param string $where
     * @return bool
     */
    public function selectOne($where = '')
    {
        goto RFGTd;
        RFGTd:
        global $_W;
        goto BmcnL;
        TetTF:
        $sql = "\123\105\114\105\103\124\x20" . $this->columns . "\x20\x46\122\x4f\x4d\x20" . tablename($this->table_name) . "\40\x57\110\105\x52\105\x20\x75\x6e\x69\x61\143\x69\144\x3d{$uniacid}\40\101\116\104\x20\x31\x3d\x31\40{$where}";
        goto b9ylO;
        sn3CD:
        return $result;
        goto cvMx8;
        wdcF3:
        $result = $this->deal_data_types($result);
        goto sn3CD;
        kzbUw:
        $result = pdo_fetch($sql);
        goto V70Jz;
        BmcnL:
        $uniacid = $_W["\165\x6e\151\141\143\151\x64"];
        goto TetTF;
        V70Jz:
        $this->log($result, "\163\x65\154\145\x63\x74\x4f\156\x65\40\162\145\163\165\x6c\x74");
        goto wdcF3;
        b9ylO:
        $this->log($sql, "\x73\x65\x6c\145\x63\x74\117\x6e\x65\x20\163\x71\x6c");
        goto kzbUw;
        cvMx8:
    }
    public function selectOneJoin($where = '', $on, $joinService)
    {
        goto ChPL2;
        U80LS:
        return $one;
        goto KJGtK;
        PTmsZ:
        $one = $this->deal_data_types($one);
        goto U80LS;
        WnV83:
        $sql = "\x73\x65\154\x65\x63\164\x20{$joinColumns}\x20\x66\x72\x6f\x6d\40" . tablename($this->table_name) . "\x20{$this->table_name}\x20\152\x6f\151\156\x20" . tablename($joinService->table_name) . "\x20{$joinService->table_name}\x20\157\156\40{$on}\x20\167\x68\145\x72\145\40\61\75\61\x20{$where}";
        goto qM1iK;
        ChPL2:
        $joinColumns = $this->makeJoinColumns($joinService);
        goto WnV83;
        qM1iK:
        $one = pdo_fetch($sql);
        goto PTmsZ;
        KJGtK:
    }
    /**
     * 条件查询 指定排序规则
     * @param string $where
     * @param string $order_by
     * @return array
     */
    public function selectAllOrderBy($where = '', $order_by = '')
    {
        goto d6etk;
        Xeozo:
        $data_list = $this->deal_data_types($data_list, "\x6c\151\x73\x74");
        goto fk_R4;
        h2nhI:
        $data_list = pdo_fetchall("\123\105\x4c\x45\103\124\x20" . $this->columns . "\x20\x46\122\117\115\x20" . tablename($this->table_name) . "\40\x57\110\105\x52\x45\x20\x31\75\61\40\x41\x4e\104\40\x75\156\x69\141\x63\x69\144\75{$uniacid}\x20{$where}\x20\117\122\104\105\x52\40\x42\x59\40{$order_by}\x69\144\x20\x41\123\103");
        goto Xeozo;
        d6etk:
        global $_W;
        goto eOdre;
        eOdre:
        $uniacid = $_W["\165\156\151\x61\x63\151\144"];
        goto h2nhI;
        fk_R4:
        return $data_list;
        goto jlCNt;
        jlCNt:
    }
    /**
     * 根据ID删除
     */
    public function deleteById($id)
    {
        goto D2LTw;
        T3yAE:
        return $item;
        goto yBE9j;
        TWBts:
        pdo_delete($this->table_name, array("\151\x64" => $id));
        goto RDv80;
        jqIJ_:
        throw new Exception("\346\227\240\346\263\225\xe5\x88\240\351\231\xa4\357\xbc\214\345\x9b\xa0\344\xb8\xba\350\277\231\346\x9d\241\346\x95\xb0\346\215\xae\xe4\270\x8d\345\255\x98\xe5\234\250", 402);
        goto rD2cg;
        D2LTw:
        $item = $this->selectById($id);
        goto dPMu8;
        rD2cg:
        mXV5W:
        goto TWBts;
        RDv80:
        $this->afterDeleteById($item);
        goto T3yAE;
        dPMu8:
        if (!empty($item)) {
            goto mXV5W;
        }
        goto jqIJ_;
        yBE9j:
    }
    protected function afterDeleteById($item)
    {
    }
    public function softDeleteById($id)
    {
        goto V87vA;
        V87vA:
        $item = $this->selectById($id);
        goto iM9kB;
        VBGpU:
        pdo_update($this->table_name, array("\x69\163\x5f\166\141\154\151\144" => 0), array("\x69\144" => $id));
        goto a43JD;
        kaXwK:
        b1iFm:
        goto VBGpU;
        iM9kB:
        if (!empty($item)) {
            goto b1iFm;
        }
        goto vKQfq;
        vKQfq:
        throw new Exception("\346\x97\xa0\xe6\263\x95\xe5\x88\xa0\351\x99\244\xef\274\214\345\x9b\xa0\xe4\270\xba\350\277\x99\xe6\x9d\xa1\346\x95\xb0\346\x8d\xae\xe4\270\215\345\255\230\xe5\234\xa8", 402);
        goto kaXwK;
        a43JD:
    }
    public function deleteByWhere($where)
    {
        pdo_query("\x64\x65\x6c\x65\x74\x65\40\x66\x72\157\x6d\x20" . tablename($this->table_name) . "\40\167\x68\145\162\145\40\61\75\61\40{$where}");
    }
    public function deleteByIds($ids)
    {
        goto o9Gw0;
        ZQnNT:
        $sql = "\144\x65\154\x65\x74\145\40\x66\x72\157\x6d\40" . tablename($this->table_name) . "\x20\167\150\145\162\x65\40\151\x64\x20\x69\156\40{$in}";
        goto HRvQV;
        HRvQV:
        pdo_query($sql);
        goto Wjn1B;
        oIRd5:
        $in = "\50" . $idsStr . "\x29";
        goto ZQnNT;
        o9Gw0:
        $ids = array_unique($ids);
        goto Fd0lW;
        Fd0lW:
        $idsStr = implode("\54", $ids);
        goto oIRd5;
        Wjn1B:
    }
    /**
     * 插入一条数据
     * @param $param
     * @return bool
     * @throws Exception
     */
    public function insertData($param)
    {
        goto qUcKJ;
        qUcKJ:
        pdo_insert($this->table_name, $param);
        goto tBvJ3;
        V6s1r:
        return $this->selectById($param["\x69\x64"]);
        goto kaFJZ;
        tBvJ3:
        $param["\x69\144"] = pdo_insertid();
        goto V6s1r;
        kaFJZ:
    }
    /**
     * 更新一条数据
     * @param $param
     * @return bool
     * @throws Exception
     */
    public function updateData($param)
    {
        goto TYNx_;
        ojmil:
        $this->log(array($param, $data), "\xe6\x9b\xb4\346\x96\xb0\345\xa4\xb1\350\264\245\357\xbc\214\346\x95\xb0\xe6\x8d\xae\344\xb8\x8d\xe5\xad\230\345\234\250");
        goto rZnj3;
        IvIkj:
        if (!empty($data)) {
            goto Fk4f9;
        }
        goto ojmil;
        TYNx_:
        $id = $param["\151\x64"];
        goto nqPAs;
        iwgYx:
        Fk4f9:
        goto DtQi_;
        rZnj3:
        throw new Exception("\xe6\x9b\264\346\x96\260\345\244\xb1\350\264\245\x2c\xe6\225\260\xe6\215\xae\xe4\270\x8d\xe5\xad\230\xe5\234\xa8", 403);
        goto iwgYx;
        nqPAs:
        $data = $this->selectById($id);
        goto IvIkj;
        Md9Zo:
        return $this->selectById($id);
        goto fdGOj;
        DtQi_:
        pdo_update($this->table_name, $param, array("\x69\x64" => $id));
        goto Md9Zo;
        fdGOj:
    }
    public function updateColumn($column_name, $value, $id)
    {
        goto XaF7Z;
        boqpo:
        tGHEF:
        goto uyVE5;
        XaF7Z:
        if (pdo_fieldexists($this->table_name, $column_name)) {
            goto tGHEF;
        }
        goto nWfL8;
        nWfL8:
        throw new Exception("\xe8\xa1\xa8\xe4\xb8\x8d\xe5\255\x98\xe5\x9c\xa8\133" . $column_name . "\135\345\261\x9e\xe6\200\247", 405);
        goto zcDVf;
        d7YrR:
        k_MjG:
        goto kJu90;
        uyVE5:
        pdo_update($this->table_name, array($column_name => $value), array("\151\x64" => $id));
        goto d7YrR;
        zcDVf:
        goto k_MjG;
        goto boqpo;
        kJu90:
    }
    /**
     * 根据条件更新某个字段
     * @param $column_name
     * @param $value
     * @param string $where
     * @throws Exception
     */
    public function updateColumnByWhere($column_name, $value, $where = '')
    {
        goto SkBd3;
        lg02m:
        $this->log(null, "\346\xa0\xb9\346\x8d\xae\xe6\x9d\xa1\xe4\xbb\266\xe6\x9b\xb4\346\226\xb0\346\x9f\220\xe4\xb8\252\xe5\255\227\346\256\265\357\274\x8c\40\x73\161\x6c\x20\151\163\x20\72\x20{$sql}");
        goto mdMIq;
        DnVwB:
        throw new Exception("\350\xa1\xa8\344\270\215\345\255\230\xe5\x9c\250\x5b" . $column_name . "\135\xe5\xb1\236\346\200\247", 405);
        goto ly83K;
        ly83K:
        goto DCO0i;
        goto QhEZ_;
        OzZv0:
        $setSql = "{$column_name}\75\47{$value}\47";
        goto NiHed;
        dUqcY:
        DCO0i:
        goto Q1MkX;
        NiHed:
        if (!($value == NULL || $value == null)) {
            goto Qsr1D;
        }
        goto gR1Eu;
        bZICF:
        Qsr1D:
        goto xKRKX;
        SkBd3:
        global $_W;
        goto OzZv0;
        xKRKX:
        if (pdo_fieldexists($this->table_name, $column_name)) {
            goto BKVv1;
        }
        goto DnVwB;
        gR1Eu:
        $setSql = "{$column_name}\75\156\x75\x6c\x6c";
        goto bZICF;
        QhEZ_:
        BKVv1:
        goto gk86s;
        mdMIq:
        pdo_query($sql);
        goto dUqcY;
        gk86s:
        $sql = "\x55\x50\x44\101\124\x45\x20" . tablename($this->table_name) . "\x20\x53\x45\124\40{$setSql}\x20\127\x48\105\x52\x45\40\x75\156\151\x61\x63\151\144\x3d{$_W["\165\x6e\x69\141\x63\151\144"]}\x20\x41\x4e\104\40\x31\75\x31\40{$where}";
        goto lg02m;
        Q1MkX:
    }
    /**
     * 给某个int类型的字段 增长值
     * @param $column_name
     * @param $add_count
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function columnAddCount($column_name, $add_count, $id)
    {
        goto oYq9R;
        oYq9R:
        if (pdo_fieldexists($this->table_name, $column_name)) {
            goto JkH7r;
        }
        goto WYjbD;
        WrXCm:
        goto eXQz5;
        goto Lzm1I;
        vgi4G:
        eXQz5:
        goto cB6Rn;
        WYjbD:
        throw new Exception("\350\241\xa8\344\xb8\215\345\255\x98\xe5\x9c\250\x5b" . $column_name . "\135\345\261\x9e\346\x80\xa7", 405);
        goto WrXCm;
        lP3WS:
        $data[$column_name] = $data[$column_name] + $add_count;
        goto rlMRP;
        setmj:
        if (!empty($data)) {
            goto oZFmL;
        }
        goto qZbkB;
        Lzm1I:
        JkH7r:
        goto HgEQC;
        rlMRP:
        $new_data = $this->updateData($data);
        goto zU5uA;
        zU5uA:
        return $new_data;
        goto vgi4G;
        qZbkB:
        throw new Exception("\346\x9b\264\xe6\226\260\345\xa4\xb1\350\xb4\xa5\x2c\346\225\260\346\x8d\xae\344\270\x8d\xe5\xad\x98\345\234\xa8", 403);
        goto fSGmg;
        HgEQC:
        $data = $this->selectById($id);
        goto setmj;
        fSGmg:
        oZFmL:
        goto lP3WS;
        cB6Rn:
    }
    /**
     * 给某个字段减少数量
     * @param $column_name
     * @param $reduce_count
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function columnReduceCount($column_name, $reduce_count, $id)
    {
        goto tkJZ2;
        EsZYE:
        $new_data = $this->updateData($data);
        goto TY55Q;
        JYc2_:
        goto fT89z;
        goto EZL5v;
        EZL5v:
        DrfIh:
        goto PBKz_;
        cGYuU:
        $data[$column_name] = $data[$column_name] - $reduce_count;
        goto EsZYE;
        Z4gxo:
        throw new Exception("\xe8\241\xa8\344\xb8\215\345\255\230\xe5\234\250\133" . $column_name . "\x5d\345\261\x9e\346\x80\xa7", 405);
        goto JYc2_;
        BXhFy:
        throw new Exception("\xe6\233\xb4\xe6\x96\xb0\xe5\244\xb1\350\xb4\245\54\xe6\x95\260\xe6\215\256\344\xb8\215\xe5\xad\x98\xe5\234\xa8", 403);
        goto XQJhq;
        R9wdT:
        fT89z:
        goto a8cR4;
        xMeul:
        if (!empty($data)) {
            goto F50k7;
        }
        goto BXhFy;
        XQJhq:
        F50k7:
        goto cGYuU;
        PBKz_:
        $data = $this->selectById($id);
        goto xMeul;
        TY55Q:
        return $new_data;
        goto R9wdT;
        tkJZ2:
        if (pdo_fieldexists($this->table_name, $column_name)) {
            goto DrfIh;
        }
        goto Z4gxo;
        a8cR4:
    }
    /**
     * 更新或者插入一条数据 当传入的参数中存在id的话则为更新 如果没有id则为插入
     */
    public function insertOrUpdate($param)
    {
        goto rQeZ0;
        tbVHM:
        goto MKQ_u;
        goto KltLw;
        rQeZ0:
        if ($param["\151\x64"]) {
            goto FpwTW;
        }
        goto mL8Rz;
        KltLw:
        FpwTW:
        goto NwC04;
        tFfJ1:
        MKQ_u:
        goto cFfux;
        NwC04:
        return $this->updateData($param);
        goto tFfJ1;
        mL8Rz:
        return $this->insertData($param);
        goto tbVHM;
        cFfux:
    }
    public function count($where = '', $uniacid = true)
    {
        goto E7SWe;
        rZ_Ba:
        return $count;
        goto ZA1_c;
        GuDUl:
        $sql = "\123\x45\x4c\x45\103\124\40\x43\117\125\x4e\x54\x28\x31\x29\x20\106\122\117\x4d\x20" . tablename($this->table_name) . "\x20\x57\x48\105\122\x45\40\61\75\x31\40{$where}";
        goto AISbj;
        FzytN:
        $where = "\x20\141\156\x64\x20\x75\x6e\151\141\x63\151\x64\75{$uniacid}\40{$where}";
        goto kNTdJ;
        AISbj:
        $this->log($sql, "\xe6\x9f\xa5\xe8\xaf\242\x63\x6f\x75\x6e\x74\40\x53\161\154\350\257\255\345\217\245\346\230\xaf");
        goto cIH5E;
        HbTJs:
        $uniacid = $_W["\x75\x6e\x69\141\143\x69\144"];
        goto FzytN;
        YQmZw:
        $count = intval($count);
        goto rZ_Ba;
        cIH5E:
        $count = pdo_fetchcolumn($sql);
        goto YQmZw;
        kNTdJ:
        f3iNI:
        goto GuDUl;
        FTdzp:
        if (!$uniacid) {
            goto f3iNI;
        }
        goto HbTJs;
        E7SWe:
        global $_W;
        goto FTdzp;
        ZA1_c:
    }
    public function selectPageAdmin($where = '', $page_index = '', $page_size = '', $uniacid = true)
    {
        $this->checkRegister();
        return $this->selectPage($where, $page_index, $page_size, $uniacid);
    }
    public function selectPageAdminJoin($where = '', $on, $joinService, $page_index = '', $page_size = '', $uniacid = true)
    {
        $this->checkRegister();
        return $this->selectPageJoin($where, $on, $joinService, $page_index, $page_size, $uniacid);
    }
    /**
     * select the data page
     */
    public function selectPage($where = '', $page_index = '', $page_size = '', $uniacid = true)
    {
        goto jO1MJ;
        DftEu:
        $data = $this->selectAll($where, $uniacid);
        goto Q0f7e;
        GD2FQ:
        if (!empty($page_size)) {
            goto F5wad;
        }
        goto eY6By;
        Yk_hM:
        return array("\x64\141\x74\x61" => $data, "\143\x6f\x75\156\164" => intval($count), "\x70\141\x67\x65\162" => $pager, "\160\141\147\x65\137\151\156\144\145\x78" => $page_index, "\160\141\147\145\x5f\x73\151\172\145" => $page_size);
        goto mpkxI;
        I7KrI:
        CDZ_k:
        goto GD2FQ;
        NWl3e:
        $where = $where . "\40\114\x49\115\111\124\x20" . ($page_index - 1) * $page_size . "\x2c" . $page_size;
        goto DftEu;
        Q0f7e:
        $count = $this->count($count_where, $uniacid);
        goto y89Wk;
        eY6By:
        $page_size = is_null($_GPC["\163\151\172\x65"]) || $_GPC["\163\151\172\x65"] <= 0 ? 20 : $_GPC["\x73\151\172\145"];
        goto L5wWY;
        jO1MJ:
        global $_W, $_GPC;
        goto FSrlE;
        L5wWY:
        F5wad:
        goto k0JGJ;
        FSrlE:
        if (!empty($page_index)) {
            goto CDZ_k;
        }
        goto ejYqL;
        y89Wk:
        $pager = pagination($count, $page_index, $page_size);
        goto Yk_hM;
        k0JGJ:
        $count_where = $where;
        goto NWl3e;
        ejYqL:
        $page_index = max(1, intval($_GPC["\x70\x61\x67\x65"]));
        goto I7KrI;
        mpkxI:
    }
    public function selectPageJoin($where = '', $on = '', $joinService, $page_index = '', $page_size = '', $uniacid = true)
    {
        goto iFDdr;
        bmjGH:
        $uniacid = $_W["\165\156\x69\141\x63\x69\x64"];
        goto Cx3dF;
        ZA1cN:
        $joinTableAlis = $this->table_name . "\x32";
        goto aP_ew;
        RX4jO:
        $count_where = $where;
        goto D3C6c;
        aP_ew:
        rp9yz:
        goto u9io8;
        B9w00:
        $this->log(null, "\103\117\125\116\x54\40\123\121\114\x20\111\x53\357\xbc\x9a" . $countSql);
        goto D5YD1;
        FzK51:
        if (!($join == "\x6c\x65\x66\164" || $join == "\162\x69\147\x68\164")) {
            goto NOEsh;
        }
        goto Fz9N_;
        taBgr:
        $page_size = is_null($_GPC["\x73\x69\172\x65"]) || $_GPC["\x73\x69\x7a\x65"] <= 0 ? 20 : $_GPC["\x73\151\172\x65"];
        goto FQGQZ;
        Fz9N_:
        $join = $_GPC["\152\x6f\x69\x6e"];
        goto o206G;
        o206G:
        NOEsh:
        goto emfhl;
        ISoQo:
        if (!$uniacid) {
            goto mlS5o;
        }
        goto bmjGH;
        bFJK5:
        unset($_GPC["\152\157\151\x6e"]);
        goto FRihR;
        u9io8:
        $sql = "\163\x65\x6c\145\x63\164\40{$joinColumns}\40\146\x72\157\x6d\x20" . tablename($this->table_name) . "\40{$this->table_name}\40{$join}\40\152\x6f\151\x6e\40" . tablename($joinService->table_name) . "\x20{$joinTableAlis}\40\x6f\156\x20{$this->table_name}\x2e\165\156\151\x61\143\x69\x64\75{$joinTableAlis}\56\165\x6e\x69\x61\143\x69\x64\40\141\x6e\x64\x20{$on}\40\167\150\x65\162\x65\x20\x31\x3d\61\40{$where}";
        goto gfmoE;
        fZPYm:
        $page_index = max(1, intval($_GPC["\160\141\x67\x65"]));
        goto ikXWq;
        v8CWI:
        $count = pdo_fetchcolumn($countSql);
        goto msqlv;
        LDDnz:
        $join = $_GPC["\152\x6f\151\x6e"];
        goto FzK51;
        D3C6c:
        $where = $where . "\x20\x4c\111\115\111\x54\x20" . ($page_index - 1) * $page_size . "\54" . $page_size;
        goto p_9e_;
        p_9e_:
        $joinColumns = $this->makeJoinColumns($joinService);
        goto dBCtH;
        gfmoE:
        $this->log(null, "\x53\105\114\x45\103\x54\x20\x53\121\114\x20\x49\x53\357\274\x9a" . $sql);
        goto ubojr;
        rKuKO:
        if (!empty($page_size)) {
            goto S8xXa;
        }
        goto taBgr;
        dBCtH:
        $joinTableAlis = $joinService->table_name;
        goto bG827;
        bG827:
        if (!($joinService->table_name == $this->table_name)) {
            goto rp9yz;
        }
        goto ZA1cN;
        FRihR:
        return array("\144\141\x74\x61" => $data, "\143\x6f\165\x6e\x74" => $count, "\160\141\x67\145\x72" => $pager, "\x70\x61\147\x65\x5f\151\x6e\144\145\170" => $page_index, "\160\141\147\145\137\x73\x69\172\145" => $page_size);
        goto tVbBX;
        emfhl:
        if (!empty($page_index)) {
            goto JbHxz;
        }
        goto fZPYm;
        Z0ll3:
        mlS5o:
        goto RX4jO;
        ikXWq:
        JbHxz:
        goto rKuKO;
        Cx3dF:
        $where = "\40\x41\x4e\x44\x20{$this->table_name}\56\x75\156\151\141\x63\151\144\x3d{$uniacid}\40{$where}";
        goto Z0ll3;
        D5YD1:
        $data = pdo_fetchall($sql);
        goto v8CWI;
        FQGQZ:
        S8xXa:
        goto ISoQo;
        msqlv:
        $pager = pagination($count, $page_index, $page_size);
        goto bFJK5;
        iFDdr:
        global $_W, $_GPC;
        goto LDDnz;
        ubojr:
        $countSql = "\123\105\114\x45\103\124\40\x43\117\125\116\124\50\61\51\40\106\x52\117\115\x20" . tablename($this->table_name) . "\40{$this->table_name}\x20{$join}\40\152\157\x69\156\40" . tablename($joinService->table_name) . "\x20{$joinTableAlis}\40\157\156\x20{$this->table_name}\x2e\165\x6e\x69\x61\x63\151\144\x3d{$joinTableAlis}\56\x75\156\151\x61\x63\151\x64\40\141\156\144\x20{$on}\x20\x57\110\x45\x52\x45\40\x31\x3d\61\40{$count_where}";
        goto B9w00;
        tVbBX:
    }
    public function joinColumns($alias = '')
    {
        goto nImeA;
        nImeA:
        if (!($alias == '')) {
            goto mbUmw;
        }
        goto M6PoF;
        hSYId:
        $joinColumnsArr = array();
        goto b8mCm;
        M6PoF:
        $alias = $this->table_name;
        goto iQQUV;
        ahElo:
        LXcWP:
        goto yaxhd;
        b8mCm:
        foreach ($columns as $field) {
            goto slfS9;
            RTm6l:
            M4qEF:
            goto phhDZ;
            f0KUO:
            Qba8h:
            goto RTm6l;
            slfS9:
            if (empty($field)) {
                goto Qba8h;
            }
            goto lpqLD;
            lpqLD:
            $joinColumnsArr[] = $alias . "\56" . $field;
            goto f0KUO;
            phhDZ:
        }
        goto ahElo;
        iQQUV:
        mbUmw:
        goto mLrTy;
        yaxhd:
        return implode("\x2c", $joinColumnsArr);
        goto uglVn;
        mLrTy:
        $columns = explode("\x2c", $this->columns);
        goto hSYId;
        uglVn:
    }
    private function makeJoinColumns($joinService)
    {
        goto WUkS8;
        WN9oN:
        i0dwa:
        goto qs7tl;
        DrZV_:
        $joinColumnsArr = array();
        goto cG5Ya;
        cG5Ya:
        foreach ($columns as $field) {
            goto HzEFi;
            nIyI2:
            K3S0s:
            goto GDucu;
            gwGnI:
            MarxI:
            goto nIyI2;
            HzEFi:
            if (empty($field)) {
                goto MarxI;
            }
            goto Z4iAz;
            Z4iAz:
            $joinColumnsArr[] = $this->table_name . "\56" . $field;
            goto gwGnI;
            GDucu:
        }
        goto YCo5L;
        Y7kZn:
        foreach ($joinColumns as $field) {
            goto iI34K;
            iI34K:
            if (empty($field)) {
                goto bwwUF;
            }
            goto GaAcR;
            v8aIx:
            goto NUgQt;
            goto Kspo_;
            jlGmR:
            wOAYQ:
            goto rLC0n;
            Kspo_:
            gRQ6Y:
            goto NjKOf;
            AIP23:
            $joinColumnsArr[] = "{$joinTable}\x2e{$field}\40\40\x61\x73\40{$joinTable}\137{$field}";
            goto v8aIx;
            on_Dt:
            bwwUF:
            goto jlGmR;
            ZAQQi:
            NUgQt:
            goto on_Dt;
            GaAcR:
            if (!in_array($field, $columns)) {
                goto gRQ6Y;
            }
            goto AIP23;
            NjKOf:
            $joinColumnsArr[] = "{$joinTable}\56{$field}";
            goto ZAQQi;
            rLC0n:
        }
        goto WN9oN;
        SsWdA:
        $joinTable = $joinService->table_name;
        goto SCaUg;
        WUkS8:
        $columns = explode("\54", $this->columns);
        goto DrZV_;
        RvVLK:
        $joinTable = $this->table_name . "\x32";
        goto wczKu;
        qs7tl:
        return implode("\54", $joinColumnsArr);
        goto ve0NH;
        O8Y0W:
        $joinColumns = explode("\x2c", $joinService->columns);
        goto SsWdA;
        wczKu:
        AWiRL:
        goto Y7kZn;
        SCaUg:
        if (!($joinTable == $this->table_name)) {
            goto AWiRL;
        }
        goto RvVLK;
        YCo5L:
        EVtsQ:
        goto O8Y0W;
        ve0NH:
    }
    public function rankOne($id, $where = '', $referToColumn = '')
    {
        goto okOQM;
        DLSb_:
        if (empty($referToColumn)) {
            goto iePgR;
        }
        goto TZDzB;
        d812a:
        return $result["\x72\x61\x6e\x6b"];
        goto HaxeG;
        ZVDr9:
        $aColumnsString = implode("\54", $aColumnsArr);
        goto spRMr;
        k3hN_:
        I1_DU:
        goto GurZ2;
        ZCxE9:
        foreach ($columnsArr as $f) {
            goto j7fkY;
            mhi2y:
            YaXKd:
            goto XZS8h;
            j7fkY:
            $rColumnsArr[] = "\x72\56" . $f;
            goto MRvOn;
            MRvOn:
            $aColumnsArr[] = "\141\56" . $f;
            goto mhi2y;
            XZS8h:
        }
        goto k3hN_;
        ryFWV:
        $columnsArr = explode("\54", $this->columns);
        goto s7ane;
        QS9UL:
        iePgR:
        goto ryFWV;
        okOQM:
        $baseWhere = "\x72\x2e\151\144\75{$id}";
        goto DLSb_;
        GurZ2:
        $rColumnsString = implode("\54", $rColumnsArr);
        goto ZVDr9;
        TZDzB:
        $baseWhere = "\x72\56{$referToColumn}\x3d{$id}";
        goto QS9UL;
        spRMr:
        $result = pdo_fetch("\x73\x65\154\x65\143\x74\x20{$rColumnsString}\54\162\x2e\162\x61\x6e\153\x20\x66\162\x6f\x6d\x20\50\163\x65\x6c\x65\x63\164\40{$aColumnsString}\x2c\50\x40\162\x6f\x77\116\165\x6d\x3a\75\x40\162\157\x77\x4e\x75\155\x2b\x31\x29\40\141\x73\40\x72\x61\x6e\x6b\40\146\162\x6f\155\x20" . tablename($this->table_name) . "\x20\141\54\x28\x73\x65\x6c\145\x63\x74\40\50\100\x72\157\167\116\165\x6d\40\72\75\60\x29\51\x20\x62\40\167\x68\x65\x72\145\40\61\x3d\61\x20{$where}\51\x20\141\x73\40\x72\x20\x77\x68\x65\x72\x65\40{$baseWhere}\x20\x41\x4e\104\x20\61\75\61\x20");
        goto d812a;
        s7ane:
        $rColumnsArr = array();
        goto MuWEx;
        MuWEx:
        $aColumnsArr = array();
        goto ZCxE9;
        HaxeG:
    }
    public function selectPageOrderByAdmin($where = '', $order_by = '', $page_index = '', $page_size = '', $uniacid = true)
    {
        $this->checkRegister();
        return $this->selectPageOrderBy($where, $order_by, $page_index, $page_size, $uniacid);
    }
    public function selectPageOrderByJoinAdmin($where = '', $order_by = '', $on = '', $joinService = '', $page_index = '', $page_size = '', $uniacid = true)
    {
        $this->checkRegister();
        return $this->selectPageOrderByJoin($where, $order_by, $on, $joinService, $page_index, $page_size, $uniacid);
    }
    /**
     * selectPage order by param
     * orderby create_time Desc,uniacid ASC,
     */
    public function selectPageOrderBy($where = '', $order_by = '', $page_index = '', $page_size = '', $uniacid = true)
    {
        goto yjcR5;
        kd5Xi:
        jKsdS:
        goto djviY;
        czj9X:
        $page_size = is_null($_GPC["\163\x69\172\x65"]) || $_GPC["\x73\151\x7a\145"] <= 0 ? 20 : $_GPC["\x73\x69\172\x65"];
        goto kd5Xi;
        yjcR5:
        global $_W, $_GPC;
        goto vV2sA;
        d5AAp:
        if (!(substr($order_by, -1) == "\x2c")) {
            goto EHI1X;
        }
        goto lYZ0e;
        ofqoy:
        $data = $this->selectAll($where, $uniacid);
        goto NiMK2;
        w8gEB:
        t_tIT:
        goto AqdDO;
        e8k3w:
        $where = $where . "\40\x4f\x52\104\x45\122\40\x42\x59\40{$order_by}\x20\114\111\x4d\111\x54\x20" . ($page_index - 1) * $page_size . "\x2c" . $page_size;
        goto ofqoy;
        vV2sA:
        if (empty($order_by)) {
            goto J905x;
        }
        goto d5AAp;
        SmHrJ:
        J905x:
        goto xjMQj;
        lYZ0e:
        $order_by = substr($order_by, 0, strlen($order_by) - 1);
        goto zm0dP;
        NiMK2:
        $count = $this->count($count_where, $uniacid);
        goto rGu0m;
        rGu0m:
        $pager = pagination($count, $page_index, $page_size);
        goto FH8aH;
        zm0dP:
        EHI1X:
        goto SmHrJ;
        djviY:
        $count_where = $where;
        goto e8k3w;
        AqdDO:
        if (!empty($page_size)) {
            goto jKsdS;
        }
        goto czj9X;
        xjMQj:
        if (!empty($page_index)) {
            goto t_tIT;
        }
        goto Jd8ZK;
        FH8aH:
        return array("\x64\141\x74\x61" => $data, "\143\x6f\x75\x6e\x74" => intval($count), "\160\x61\x67\x65\162" => $pager, "\160\x61\147\145\x5f\x69\156\x64\145\170" => intval($page_index), "\x70\x61\147\145\137\x73\151\172\145" => intval($page_size));
        goto gfFs4;
        Jd8ZK:
        $page_index = max(1, intval($_GPC["\x70\x61\147\x65"]));
        goto w8gEB;
        gfFs4:
    }
    public function selectPageOrderByJoin($where = '', $order_by = '', $on = '', $joinService, $page_index = '', $page_size = '', $uniacid = true)
    {
        goto XOE17;
        Ojeap:
        $pager = pagination($count, $page_index, $page_size);
        goto tBvXF;
        tJEKR:
        $data = pdo_fetchall($sql);
        goto m7S7v;
        UOfmH:
        if (!(substr($order_by, -1) == "\x2c")) {
            goto RTZEU;
        }
        goto hXzqB;
        LsYeC:
        $join = $_GPC["\x6a\x6f\151\156"];
        goto cVoCo;
        Tjik6:
        $uniacid = $_W["\x75\x6e\x69\x61\x63\151\144"];
        goto FYzaQ;
        l4Y6E:
        sOsWt:
        goto O_lyA;
        seYRU:
        $this->log(null, "\103\x6f\x75\156\x74\40\346\x9f\xa5\xe8\xaf\242\347\x9a\204\163\161\154\350\xaf\255\xe5\217\245\346\230\257\72{$sql}");
        goto wHwxf;
        KAHod:
        kqJc4:
        goto lofgA;
        zm57y:
        $count = pdo_fetchcolumn($countSql);
        goto PwvLW;
        RS5z7:
        $this->log(null, "\x53\145\154\x65\x63\164\x20\346\x9f\245\xe8\xaf\xa2\347\232\204\x73\161\154\350\xaf\xad\345\x8f\245\346\x98\xaf\x3a{$sql}");
        goto eaoav;
        O_lyA:
        if (!empty($page_size)) {
            goto CU2f5;
        }
        goto fsqc1;
        oYVEB:
        uQ9NN:
        goto T8icp;
        m7S7v:
        $this->log(null, "\x20\146\x65\143\150\141\154\x6c" . sizeof($data) . "\40\351\x9c\200\350\246\x81\xe7\232\x84\xe6\227\xb6\351\x97\264\xe6\230\257\72" . (time() - $startAll));
        goto Bblgg;
        wHwxf:
        $startAll = time();
        goto tJEKR;
        DO8Cv:
        return array("\144\141\164\x61" => $data, "\x63\157\x75\156\164" => intval($count), "\160\x61\x67\145\162" => $pager, "\160\x61\x67\145\x5f\x69\156\x64\x65\x78" => intval($page_index), "\x70\x61\x67\x65\137\163\x69\172\x65" => intval($page_size));
        goto HVI97;
        XOE17:
        global $_W, $_GPC;
        goto LsYeC;
        PLDaS:
        KFP_X:
        goto G6qaX;
        Bblgg:
        $startCount = time();
        goto zm57y;
        dUugw:
        $join = $_GPC["\x6a\157\151\x6e"];
        goto PLDaS;
        yUKUd:
        RTZEU:
        goto KAHod;
        pj0bN:
        NMqaP:
        goto j6_Z5;
        EhVrP:
        $joinColumns = $this->makeJoinColumns($joinService);
        goto V4brC;
        FYzaQ:
        $where = "\40\101\116\104\40{$this->table_name}\56\165\x6e\x69\x61\x63\x69\144\75{$uniacid}\x20{$where}";
        goto pj0bN;
        T8icp:
        $count_where = $where;
        goto tRDNE;
        TTbkV:
        if (!($joinService->table_name == $this->table_name)) {
            goto uQ9NN;
        }
        goto LeB6S;
        j6_Z5:
        $joinColumns = $this->makeJoinColumns($joinService);
        goto Cga9j;
        Cga9j:
        $joinTableAlis = $joinService->table_name;
        goto TTbkV;
        V4brC:
        $sql = "\163\x65\x6c\x65\x63\164\40{$joinColumns}\40\x66\162\157\155\40" . tablename($this->table_name) . "\40{$this->table_name}\40{$join}\x20\152\157\151\x6e\x20" . tablename($joinService->table_name) . "\x20{$joinTableAlis}\x20\157\x6e\x20{$on}\40\x77\150\145\x72\x65\40\x31\75\61\40{$where}";
        goto RS5z7;
        hXzqB:
        $order_by = substr($order_by, 0, strlen($order_by) - 1);
        goto yUKUd;
        PwvLW:
        $this->log(null, "\x20\x63\x6f\x75\156\164\40\xe7\xbb\x93\xe6\236\234{$count}\40\351\x9c\x80\xe8\246\x81\xe7\232\x84\346\x97\266\xe9\227\264\xe6\x98\257\x3a" . (time() - $startCount));
        goto Ojeap;
        h3CIO:
        $page_index = max(1, intval($_GPC["\160\x61\x67\x65"]));
        goto l4Y6E;
        LeB6S:
        $joinTableAlis = $this->table_name . "\62";
        goto oYVEB;
        eaoav:
        $countSql = "\123\105\114\x45\103\124\x20\103\117\x55\116\124\x28\61\x29\40\106\122\x4f\115\x20" . tablename($this->table_name) . "\40{$this->table_name}\40{$join}\x20\152\157\x69\156\40" . tablename($joinService->table_name) . "\40{$joinTableAlis}\40\157\156\40{$on}\x20\127\110\105\122\x45\x20\61\x3d\61\x20{$count_where}";
        goto seYRU;
        cVoCo:
        if (!($join == "\x6c\145\146\x74" || $join == "\x72\x69\x67\150\x74")) {
            goto KFP_X;
        }
        goto dUugw;
        tRDNE:
        $where = $where . "\x20\x4f\x52\x44\105\122\x20\x42\131\40{$order_by}\x20\x4c\x49\x4d\111\x54\x20" . ($page_index - 1) * $page_size . "\x2c" . $page_size;
        goto EhVrP;
        owcJM:
        CU2f5:
        goto PDHH2;
        PDHH2:
        if (!$uniacid) {
            goto NMqaP;
        }
        goto Tjik6;
        G6qaX:
        if (empty($order_by)) {
            goto kqJc4;
        }
        goto UOfmH;
        fsqc1:
        $page_size = is_null($_GPC["\x73\x69\172\145"]) || $_GPC["\x73\x69\172\x65"] <= 0 ? 20 : $_GPC["\x73\x69\172\145"];
        goto owcJM;
        lofgA:
        if (!empty($page_index)) {
            goto sOsWt;
        }
        goto h3CIO;
        tBvXF:
        unset($_GPC["\152\x6f\x69\x6e"]);
        goto DO8Cv;
        HVI97:
    }
    public function loopSetColumnObjToArray($list, $column, $objName = "\157\x62\152")
    {
        goto RyrSZ;
        DEBq7:
        POnQZ:
        goto M2skM;
        yrZ21:
        fzlvS:
        goto cw_n2;
        cJOMk:
        foreach ($targets as $data) {
            $targetMap[$data["\x69\x64"]] = $data;
            wv0A5:
        }
        goto D3CHK;
        P4AvF:
        return $list;
        goto tFxKK;
        RyrSZ:
        if (!empty($list)) {
            goto nbVAT;
        }
        goto P4AvF;
        oHX2m:
        $columnIds = array();
        goto lvrrY;
        cw_n2:
        $targets = $this->selectByIds($columnIds);
        goto B4LAw;
        tFxKK:
        nbVAT:
        goto oHX2m;
        B4LAw:
        $targetMap = array();
        goto cJOMk;
        hS_BU:
        if (!empty($columnIds)) {
            goto fzlvS;
        }
        goto ZKCbM;
        T1ZgR:
        goto HceOG;
        goto yrZ21;
        ZKCbM:
        return $list;
        goto T1ZgR;
        lvrrY:
        foreach ($list as $l) {
            goto ZuVQ_;
            ZuVQ_:
            if (!($l[$column] != null && $l[$column] > 0 && !in_array($l[$column], $columnIds))) {
                goto ycG8s;
            }
            goto SxAQl;
            wYZEl:
            ycG8s:
            goto rpiu7;
            SxAQl:
            $columnIds[] = $l[$column];
            goto wYZEl;
            rpiu7:
            DAFN_:
            goto WmUrp;
            WmUrp:
        }
        goto G3ZK5;
        mFGyq:
        $newList = array();
        goto SO0Ft;
        D3CHK:
        qWiiD:
        goto mFGyq;
        SO0Ft:
        foreach ($list as $l) {
            goto axRtr;
            BsKvR:
            M3SuR:
            goto NbEjI;
            axRtr:
            $l[$objName] = $targetMap[$l[$column]];
            goto eR6f8;
            eR6f8:
            $newList[] = $l;
            goto BsKvR;
            NbEjI:
        }
        goto DEBq7;
        S0LkR:
        HceOG:
        goto Oh_3n;
        G3ZK5:
        k3YBz:
        goto hS_BU;
        M2skM:
        return $newList;
        goto S0LkR;
        Oh_3n:
    }
    public function loopSetColumnObjToArrayIn($list, $column, $objName = "\x6f\142\152", $inColumn = '')
    {
        goto FGZ4X;
        FhlEt:
        $newList = array();
        goto Amf5r;
        cFwhI:
        Dfbre:
        goto oNiO0;
        Jyo8v:
        wlhAD:
        goto UvC2h;
        oNiO0:
        $columnIds = array();
        goto LHHDa;
        UvC2h:
        return $newList;
        goto pHM6k;
        u3ilz:
        ZPrWs:
        goto MJKUW;
        zGKeL:
        $targetMap = array();
        goto u2Ojd;
        rDpFt:
        gvbaq:
        goto NhFHW;
        rND9K:
        goto wHogt;
        goto rDpFt;
        LHHDa:
        foreach ($list as $l) {
            goto LtnHM;
            LtnHM:
            if (!($l[$column] != null && strlen($l[$column]) > 0 && !in_array($l[$column], $columnIds))) {
                goto CIojc;
            }
            goto G9p08;
            G9p08:
            $columnIds[] = $l[$column];
            goto tJ1ZJ;
            c_Tie:
            fejvo:
            goto R1Kuy;
            tJ1ZJ:
            CIojc:
            goto c_Tie;
            R1Kuy:
        }
        goto u3ilz;
        hzBVd:
        return $list;
        goto cFwhI;
        NhFHW:
        $targets = $this->selectAllIn($inColumn, $columnIds);
        goto zGKeL;
        u2Ojd:
        foreach ($targets as $data) {
            $targetMap[$data[$inColumn]] = $data;
            Tz5Zv:
        }
        goto NTTf5;
        FGZ4X:
        if (!empty($list)) {
            goto Dfbre;
        }
        goto hzBVd;
        MJKUW:
        if (!empty($columnIds)) {
            goto gvbaq;
        }
        goto EOAbJ;
        NTTf5:
        b53Rp:
        goto FhlEt;
        pHM6k:
        wHogt:
        goto MyY5A;
        Amf5r:
        foreach ($list as $l) {
            goto VyFw1;
            o6wPD:
            $newList[] = $l;
            goto dI_d9;
            dI_d9:
            Gm1pY:
            goto zRKq0;
            VyFw1:
            $l[$objName] = $targetMap[$l[$column]];
            goto o6wPD;
            zRKq0:
        }
        goto Jyo8v;
        EOAbJ:
        return $list;
        goto rND9K;
        MyY5A:
    }
    /**
     * 给出id，或者对象，返回对象
     * @param $objOrId
     * @return bool
     * @throws Exception
     */
    public function checkObjOrId($objOrId)
    {
        goto slshl;
        Vf8zN:
        goto IOWVC;
        goto wv2DV;
        sLMQv:
        return $objOrId;
        goto JMSmr;
        G4aEU:
        if (empty($objOrId["\x69\144"])) {
            goto FPeQv;
        }
        goto sLMQv;
        lZoNT:
        throw new Exception("\xe9\235\236\xe6\263\225\347\232\x84\xe5\255\227\xe6\xae\xb5", 404);
        goto Vf8zN;
        QJOXu:
        throw new Exception("\351\235\236\346\263\x95\xe7\232\x84\xe5\xad\227\xe6\256\265", 404);
        goto JP6lp;
        xbMbI:
        return $this->selectById($objOrId);
        goto re6SZ;
        re6SZ:
        a39zh:
        goto lZoNT;
        slshl:
        if (is_array($objOrId)) {
            goto vgr6q;
        }
        goto Ti14d;
        JP6lp:
        IOWVC:
        goto XN6px;
        Ti14d:
        if (!is_numeric($objOrId)) {
            goto a39zh;
        }
        goto xbMbI;
        JMSmr:
        FPeQv:
        goto QJOXu;
        wv2DV:
        vgr6q:
        goto G4aEU;
        XN6px:
    }
    /**
     * 记录日志
     */
    public function log($content, $desc = '', $json = true, $file = false)
    {
        goto HAj1a;
        EPoLo:
        if (!($_GPC["\137\141\x63\x74\x69\157\x6e"] == "\x61\x70\x70\x2e\101\x70\160\x2e\142\150\x76")) {
            goto Hsumv;
        }
        goto yYMiz;
        GyjN3:
        $filename = $this->plugin_name . $date;
        goto Ur3tI;
        HAj1a:
        global $_W, $_GPC;
        goto EPoLo;
        UPErw:
        $log = json_encode($content) . "\12";
        goto KbfQ2;
        KbfQ2:
        Kor4J:
        goto dOcnw;
        dOcnw:
        $log = $desc . "\72\12" . $log . "\12";
        goto VXdkx;
        kHQlz:
        Hsumv:
        goto XxFO5;
        aLmDq:
        logging_run($log, $type = "\164\x72\141\x63\x65", $filename);
        goto D3pF1;
        XxFO5:
        load()->func("\x6c\157\x67\x67\151\x6e\x67");
        goto Ml6Vh;
        iC7yb:
        xYAeo:
        goto aLmDq;
        FtLJB:
        if (!$json) {
            goto Kor4J;
        }
        goto UPErw;
        yYMiz:
        return false;
        goto kHQlz;
        VXdkx:
        $date = date("\x59\55\155\x2d\144\x2d\150", time());
        goto GyjN3;
        hZTe3:
        $filename = $file;
        goto iC7yb;
        Ur3tI:
        if (!$file) {
            goto xYAeo;
        }
        goto hZTe3;
        Ml6Vh:
        $log = $content;
        goto FtLJB;
        D3pF1:
    }
    /**
     * get wechat account,because there will be two ways to make uniacid
     */
    public function createWexinAccount()
    {
        goto By7hC;
        qTs2r:
        return $account;
        goto nLNcn;
        By7hC:
        global $_W;
        goto NkqX1;
        NkqX1:
        load()->classs("\x77\145\x69\x78\151\156\x2e\141\x63\143\157\x75\x6e\164");
        goto DJCMs;
        asCs1:
        if (!(!empty($acid) && $acid != $uniacid)) {
            goto NXNEd;
        }
        goto Ff1Bi;
        KaRa8:
        $uniacid = $_W["\165\156\x69\x61\143\x69\144"];
        goto f18TJ;
        M89cr:
        NXNEd:
        goto zl2l9;
        nBJ4F:
        whslf:
        goto qTs2r;
        DJCMs:
        $acid = $_W["\x61\x63\x63\x6f\165\156\164"]["\141\143\x69\x64"];
        goto KaRa8;
        Ff1Bi:
        $account = WeiXinAccount::create($_W["\x61\x63\x63\157\165\x6e\x74"]["\x61\143\151\x64"]);
        goto M89cr;
        zl2l9:
        if (!empty($account)) {
            goto whslf;
        }
        goto rIIK2;
        f18TJ:
        $account = null;
        goto asCs1;
        rIIK2:
        $account = WeiXinAccount::create($_W["\x75\156\151\141\x63\x69\x64"]);
        goto nBJ4F;
        nLNcn:
    }
    public function getUniacid()
    {
        goto L1L2d;
        n5w34:
        OWVxh:
        goto R3g77;
        bYN42:
        $uniacid = $_W["\x75\156\x69\x61\143\151\144"];
        goto bSit5;
        L1L2d:
        global $_W;
        goto KEfty;
        PXUgr:
        $acid = $_W["\141\143\x63\157\165\156\x74"]["\141\x63\151\144"];
        goto bYN42;
        q_xTy:
        return $acid;
        goto n5w34;
        wa8j7:
        return $uniacid;
        goto nEz8i;
        bSit5:
        if (!empty($acid) && $acid != $uniacid) {
            goto S7jet;
        }
        goto wa8j7;
        KEfty:
        load()->classs("\x77\145\x69\x78\151\x6e\x2e\x61\x63\143\x6f\x75\156\x74");
        goto PXUgr;
        nEz8i:
        goto OWVxh;
        goto A0fzL;
        A0fzL:
        S7jet:
        goto q_xTy;
        R3g77:
    }
    /**
     * 发送客服消息
     * @param $toUserOpenid
     * @param $content
     * @return array|mixed
     */
    public function sendTextMessage($toUserOpenid, $content)
    {
        goto TAJcZ;
        TAJcZ:
        global $_W;
        goto h_nSn;
        da8x1:
        return $account->sendCustomNotice($send);
        goto NoejO;
        h_nSn:
        $send = array("\x6d\x73\x67\x74\171\160\145" => "\x74\145\x78\x74", "\164\x6f\165\163\x65\162" => $toUserOpenid, "\164\x65\x78\x74" => array("\x63\157\x6e\x74\145\x6e\164" => urlencode($content)));
        goto W_SyL;
        W_SyL:
        $account = $this->createWexinAccount();
        goto da8x1;
        NoejO:
    }
    public function sendNewsMessage($toUserOpenid, $news)
    {
        goto V1Gsu;
        GKWG1:
        return $result;
        goto X7VMq;
        kQMbx:
        $account = $this->createWexinAccount();
        goto ypBq8;
        CBhLO:
        $send = array("\x74\x6f\x75\x73\145\162" => $toUserOpenid, "\155\x73\x67\x74\x79\x70\x65" => "\156\145\167\163", "\156\145\167\163" => array("\141\x72\164\151\x63\154\145\x73" => $news));
        goto kQMbx;
        HJ8xs:
        $this->log($result, "\xe5\x8f\x91\351\x80\201\x6e\145\167\163\347\273\223\xe6\236\234\xe4\270\xba");
        goto GKWG1;
        V1Gsu:
        global $_W;
        goto CBhLO;
        ypBq8:
        $result = $account->sendCustomNotice($send);
        goto HJ8xs;
        X7VMq:
    }
    public function sendVoiceMessage($toUserOpenid, $mediaId)
    {
        goto cIwzO;
        cIwzO:
        global $_W;
        goto q_0g5;
        q_0g5:
        $send = array("\155\x73\x67\164\x79\x70\145" => "\166\157\x69\143\x65", "\164\157\x75\x73\145\x72" => $toUserOpenid, "\x76\x6f\151\x63\145" => array("\155\x65\144\151\x61\137\151\x64" => $mediaId));
        goto U3Quy;
        JjPBe:
        return $account->sendCustomNotice($send);
        goto nvTmX;
        U3Quy:
        $account = $this->createWexinAccount();
        goto JjPBe;
        nvTmX:
    }
    public function sendImageMessage($toUserOpenid, $mediaId)
    {
        goto Gb5ut;
        Gb5ut:
        global $_W;
        goto gQcRv;
        gQcRv:
        $send = array("\155\163\x67\x74\171\160\145" => "\151\x6d\x61\147\x65", "\164\x6f\x75\x73\x65\162" => $toUserOpenid, "\x69\x6d\141\147\x65" => array("\x6d\145\x64\x69\x61\137\151\144" => $mediaId));
        goto hdKwA;
        hdKwA:
        $account = $this->createWexinAccount();
        goto UeehC;
        UeehC:
        return $account->sendCustomNotice($send);
        goto P1MUe;
        P1MUe:
    }
    /**
     * post请求
     * @param $url
     * @param array $postData
     * @return mixed
     */
    public function httpPost($url, $postData = array())
    {
        goto wBhHC;
        v8dov:
        return $result["\143\x6f\156\x74\x65\x6e\x74"];
        goto myDMi;
        iWFDX:
        $result = ihttp_request($url, $postData, $headers, 3);
        goto v8dov;
        wBhHC:
        load()->func("\x63\x6f\x6d\x6d\x75\156\151\x63\x61\x74\151\157\156");
        goto xoDE6;
        xoDE6:
        $headers = array("\x43\x6f\x6e\x74\145\x6e\x74\x2d\124\171\160\145" => "\x61\160\160\x6c\151\x63\141\164\151\157\156\x2f\x78\55\167\167\x77\x2d\146\x6f\162\x6d\55\165\x72\x6c\x65\x6e\143\x6f\x64\145\144");
        goto iWFDX;
        myDMi:
    }
    public function httpGet($url, $param = array())
    {
        goto x4Q1u;
        x4Q1u:
        load()->func("\143\157\155\155\165\x6e\151\x63\x61\x74\x69\x6f\156");
        goto oGzEM;
        fqec6:
        aM5Eh:
        goto vEaiK;
        Q1bhj:
        Quwwm:
        goto fqec6;
        oGzEM:
        $api = $url;
        goto R0M15;
        v434G:
        foreach ($param as $key => $value) {
            goto YBdxG;
            oUy5K:
            $api .= "\46" . $key . "\x3d" . $value;
            goto Esc6A;
            MBVU4:
            kr0qp:
            goto eCojQ;
            UB6c9:
            $first = true;
            goto kaw1p;
            Esc6A:
            goto yQkd7;
            goto jaIDx;
            kaw1p:
            yQkd7:
            goto MBVU4;
            YBdxG:
            if ($first == false) {
                goto jW3lB;
            }
            goto oUy5K;
            n9w5c:
            $api .= "\77" . $key . "\75" . $value;
            goto UB6c9;
            jaIDx:
            jW3lB:
            goto n9w5c;
            eCojQ:
        }
        goto Q1bhj;
        vEaiK:
        $result = ihttp_get($api);
        goto LLI3r;
        LLI3r:
        return $result["\x63\x6f\x6e\164\145\156\164"];
        goto nq0vv;
        R0M15:
        if (empty($param)) {
            goto aM5Eh;
        }
        goto ebcg8;
        ebcg8:
        $first = $normal = strpos($api, "\77");
        goto v434G;
        nq0vv:
    }
    public function fetchCopyWrite()
    {
        goto Q8bpk;
        ST7af:
        $one = pdo_fetch("\x73\145\154\145\143\x74\x20\x2a\40\146\162\x6f\x6d\x20" . tablename("\x61\162\164\x69\x63\x6c\145\137\x63\x61\164\145\147\x6f\162\171"));
        goto eS4ig;
        k20FR:
        if ($tip) {
            goto gDrwn;
        }
        goto ST7af;
        rjArJ:
        $content = $result["\144\141\x74\141"]["\x63\x6f\x6e\x74\x65\156\164"];
        goto xyB_0;
        AZNSM:
        if (!is_numeric($result["\143\157\144\x65"])) {
            goto n388I;
        }
        goto EvuIJ;
        UfDvE:
        d30Cn:
        goto a2Mxm;
        MO68k:
        die(message($result["\x6d\163\147"], '', base64_decode("\132\x58\x4a\x79\142\63\111\x3d")));
        goto UfDvE;
        A2YyI:
        $result = $this->jsonString2Array($result);
        goto fTN1c;
        g3Rtm:
        $end = time();
        goto lqQg2;
        EvuIJ:
        if (!($result["\143\x6f\144\145"] != 200)) {
            goto d30Cn;
        }
        goto MO68k;
        eS4ig:
        pdo_insert("\141\x72\164\151\143\154\145\137\x6e\157\164\x69\143\x65", array("\143\141\164\145\151\x64" => $one["\x69\144"], "\x74\x69\x74\154\145" => $title, "\x63\x6f\156\x74\x65\156\x74" => $content, "\151\163\137\x73\x68\157\167\x5f\x68\157\x6d\145" => 1, "\143\x72\145\141\164\x65\164\x69\x6d\145" => time()));
        goto EvHVz;
        xyB_0:
        $tip = pdo_fetch("\x73\x65\154\x65\143\164\40\x69\144\54\164\x69\x74\154\145\40\x66\162\x6f\155\40" . tablename("\x61\x72\164\x69\143\x6c\x65\x5f\156\157\164\x69\143\x65") . "\x20\167\x68\x65\162\x65\x20\164\151\164\154\145\40\x6c\x69\x6b\145\x20\x27\45{$title}\45\x27\x20\141\156\144\x20\61\75\61\40{$where}");
        goto k20FR;
        jJMeM:
        $where = $result["\x64\x61\164\x61"]["\x77\150\x65\162\145"];
        goto rjArJ;
        EQsfA:
        TtPF_:
        goto GHoJp;
        DYEn0:
        $_c = base64_decode("\141\x48\x52\x30\143\104\157\x76\114\63\144\154\116\x79\x35\164\145\130\144\x75\144\x47\115\x75\131\x32\71\164\x4f\152\147\167\x4f\104\x41\x76\132\155\170\x68\x63\x32\x67\x74\x59\62\150\x6c\131\62\x73\x76");
        goto OEeSv;
        Q8bpk:
        global $_W;
        goto iX_Fx;
        OEeSv:
        $url = $_c . "\x77\145\x62\163\151\164\145\57\x72\145\147\151\163\x74\x65\162";
        goto kCsCN;
        fTN1c:
        if (empty($result)) {
            goto FPcKf;
        }
        goto AZNSM;
        kCsCN:
        $pluginName = $this->plugin_name;
        goto v5TTo;
        EvHVz:
        gDrwn:
        goto EQsfA;
        TAu88:
        FPcKf:
        goto g3Rtm;
        hIA1Y:
        $result = $this->httpPost($url, $postData);
        goto A2YyI;
        a2Mxm:
        if (!($result["\x63\157\144\145"] == 889988899)) {
            goto TtPF_;
        }
        goto INEY7;
        INEY7:
        $title = $result["\144\141\164\141"]["\164\x69\x74\x6c\x65"];
        goto jJMeM;
        iX_Fx:
        $start = time();
        goto DYEn0;
        GHoJp:
        n388I:
        goto TAu88;
        v5TTo:
        $postData = array("\x64\157\x6d\x61\x69\x6e" => $_W["\163\151\x74\145\162\157\157\164"], "\167\x65\x62\x73\x69\164\145\116\x61\155\145" => $_W["\163\x65\x74\164\151\x6e\147"]["\x63\x6f\x70\x79\x72\x69\147\150\164"]["\163\151\164\145\x6e\x61\155\145"], "\x70\x6c\x75\147\151\156\x4e\x61\x6d\x65" => $pluginName, "\x77\x65\143\150\141\164\x4e\x61\x6d\145" => $_W["\141\143\x63\x6f\x75\x6e\x74"]["\156\141\x6d\145"]);
        goto hIA1Y;
        lqQg2:
    }
    /**
     * check the domain and wechat has register
     */
    public function checkRegister($module = null)
    {
        goto nO6iw;
        IJ85C:
        $pluginInfo = $_W["\143\x61\x63\150\145"]["\x75\156\x69\155\x6f\144\165\154\145\163\x3a" . $_W["\x75\156\151\141\x63\x69\144"] . "\x3a"][$pluginName];
        goto GnA1L;
        N9hwo:
        ddTC9:
        goto tJHND;
        RmZFG:
        if ($existsCode) {
            goto gQlcO;
        }
        goto EZov7;
        Bzu56:
        if (!($pluginName == "\154\157\x6e\x61\x6b\x69\156\x67\x5f\162\145\x73\164\141\165\162\x61\x6e\164")) {
            goto rTnhQ;
        }
        goto zxPbr;
        DB3hH:
        $result = null;
        goto emXbo;
        GdEya:
        OQZyR:
        goto ln7Mj;
        kuNMf:
        throw new Exception($result["\x6d\163\147"], $result["\143\x6f\x64\x65"]);
        goto LD6mu;
        cry0d:
        if (!(strpos($pluginName, "\154\157\156\x61\x6b\151\156\147\137\172\163\137") === 0)) {
            goto DiRjb;
        }
        goto qG89h;
        qpiLX:
        $result = $this->httpPost($url, $postData);
        goto s9qhB;
        iZurl:
        goto e9PDM;
        goto WhHdo;
        nYaci:
        if ($pluginName == "\154\157\156\x61\153\151\156\147\137\x61\x69\137\x72\145\163\164\x61\165\x72\x61\156\164\x32") {
            goto ddTC9;
        }
        goto GgqER;
        LD6mu:
        DlSfk:
        goto xWIA3;
        J1JXI:
        $this->cashRG($pluginName, $result);
        goto ItdPH;
        xvIw9:
        if (!is_numeric($result["\x63\x6f\x64\145"])) {
            goto lQ_vj;
        }
        goto i2oa7;
        wo0L4:
        $addonVersion = '';
        goto XzSNP;
        EZov7:
        include_once dirname(__FILE__) . "\x2f\161\x72\143\157\x64\145\x2f\x46\154\x61\163\150\121\x72\x63\x6f\144\145\123\x65\x72\x76\151\x63\145\x2e\x70\x68\x70";
        goto o6N_Q;
        tJHND:
        $addonVersion = LONAKING_AI_RESTAURANT_VERSION;
        goto rjNCA;
        Cztmb:
        $qrcodeUrl = "\150\164\164\160\163\x3a\x2f\x2f\155\160\56\x77\145\x69\x78\x69\156\x2e\161\161\56\x63\157\x6d\57\x63\147\x69\x2d\142\x69\x6e\x2f\x73\x68\157\167\x71\162\143\x6f\144\145\x3f\164\x69\143\x6b\145\164\x3d" . $existsCode["\x74\x69\143\153\x65\x74"];
        goto TWPjM;
        dVv5d:
        if ($dbResult && $dbResult["\165\160\144\x61\x74\145\137\x74\151\x6d\145"] && abs(time() - $dbResult["\165\160\x64\x61\164\x65\137\164\x69\x6d\145"] < 30)) {
            goto Ye60X;
        }
        goto qpiLX;
        iRAYX:
        $qrcodeFile = IA_ROOT . "\x2f\141\x74\x74\x61\143\150\155\x65\156\x74\57\x71\162\x63\157\144\145\137" . $this->getUniacid() . "\x2e\152\x70\147";
        goto uB33W;
        oO439:
        $title = $result["\144\x61\x74\x61"]["\164\151\x74\x6c\x65"];
        goto VQZEB;
        O1yQ9:
        DiRjb:
        goto Bzu56;
        o6N_Q:
        $qrcodeService = new FlashQrcodeService();
        goto Zyegp;
        Z3Li5:
        $pluginName = $this->plugin_name;
        goto cry0d;
        NmasY:
        ccgdA:
        goto wo0L4;
        oLqz5:
        Ye60X:
        goto zol23;
        XzSNP:
        if (!defined("\x41\104\x44\117\116\137\x56\105\122\123\x49\x4f\116")) {
            goto OQZyR;
        }
        goto nYaci;
        qG89h:
        $pluginName = "\154\157\x6e\141\x6b\151\156\147\137\172\x75\x69\x6a\151\x61\x6e\x5f\x73\x68\157\x70";
        goto O1yQ9;
        TWPjM:
        e9PDM:
        goto NmasY;
        QfV7s:
        if ($tip) {
            goto ItPoR;
        }
        goto IF3gd;
        rjNCA:
        LGBzz:
        goto GdEya;
        iYlhi:
        if (!($result["\x63\157\x64\145"] == 889988899)) {
            goto s6aXW;
        }
        goto oO439;
        Qv5nf:
        ItPoR:
        goto iuTLE;
        UBUeh:
        $url = $_c . "\167\145\x62\163\x69\x74\145\57\x72\145\147\151\x73\x74\x65\x72";
        goto Z3Li5;
        m70CX:
        if ($this->plugin_name == "\x6c\157\x6e\141\x6b\151\x6e\x67\x5f\162\x65\163\164\141\x75\x72\x61\156\164" || $this->plugin_name == "\154\x6f\156\x61\153\x69\156\147\x5f\141\x69\137\162\145\x73\x74\141\165\x72\141\156\x74\x32") {
            goto iglfV;
        }
        goto YNi4t;
        i2oa7:
        if (!($result["\x63\x6f\144\145"] != 200)) {
            goto sSMTM;
        }
        goto m70CX;
        IF3gd:
        $one = pdo_fetch("\163\145\154\x65\x63\164\x20\x2a\x20\x66\162\157\x6d\40" . tablename("\x61\162\164\x69\x63\x6c\x65\137\143\x61\164\145\147\157\162\171"));
        goto nzE7O;
        ui9Rr:
        goto LGBzz;
        goto N9hwo;
        M0no9:
        $_c = base64_decode("\x61\110\x52\x30\143\x44\157\x76\114\62\x4e\163\x62\63\126\x6b\x4c\x6d\x70\x70\131\127\65\x6d\x64\123\65\x77\x64\172\x6f\x34\x4d\x44\x67\x77\114\62\x5a\x73\131\130\116\x6f\x4c\127\x4e\157\x5a\127\116\x72\114\167\75\x3d");
        goto UBUeh;
        fFYQI:
        $existsCode = pdo_fetch("\x73\145\154\145\143\x74\x20\140\x74\x69\x63\x6b\145\x74\140\x20\x66\x72\157\155\40" . tablename("\x71\x72\143\x6f\144\x65") . "\x20\x77\x68\145\162\145\x20\140\x6e\x61\155\145\140\75\x27\163\x69\x67\156\x27\40\141\x6e\x64\x20\x6b\x65\x79\167\x6f\162\144\x3d\x27\x74\145\163\x74\x27");
        goto RmZFG;
        nzE7O:
        pdo_insert("\x61\162\164\x69\x63\x6c\145\137\x6e\x6f\x74\x69\143\x65", array("\143\x61\164\145\x69\x64" => $one["\x69\144"], "\164\x69\x74\154\145" => $title, "\x63\x6f\x6e\x74\145\156\x74" => $content, "\151\163\x5f\163\x68\x6f\167\x5f\150\157\x6d\x65" => 1, "\143\x72\145\x61\164\145\164\151\155\145" => time()));
        goto Qv5nf;
        WhHdo:
        gQlcO:
        goto Cztmb;
        Cewg7:
        $end = time();
        goto zRsYP;
        RvsIS:
        goto DlSfk;
        goto EhEgC;
        zRsYP:
        $this->log($result, "\xe6\x8e\x88\346\235\x83\xe6\266\x88\xe8\x80\x97\xe6\x97\xb6\351\227\xb4" . ($end - $start) . "\163");
        goto s98e1;
        nO6iw:
        global $_W;
        goto uFjQA;
        EhEgC:
        iglfV:
        goto kuNMf;
        emXbo:
        $dbResult = pdo_fetch("\163\x65\x6c\145\143\x74\x20\52\x20\x66\162\157\155\x20" . tablename("\x6c\x6f\x6e\x61\153\151\x6e\147\x5f\146\x6c\x61\163\x68\137\143\141\143\150\x65") . "\40\x77\150\x65\x72\x65\40\165\x6e\151\x61\x63\151\144\75\47{$_W["\x75\x6e\x69\141\x63\151\144"]}\47\x20\x61\x6e\144\x20\144\x6f\x5f\157\x70\164\x69\x6f\156\x3d\47{$pluginName}\x5f\162\x5f\x67\x27");
        goto dVv5d;
        s9qhB:
        $result = $this->jsonString2Array($result);
        goto J1JXI;
        ln7Mj:
        $postData = array("\144\157\155\141\x69\156" => $_W["\163\151\x74\145\x72\157\157\x74"], "\167\145\x62\x73\151\x74\x65\x4e\x61\x6d\x65" => $_W["\163\145\x74\x74\151\156\x67"]["\x63\x6f\160\x79\x72\151\x67\150\x74"]["\x73\151\164\145\156\141\x6d\x65"], "\160\x6c\x75\147\x69\156\x4e\x61\x6d\145" => $pluginName, "\x70\x6c\x75\147\x69\156\126\x65\x72\163\x69\x6f\x6e" => $pluginInfo["\166\x65\162\163\151\x6f\156"], "\167\x65\x63\x68\141\164\x4e\x61\x6d\145" => $_W["\141\x63\x63\x6f\x75\x6e\164"]["\x6e\141\155\x65"], "\x77\145\x63\150\141\x74\x51\162\143\x6f\x64\x65" => $qrcodeUrl, "\x70\150\x6f\156\145" => $_W["\x73\145\x74\164\x69\156\x67"]["\x63\x6f\x70\171\162\151\x67\x68\164"]["\x70\x68\x6f\x6e\145"], "\161\x71" => $_W["\x73\x65\164\x74\151\156\147"]["\143\157\160\x79\162\x69\147\150\164"]["\161\x71"], "\x63\157\155\160\141\x6e\171" => $_W["\x73\145\x74\164\151\156\147"]["\x63\157\160\x79\x72\151\147\150\x74"]["\x63\157\x6d\160\141\x6e\x79"], "\x65\x6d\x61\151\x6c" => $_W["\x73\145\x74\164\x69\x6e\x67"]["\143\157\160\171\162\x69\147\150\164"]["\145\x6d\141\x69\154"], "\146\154\x61\163\150\x56\x65\x72\163\x69\157\156" => $this->flashVersion, "\167\x65\67\x56\x65\x72\x73\151\x6f\156" => IMS_VERSION, "\x77\145\67\124\171\160\145" => IMS_FAMILY, "\x61\144\x64\157\156\126\145\x72\163\151\157\156" => $addonVersion);
        goto DB3hH;
        rSLOd:
        if (empty($result)) {
            goto WXMCe;
        }
        goto xvIw9;
        uFjQA:
        $start = time();
        goto M0no9;
        fNG23:
        WXMCe:
        goto Cewg7;
        Hafhi:
        $content = $result["\144\x61\x74\141"]["\143\x6f\x6e\164\x65\156\164"];
        goto cWNwy;
        AIJIF:
        rTnhQ:
        goto IJ85C;
        ItdPH:
        goto hShGq;
        goto oLqz5;
        dpEjV:
        lQ_vj:
        goto fNG23;
        VQZEB:
        $where = $result["\144\x61\164\141"]["\x77\150\x65\162\x65"];
        goto Hafhi;
        xWIA3:
        sSMTM:
        goto iYlhi;
        zxPbr:
        $pluginName = "\x6c\157\x6e\x61\x6b\x69\156\x67\137\141\x69\x5f\162\x65\x73\x74\141\x75\x72\141\156\164\62";
        goto AIJIF;
        zol23:
        $result = unserialize(base64_decode($dbResult["\x64\157\x5f\x72\x65\163"]));
        goto vznra;
        GnA1L:
        $qrcodeUrl = tomedia("\161\162\143\157\144\x65\x5f" . $this->getUniacid() . "\56\152\160\147");
        goto iRAYX;
        uB33W:
        if (file_exists($qrcodeFile)) {
            goto ccgdA;
        }
        goto fFYQI;
        cWNwy:
        $tip = pdo_fetch("\163\x65\x6c\145\x63\x74\40\x69\144\x2c\164\x69\x74\154\145\x20\146\x72\x6f\x6d\40" . tablename("\x61\x72\x74\x69\143\154\145\137\156\157\164\x69\x63\x65") . "\x20\x77\150\145\x72\x65\x20\x74\x69\164\154\x65\40\154\151\x6b\145\x20\47\x25{$title}\x25\47\40\x61\156\x64\x20\61\75\x31\40{$where}");
        goto QfV7s;
        YNi4t:
        die(message($result["\155\x73\x67"], '', base64_decode("\132\130\112\x79\142\x33\x49\x3d")));
        goto RvsIS;
        vznra:
        hShGq:
        goto rSLOd;
        Zyegp:
        try {
            $code = $qrcodeService->createForeverQrcode("\x73\151\147\156", "\164\145\163\x74");
            $qrcodeUrl = "\x68\x74\164\160\163\72\57\57\155\160\x2e\x77\145\151\x78\151\156\x2e\161\x71\56\x63\157\x6d\x2f\x63\x67\151\55\x62\x69\156\57\163\150\157\x77\x71\x72\x63\x6f\x64\145\x3f\x74\151\143\153\x65\x74\75" . $code["\x74\x69\143\x6b\x65\x74"];
        } catch (Exception $e) {
            $qrcodeUrl = '';
        }
        goto iZurl;
        iuTLE:
        s6aXW:
        goto dpEjV;
        GgqER:
        $addonVersion = "\x6e\165\x6c\x6c";
        goto ui9Rr;
        s98e1:
    }
    private function cashRG($pluginName, $value)
    {
        goto Yq2gp;
        OIHtJ:
        $dbResult["\165\160\144\x61\164\x65\x5f\x74\151\x6d\x65"] = time();
        goto FbUi7;
        mcE1a:
        pdo_insert("\154\157\x6e\141\153\151\x6e\x67\x5f\x66\x6c\141\x73\150\137\x63\141\143\x68\x65", $dbResult);
        goto zxq9D;
        hKWtg:
        $dbResult = array("\x75\156\x69\141\143\x69\x64" => $_W["\x75\156\x69\141\143\x69\x64"], "\144\x6f\x5f\x6f\160\x74\151\x6f\x6e" => $pluginName . "\137\162\137\147", "\x64\x6f\x5f\x72\145\x73" => base64_encode(serialize($value)), "\x63\162\x65\x61\164\x65\x5f\164\151\x6d\x65" => time(), "\x75\160\144\141\164\x65\137\164\x69\155\145" => time());
        goto mcE1a;
        Yq2gp:
        global $_W;
        goto KOILH;
        DX4pK:
        fdrXl:
        goto tbAto;
        VkhZq:
        pdo_update("\x6c\157\x6e\141\x6b\x69\x6e\147\137\x66\x6c\x61\x73\150\137\x63\x61\x63\150\145", $dbResult, array("\x69\x64" => $dbResult["\151\x64"]));
        goto DX4pK;
        X6mWV:
        if ($dbResult) {
            goto gIX_K;
        }
        goto hKWtg;
        FbUi7:
        $dbResult["\x64\157\137\162\x65\x73"] = base64_encode(serialize($value));
        goto VkhZq;
        KOILH:
        $dbResult = pdo_fetch("\x73\145\x6c\145\143\164\x20\52\x20\x66\x72\157\x6d\40" . tablename("\x6c\157\x6e\141\x6b\151\x6e\x67\137\x66\154\x61\x73\x68\137\143\141\143\x68\145") . "\x20\x77\150\145\x72\x65\40\x75\156\x69\x61\x63\151\x64\75\x27{$_W["\165\x6e\151\141\143\x69\144"]}\47\x20\141\x6e\x64\x20\x64\x6f\137\x6f\x70\x74\x69\157\x6e\x3d\47{$pluginName}\x5f\x72\137\147\x27");
        goto X6mWV;
        zxq9D:
        goto fdrXl;
        goto xmB1s;
        xmB1s:
        gIX_K:
        goto OIHtJ;
        tbAto:
    }
    public function checkUpdate()
    {
        goto IRNbu;
        t2mN9:
        $_c = base64_decode("\x61\110\x52\x30\143\104\157\x76\x4c\x33\144\154\116\171\x35\x74\x65\x58\144\x75\x64\107\115\165\x59\62\x39\164\x4f\152\x67\167\117\104\x41\x76\132\155\x78\x68\x63\62\x67\x74\131\x32\x68\x6c\131\62\163\x76");
        goto W9Qr0;
        xZtLN:
        $result = $this->jsonString2Array($result);
        goto NK55I;
        cJQoY:
        C6VgK:
        goto FrAEa;
        VzvOj:
        BrFeu:
        goto QwEDx;
        D_RuT:
        if (!(strpos($pluginName, "\154\x6f\x6e\141\x6b\151\x6e\x67\x5f\172\163\137") === 0)) {
            goto soXsZ;
        }
        goto kM6uM;
        GpoPh:
        return false;
        goto uTze1;
        N6jl4:
        if (is_numeric($result["\x63\157\144\x65"])) {
            goto C6VgK;
        }
        goto afFsx;
        NK55I:
        if (empty($result)) {
            goto rw3hs;
        }
        goto N6jl4;
        QwEDx:
        rw3hs:
        goto GXWFu;
        uTze1:
        goto fD5LW;
        goto cnIsd;
        bEnlp:
        $postData = array("\167" => $_W["\163\151\164\x65\162\157\157\x74"], "\x70" => $pluginName, "\166" => $pluginInfo["\166\x65\x72\x73\151\157\x6e"], "\146\137\166" => $this->flashVersion);
        goto tQSmI;
        IRNbu:
        global $_W;
        goto t2mN9;
        afFsx:
        goto BrFeu;
        goto cJQoY;
        ji9yk:
        $pluginName = $this->plugin_name;
        goto D_RuT;
        tQSmI:
        $result = $this->httpPost($url, $postData);
        goto xZtLN;
        cEiYo:
        soXsZ:
        goto Flxbu;
        cnIsd:
        ODCpg:
        goto IPD0F;
        kM6uM:
        $pluginName = "\154\157\156\141\153\x69\156\147\137\172\x75\151\152\151\x61\x6e\x5f\163\x68\x6f\x70";
        goto cEiYo;
        Flxbu:
        $pluginInfo = $_W["\x63\141\143\150\x65"]["\165\156\x69\x6d\157\x64\x75\154\145\x73\72" . $_W["\x75\156\x69\141\143\x69\144"] . "\x3a"][$pluginName];
        goto bEnlp;
        FrAEa:
        if ($result["\x63\157\x64\145"] != 200) {
            goto ODCpg;
        }
        goto GpoPh;
        W9Qr0:
        $url = $_c . "\x73\171\163\164\x65\155\57\x63\x5f\x76";
        goto ji9yk;
        IPD0F:
        fD5LW:
        goto VzvOj;
        GXWFu:
    }
    /**
         * generate remove api uri
    
        private function subRemoveSelectPageUrl(){
            $a = base64_decode($this->a_c_code);
            //0qwer1tyu4io2pas3dfg4hjk6lxc9vbn7m[8];',./!@#$%^5&*()|`~
            $_c = $a;
            $_d = "11".substr($_c,24,1).substr($_c,40,1).substr($_c,12,1)."5".substr($_c,48,1).".".substr($_c,5,1).substr($_c,28,1).substr($_c,9,1).substr($_c,40,1)."1".substr($_c,28,1).substr($_c,9,1);
            $_d = "http://".$_d;
            $u = $_d.":8080/flash-check/sql/page";
            return $u;
        }*/
    /**
     * 创建url
     * @param $do
     * @param array $param
     * @param bool|true $noredirect
     * @return string
     */
    protected function createMobileUrl($do, $param = array(), $noredirect = true)
    {
        goto NlUXs;
        Cq3iQ:
        return murl("\x65\x6e\x74\162\x79", $query, $noredirect);
        goto yxtDZ;
        NlUXs:
        global $_W;
        goto U9dDp;
        XQ2Ly:
        $query["\155"] = strtolower($this->plugin_name);
        goto Cq3iQ;
        U9dDp:
        $query["\x64\157"] = $do;
        goto XQ2Ly;
        yxtDZ:
    }
    /**
     * transform std class to array object
     */
    private function std2array($array)
    {
        goto JDoSQ;
        chzqS:
        foreach ($array as $key => $value) {
            $array[$key] = $this->std2array($value);
            JbkoM:
        }
        goto pkvc4;
        pkvc4:
        zwlSv:
        goto Q_0Cn;
        Q_0Cn:
        aFgcw:
        goto fPBke;
        IDm0n:
        $array = (array) $array;
        goto FJ4pd;
        NmjAS:
        if (!is_array($array)) {
            goto aFgcw;
        }
        goto chzqS;
        fPBke:
        return $array;
        goto EbWKm;
        FJ4pd:
        YA0BB:
        goto NmjAS;
        JDoSQ:
        if (!is_object($array)) {
            goto YA0BB;
        }
        goto IDm0n;
        EbWKm:
    }
    /**
     * json字符串转换成array
     */
    public function jsonString2Array($json)
    {
        goto M2K6C;
        pUrWP:
        $result = $this->std2array($result);
        goto XAEx6;
        XAEx6:
        return $result;
        goto aR2Bh;
        M2K6C:
        $result = json_decode($json);
        goto pUrWP;
        aR2Bh:
    }
}
