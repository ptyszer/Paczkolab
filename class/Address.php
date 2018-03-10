<?php

class Address implements Action
{

    private $id;
    private $city;
    private $postal;
    private $streetname;
    private $streetnum;

    public function __construct($city, $postal, $streetname, $streetnum)
    {
        $this->city = $city;
        $this->postal = $postal;
        $this->streetname = $streetname;
        $this->streetnum = $streetnum;
    }

    // Getters & Setters

    public function getId()
    {
        return $this->id;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getPostal()
    {
        return $this->postal;
    }

    public function setPostal($postal)
    {
        $this->postal = $postal;
    }

    public function getStreetname()
    {
        return $this->streetname;
    }

    public function setStreetname($streetname)
    {
        $this->streetname = $streetname;
    }

    public function getStreetnum()
    {
        return $this->streetnum;
    }

    public function setStreetnum($streetnum)
    {
        $this->streetnum = $streetnum;
    }

    // Methods

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public static function load($id = null)
    {
        // TODO: Implement load() method.
    }

    public static function loadAll()
    {
        // TODO: Implement loadAll() method.
    }

    public static function setDb(Database $db)
    {
        // TODO: Implement setDb() method.
    }

}