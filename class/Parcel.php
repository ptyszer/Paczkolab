<?php

include_once __DIR__.'/interface/Action.php';

class Parcel implements Action
{
    private $id;
    private $sender;
    private $size;
    private $address;

    /**
     * @var Database
     */
    public static $db;

    public function __construct($id = null, $sender, $size, $address)
    {
        $this->id = $id;
        $this->sender = $sender;
        $this->size = $size;
        $this->address = $address;
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
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }


    public function save()
    {
        self::$db->query("INSERT INTO Parcel SET user_id=:user_id, size_id=:size_id, address_id=:address_id");
        self::$db->bind(':user_id', $this->getSender(), PDO::PARAM_INT);
        self::$db->bind(':size_id', $this->getSize(), PDO::PARAM_INT);
        self::$db->bind(':address_id', $this->getAddress(), PDO::PARAM_INT);
        self::$db->execute();

        if (self::$db->rowCount() >= 1) {
            return new Parcel(self::$db->lastInsertId(), $this->getSender(), $this->getSize(), $this->getAddress());
        }

        return null;
    }

    public function update()
    {
        self::$db->query("UPDATE Parcel SET user_id=:user_id, size_id=:size_id, address_id=:address_id WHERE id=:id");
        self::$db->bind(':id', $this->getId(), PDO::PARAM_INT);
        self::$db->bind(':user_id', $this->getSender(), PDO::PARAM_INT);
        self::$db->bind(':size_id', $this->getSize(), PDO::PARAM_INT);
        self::$db->bind(':address_id', $this->getAddress(), PDO::PARAM_INT);
        self::$db->execute();

        if (self::$db->rowCount() >= 1) {
            return $this;
        }

        return null;
    }

    public function delete()
    {
        self::$db->query("DELETE FROM Parcel WHERE id=:id");
        self::$db->bind(':id', $this->getId(), PDO::PARAM_INT);
        self::$db->execute();

        if (self::$db->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public static function load($id = null)
    {
        self::$db->query("SELECT * FROM Parcel WHERE id=:id");
        self::$db->bind(':id', $id, PDO::PARAM_INT);
        $row = self::$db->single();

        if (self::$db->rowCount() >= 1) {
            return new Parcel($row['id'], $row['user_id'], $row['size_id'], $row['address_id']);
        }
        return null;
    }

    public static function loadAll()
    {
        self::$db->query("SELECT * FROM Parcel");
        return self::$db->resultSet();
    }

    public static function setDb(Database $db)
    {
        self::$db = $db;
    }
}