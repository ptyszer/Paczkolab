<?php

include_once __DIR__.'/interface/Action.php';

class Size implements Action
{
    private $id;
    private $size;
    private $price;
    /**
     * @var Database
     */
    public static $db;
    public function __construct($id = null, $size, $price) {
        $this->id = $id;
        $this->size = $size;
        $this->price = $price;
    }
    public function getId(){
        return $this->id;
    }
    public function getSize(){
        return $this->size;
    }
    public function setSize($size){
        $this->size = $size;
        return $this;
    }
    public function getPrice(){
        return $this->price;
    }
    public function setPrice($price){
        $this->price = $price;
        return $this;
    }
    public function save()
    {
        self::$db->query("INSERT INTO Size SET size=:size, price=:price");
        self::$db->bind(':size', $this->getSize(), PDO::PARAM_STR);
        self::$db->bind(':price', $this->getPrice(), PDO::PARAM_STR);

        self::$db->execute();

        if (self::$db->rowCount() >= 1) {
            return new Size(self::$db->lastInsertId(), $this->getSize(), $this->getPrice());
        }

        return null;
    }
    public function update()
    {
        self::$db->query("UPDATE Size SET size=:size, price=:price WHERE id=:id");
        self::$db->bind(':id', $this->getId(), PDO::PARAM_INT);
        self::$db->bind(':size', $this->getSize(), PDO::PARAM_STR);
        self::$db->bind(':price', $this->getPrice(), PDO::PARAM_STR);

        self::$db->execute();

        if (self::$db->rowCount() >= 1) {
            return $this;
        }

        return null;
    }
    public function delete()
    {
        self::$db->query("DELETE FROM Size WHERE id=:id");
        self::$db->bind(':id', $this->getId(), PDO::PARAM_INT);

        self::$db->execute();

        if (self::$db->rowCount() >= 1) {
            return true;
        }

        return false;
    }
    public static function load($id = null)
    {
        self::$db->query("SELECT * FROM Size WHERE id=:id");
        self::$db->bind(':id', $id, PDO::PARAM_INT);
        $row = self::$db->single();

        if (self::$db->rowCount() >= 1) {
            return new Size($row['id'], $row['size'], $row['price']);
        }
        return null;
    }
    public static function loadAll()
    {
        self::$db->query("SELECT * FROM Size");
        return self::$db->resultSet();
    }
    public static function setDb(Database $db)
    {
        self::$db = $db;
    }
}