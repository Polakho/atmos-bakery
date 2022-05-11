<?php

namespace App\Classes;

class Schedule
{

    private $id;
    private $day;
    private  $op_am;
    private $cl_am;
    private  $op_pm;
    private $cl_pm;
    private $trash;
    private $store_id;

    public function __construct(){

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day): void
    {
        $this->day = $day;
    }

    /**
     * @return mixed
     */
    public function getOpAm()
    {
        return $this->op_am;
    }

    /**
     * @param mixed $op_am
     */
    public function setOpAm($op_am): void
    {
        $this->op_am = $op_am;
    }

    /**
     * @return mixed
     */
    public function getClAm()
    {
        return $this->cl_am;
    }

    /**
     * @param mixed $cl_am
     */
    public function setClAm($cl_am): void
    {
        $this->cl_am = $cl_am;
    }

    /**
     * @return mixed
     */
    public function getOpPm()
    {
        return $this->op_pm;
    }

    /**
     * @param mixed $op_pm
     */
    public function setOpPm($op_pm): void
    {
        $this->op_pm = $op_pm;
    }

    /**
     * @return mixed
     */
    public function getClPm()
    {
        return $this->cl_pm;
    }

    /**
     * @param mixed $cl_pm
     */
    public function setClPm($cl_pm): void
    {
        $this->cl_pm = $cl_pm;
    }

    /**
     * @return mixed
     */
    public function getTrash()
    {
        return $this->trash;
    }

    /**
     * @param mixed $trash
     */
    public function setTrash($trash): void
    {
        $this->trash = $trash;
    }

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->store_id;
    }

    /**
     * @param mixed $store_id
     */
    public function setStoreId($store_id): void
    {
        $this->store_id = $store_id;
    }
}