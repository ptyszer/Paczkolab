<?php

use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../class/Size.php';
require_once __DIR__ . '/../class/database/DBmysql.php';

class SizeTest extends TestCase
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

    public function testSaveSize()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Size::setDb($db);
        $size = new Size(null, 'XXL', 15);
        $this->assertInstanceOf('Size', $size->save());
    }

    public function testUpdateSize()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Size::setDb($db);
        $size = Size::load(1);
        $size->setSize('XXXL');
        $size->setPrice(100);
        $this->assertInstanceOf('Size', $size->update());
    }

    public function testDeleteSize()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Size::setDb($db);
        $size = Size::load(1);
        $this->assertTrue($size->delete());
    }

    public function testLoadSize()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Size::setDb($db);
        $size = Size::load(1);
        $this->assertInstanceOf('Size', $size);
    }

    public function testLoadAllSize()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        Size::setDb($db);
        $sizeArray = Size::loadAll();
        $this->assertCount(2, $sizeArray);
    }

}