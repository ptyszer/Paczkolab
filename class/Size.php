<?php
class Size implements Action
{
    private $id;
    private $size;
    private $price;
    /**
     * @var Database
     */
    public static $db;
    public function __construct($size, $price) {
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
        self::$db->query("SELECT * FROM Size");
        return self::$db->resultSet();
    }
    public static function setDb(Database $db)
    {
        self::$db = $db;
    }
}