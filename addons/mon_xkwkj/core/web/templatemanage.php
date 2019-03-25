<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/9/27
 * Time: 15:19
 */



$templates = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_TEMPLATE) . "   ORDER BY createtime asc ");


include $this->template("templates");


