<?php

include_once __DIR__.'/interface/Action.php';

class Address implements Action
{

    private $id;
    private $city;
    private $code;
    private $street;
    private $flat;

    /**
     * @var Database
     */
    public static $db;

    public function __construct($id=null, $city, $code, $street, $flat)
    {
        $this->id = $id;
        $this->city = $city;
        $this->code = $code;
        $this->street = $street;
        $this->flat = $flat;
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

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getFlat()
    {
        return $this->flat;
    }

    public function setFlat($flat)
    {
        $this->flat = $flat;
    }

    // Methods

    public function save()
    {
        self::$db->query("INSERT INTO Address SET city=:city, code=:code, street=:street, flat=:flat");
        self::$db->bind(':city', $this->getCity(), PDO::PARAM_STR);
        self::$db->bind(':code', $this->getCode(), PDO::PARAM_STR);
        self::$db->bind(':street', $this->getStreet(), PDO::PARAM_STR);
        self::$db->bind(':flat', $this->getFlat(), PDO::PARAM_INT);
        self::$db->execute();
        if (self::$db->rowCount() >= 1) {
            return new Address(self::$db->lastInsertId(), $this->getCity(), $this->getCode(), $this->getStreet(), $this->getFlat());
        }

        return null;
    }

    public function update()
    {
        self::$db->query("UPDATE Address SET city=:city, code=:code, street=:street, flat=:flat WHERE id=:id");
        self::$db->bind(':id', $this->getId(), PDO::PARAM_INT);
        self::$db->bind(':city', $this->getCity(), PDO::PARAM_STR);
        self::$db->bind(':code', $this->getCode(), PDO::PARAM_STR);
        self::$db->bind(':street', $this->getStreet(), PDO::PARAM_STR);
        self::$db->bind(':flat', $this->getFlat(), PDO::PARAM_INT);
        self::$db->execute();

        if (self::$db->rowCount() >= 1) {
            return $this;
        }

        return null;
    }

    public function delete()
    {
        self::$db->query("DELETE FROM Address WHERE id=:id");
        self::$db->bind(':id', $this->getId(), PDO::PARAM_INT);
        self::$db->execute();

        if (self::$db->rowCount() >= 1) {
            return true;
        }

        return false;
    }

    public static function load($id = null)
    {
        self::$db->query("SELECT * FROM Address WHERE id=:id");
        self::$db->bind(':id', $id, PDO::PARAM_INT);
        $row = self::$db->single();

        if (self::$db->rowCount() >= 1) {
            return new Address($row['id'], $row['city'], $row['code'], $row['street'], $row['flat']);
        }
        return null;
    }

    public static function loadAll()
    {
        self::$db->query("SELECT * FROM Address");
        return self::$db->resultSet();
    }

    public static function setDb(Database $db)
    {
        self::$db = $db;
    }

}