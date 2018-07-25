<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 7/24/18
 * Time: 4:46 PM
 */

class ClientTest extends \PHPUnit\Framework\TestCase
{
    protected $validAddress = "127.0.0.1";
    protected $validPort = 11211;
    /**
     * @var $client \memcached\Client
     */
    protected $client;
    public function setUp()
    {
        $this->client = new \memcached\Client($this->validAddress, $this->validPort);
        try {
            $this->client->connect();
        } catch (Exception $exception) {
            echo $exception->getMessage() . "\n";
            die();
        }

        parent::setUp();
    }

    public function testSetStore()
    {
        $key = "sampleString";
        $content = "sampleStringContent";
        $this->client->set($key, $content, 1000);

        $this->assertEquals($content, $this->client->get($key));
    }


    public function testDelete()
    {
        $key = "index";
        $content = new stdClass();
        $this->client->set($key, $content, 1000);

        $this->assertEquals($content, $this->client->get($key));

        $this->client->delete($key);

        $this->assertEmpty($this->client->get($key));
    }

    public function testTimeout()
    {
        $key = "values";
        $content = [1,2,3];
        $this->client->set($key, $content, 2);

        $this->assertEquals($content, $this->client->get($key));

        sleep(3);

        $this->assertEmpty($this->client->get($key));
    }

    public function testFlush()
    {
        $key1 = "values1";
        $content1 = [1,2,3];
        $this->client->set($key1, $content1, 10);
        $key2 = "values2";
        $content2 = [1,2,3,4,5];
        $this->client->set($key2, $content2, 10);
        $this->assertEquals($content1, $this->client->get($key1));
        $this->assertEquals($content2, $this->client->get($key2));
        $this->client->flush();
        $this->assertEmpty($this->client->get($key1));
        $this->assertEmpty($this->client->get($key2));
    }
}
