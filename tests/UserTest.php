<?php

use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../class/User.php';
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

    public function testLoadUser()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        User::setDb($db);
        $user = User::load(1);
        $this->assertInstanceOf('User', $user);
    }

    public function testLoadAllUser()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        User::setDb($db);
        $userArray = User::loadAll();
        $this->assertCount(3, $userArray);
    }

    public function testSaveUser()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        User::setDb($db);
        $user = new User(null, 'Ferdek', 'Kiepski', '2', '1');
        $savedUser = $user->save();
        $this->assertInstanceOf('User', $savedUser);
        $this->assertEquals('Ferdek', $savedUser->getName());
    }

    public function testUpdateUser()
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        User::setDb($db);
        $user = User::load(1);
        $user->setName('Zygmunt');
        $user->setSurname('Stalowy');
        $user->setCredits('3000');
        $user->setAddressId('3');
        $updatedUser = $user->update();
        $this->assertInstanceOf('User', $updatedUser);
        $this->assertEquals('Zygmunt', $updatedUser->getName());
    }

    public function testDeleteUser() //todo test error
    {
        $db = new DBmysql($this->getConnection()->getConnection());
        User::setDb($db);
        $user = User::load(1);
        $this->assertTrue($user->delete());
    }
}