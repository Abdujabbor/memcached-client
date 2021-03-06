<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/24/18
 * Time: 4:04 PM
 */

class SocketTest extends \PHPUnit\Framework\TestCase
{
    protected $validAddress = "127.0.0.1";
    protected $validPort = 11211;


    public function testServerAddressException()
    {
        $this->expectException("\InvalidArgumentException");
        $invalidAddress = "dnsjakdnsjka";
        $socket = new abdujabbor\memcached\tcp\Socket($invalidAddress, $this->validPort);
    }

    public function testUnavailableSocket()
    {
        $this->expectException("\abdujabbor\\memcached\\exceptions\CommandException");
        $invalidAddress = "123.123.123.123";
        $socket = new abdujabbor\memcached\tcp\Socket($invalidAddress, $this->validPort);
    }

    public function testServerPortException()
    {
        $this->expectException("\InvalidArgumentException");
        $invalidPort = -123;
        $socket = new abdujabbor\memcached\tcp\Socket($this->validAddress, $invalidPort);
    }

    public function testResource()
    {
        try {
            $socket = new abdujabbor\memcached\tcp\Socket($this->validAddress, $this->validPort);
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            die();
        }
        $this->assertEquals(true, is_resource($socket->getResource()));
    }


    public function testConnectAndClose()
    {
        try {
            $socket = new abdujabbor\memcached\tcp\Socket($this->validAddress, $this->validPort);
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            die();
        }
        $this->assertEquals(true, is_resource($socket->getResource()));
        $socket->close();
        $this->assertEquals(false, is_resource($socket->getResource()));
    }
}
