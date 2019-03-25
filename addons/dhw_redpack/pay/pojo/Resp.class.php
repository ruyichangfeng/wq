<?php

/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/4/27
 * Time: 19:31
 */
class Resp{
    private $name;
    private $desc;
    private $isRedPack;
    private $redPkAmount;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return mixed
     */
    public function getIsRedPack()
    {
        return $this->isRedPack;
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
    public function getRedPkAmount()
    {
        return $this->redPkAmount;
    }

    /**
     * @param mixed $redPkAmount
     */
    public function setRedPkAmount($redPkAmount)
    {
        $this->redPkAmount = $redPkAmount;
    }


}