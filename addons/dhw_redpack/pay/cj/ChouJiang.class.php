<?php

/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/4/25
 * Time: 23:42
 */
class ChouJiang{

    private $chouJiangId;
    private $chouJiangNum;
    private $chouJiangName;
    private $name;
    private $tel;
    private $addr;
    private $country;
    private $province;
    private $city;
    private $headImg;
    private $isReceive;
    private $isRedPack;
    private $redPackAmount;
    private $openid;
    private $ip;

    private $convertObj;

//    function insertCj(){
//        pdo_insert(tablename('chou_jiang'),$this->getConvertObj(),false);
//    }

    function convertObj(){

    }

    /**
     * @param mixed $addr
     */
    public function setAddr($addr)
    {
        $this->addr = $addr;
    }

    /**
     * @return mixed
     */
    public function getAddr()
    {
        return $this->addr;
    }

    /**
     * @param mixed $chouJiangId
     */
    public function setChouJiangId($chouJiangId)
    {
        $this->chouJiangId = $chouJiangId;
    }

    /**
     * @return mixed
     */
    public function getChouJiangId()
    {
        return $this->chouJiangId;
    }

    /**
     * @param mixed $chouJiangName
     */
    public function setChouJiangName($chouJiangName)
    {
        $this->chouJiangName = $chouJiangName;
    }

    /**
     * @return mixed
     */
    public function getChouJiangName()
    {
        return $this->chouJiangName;
    }

    /**
     * @param mixed $chouJiangNum
     */
    public function setChouJiangNum($chouJiangNum)
    {
        $this->chouJiangNum = $chouJiangNum;
    }

    /**
     * @return mixed
     */
    public function getChouJiangNum()
    {
        return $this->chouJiangNum;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $convertObj
     */
    public function setConvertObj($convertObj)
    {
        $this->convertObj = $convertObj;
    }

    /**
     * @return mixed
     */
    public function getConvertObj()
    {
        return $this->convertObj;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $headImg
     */
    public function setHeadImg($headImg)
    {
        $this->headImg = $headImg;
    }

    /**
     * @return mixed
     */
    public function getHeadImg()
    {
        return $this->headImg;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $isReceive
     */
    public function setIsReceive($isReceive)
    {
        $this->isReceive = $isReceive;
    }

    /**
     * @return mixed
     */
    public function getIsReceive()
    {
        return $this->isReceive;
    }

    /**
     * @param mixed $isRedPack
     */
    public function setIsRedPack($isRedPack)
    {
        $this->isRedPack = $isRedPack;
    }

    /**
     * @return mixed
     */
    public function getIsRedPack()
    {
        return $this->isRedPack;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $redPackAmount
     */
    public function setRedPackAmount($redPackAmount)
    {
        $this->redPackAmount = $redPackAmount;
    }

    /**
     * @return mixed
     */
    public function getRedPackAmount()
    {
        return $this->redPackAmount;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $openid
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
    }

    /**
     * @return mixed
     */
    public function getOpenid()
    {
        return $this->openid;
    }









    
    
}