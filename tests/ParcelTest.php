<?php

use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../class/Parcel.php';
require_once __DIR__ . '/../class/database/DBmysql.php';

class UserTest extends TestCase
{
    use TestCaseTrait;

    protected function getConnection()
    {
        $pdo = new PDO($GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWORD'],
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        return $this->createDefaultDBConnection($pdo, $GLOBALS['DB_NAME']);
    }

    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/fixtures.xml');
    }

    public function testLoadParcel()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Parcel::setDb($db);
        $parcel = Parcel::load(1);
        $this->assertInstanceOf('Parcel', $parcel);
    }

    public function testLoadAllParcel()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Parcel::setDb($db);
        $parcelArray = Parcel::loadAll();
        $this->assertCount(2, $parcelArray);
    }

    public function testSaveParcel()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Parcel::setDb($db);
        $parcel = new Parcel(null, '3', '1', '2');
        $savedParcel = $parcel->save();
        $this->assertInstanceOf('Parcel', $savedParcel);
        $this->assertEquals('3', $savedParcel->getSender());
    }

    public function testUpdateParcel()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Parcel::setDb($db);
        $parcel = Parcel::load(1);
        $parcel->setSender('2');
        $parcel->setSize('2');
        $parcel->setAddress('1');
        $updatedParcel = $parcel->update();
        $this->assertInstanceOf('Parcel', $updatedParcel);
        $this->assertEquals('2', $updatedParcel->getSender());
    }

    public function testDeleteParcel()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Parcel::setDb($db);
        $parcel = Parcel::load(1);
        $this->assertTrue($parcel->delete());
    }
}