<?php

class User implements Action
{
    private $id;
    private $name;
    private $surname;
    private $credits;
    private $address_id;

    /**
     * @var Database
     */
    public static $db;

    public function __construct($id = null, $name, $surname, $credits, $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->credits = $credits;
        $this->address_id = $address;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

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
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * @param mixed $credits
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;
    }

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->address_id;
    }

    /**
     * @param mixed $address_id
     */
    public function setAddressId($address_id)
    {
        $this->address_id = $address_id;
    }


    public function save()
    {
        self::$db->query("INSERT INTO User SET name=:name, surname=:surname, credits=:credits, address_id=:address_id");
        self::$db->bind(':name', $this->getName(), PDO::PARAM_STR);
        self::$db->bind(':surname', $this->getSurname(), PDO::PARAM_STR);
        self::$db->bind(':credits', $this->getCredits(), PDO::PARAM_STR);
        self::$db->bind(':address_id', $this->getAddressId(), PDO::PARAM_INT);
        self::$db->execute();
        return $this;
    }

    public function update()
    {
        self::$db->query("UPDATE User SET name=:name, surname=:surname, credits=:credits, address_id=:address_id WHERE id=:id");
        self::$db->bind(':id', $this->getId(), PDO::PARAM_INT);
        self::$db->bind(':name', $this->getName(), PDO::PARAM_STR);
        self::$db->bind(':surname', $this->getSurname(), PDO::PARAM_STR);
        self::$db->bind(':credits', $this->getCredits(), PDO::PARAM_STR);
        self::$db->bind(':address_id', $this->getAddressId(), PDO::PARAM_INT);
        self::$db->execute();
        return $this;
    }

    public function delete()
    {
        self::$db->query("DELETE FROM User WHERE id=:id");
        self::$db->bind(':id', $this->getId(), PDO::PARAM_INT);
        self::$db->execute();
        return $this;
    }

    public static function load($id = null)
    {
        self::$db->query("SELECT * FROM User WHERE id=:id");
        self::$db->bind(':id', $id, PDO::PARAM_INT);
        $row = self::$db->single();
        return new User($row['id'], $row['name'], $row['surname'], $row['credits'], $row['address_id']);
    }

    public static function loadAll()
    {
        self::$db->query("SELECT * FROM User");
        return self::$db->resultSet();
    }

    public static function setDb(Database $db)
    {
        self::$db = $db;
    }
}