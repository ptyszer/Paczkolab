<?php

use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../class/Address.php';
require_once __DIR__ . '/../class/database/DBmysql.php';

class AddressTest extends TestCase
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

    public function testLoadAddress()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Address::setDb($db);
        $address = Address::load(1);
        $this->assertInstanceOf('Address', $address);
    }

    public function testLoadAllAddress()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Address::setDb($db);
        $addressArray = Address::loadAll();
        $this->assertCount(3, $addressArray);
    }

    public function testSaveAddress()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Address::setDb($db);
        $address = new Address(null, 'Sopot', '50-000', 'Borowska', '5');
        $savedAddress = $address->save();
        $this->assertInstanceOf('Address', $savedAddress);
        $this->assertEquals('Sopot', $savedAddress->getCity());
    }

    public function testUpdateAddress() //todo test fail
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Address::setDb($db);
        $address = Address::load(1);
        $address->setCity('Gdańsk');
        $address->setCode('00-000');
        $address->setStreet('Wrocławska');
        $address->setFlat('28');
        $updatedAddress = $address->update();
        $this->assertInstanceOf('Address', $updatedAddress);
        $this->assertEquals('Gdańsk', $updatedAddress->getCity());
    }

    public function testDeleteAddress()  //todo test fail
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Address::setDb($db);
        $address = Address::load(1);
        $this->assertTrue($address->delete());
    }
}