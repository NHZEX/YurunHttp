<?php
namespace Yurun\Util\YurunHttp\Test\HttpRequestTest;

use Yurun\Util\HttpRequest;
use Yurun\Util\YurunHttp\Test\BaseTest;

class HttpRequestTest extends BaseTest
{
    /**
     * Hello World
     *
     * @return void
     */
    public function testHelloWorld()
    {
        $this->call(function(){
            $http = new HttpRequest;
            $response = $http->get($this->host);
            $this->assertEquals($response->body(), 'YurunHttp');
        });
    }

    /**
     * JSON
     *
     * @return void
     */
    public function testJson()
    {
        $this->call(function(){
            $http = new HttpRequest;
            $response = $http->get($this->host . '?a=info');
            $data = $response->json(true);
            $this->assertArrayHasKey('get', $data);
        });
    }

    /**
     * $_GET
     *
     * @return void
     */
    public function testGetParams()
    {
        $this->call(function(){
            $http = new HttpRequest;
            $time = time();
            $response = $http->get($this->host . '?a=info&time=' . $time);
            $data = $response->json(true);
            $this->assertEquals(isset($data['get']['time']) ? $data['get']['time'] : null, $time);
        });
    }

    /**
     * $_POST
     *
     * @return void
     */
    public function testPostParams()
    {
        $this->call(function(){
            $http = new HttpRequest;
            $time = time();
            $response = $http->post($this->host . '?a=info', [
                'time'  =>  $time,
            ]);
            $data = $response->json(true);
            $this->assertEquals(isset($data['post']['time']) ? $data['post']['time'] : null, $time);
        });
    }

    /**
     * $_COOKIE
     *
     * @return void
     */
    public function testCookieParams()
    {
        $this->call(function(){
            $http = new HttpRequest;
            $time = time();
            $hash = uniqid();
            $response = $http->cookie('hash', $hash)
                                ->cookies([
                                    'time'  =>  $time,
                                ])
                                ->get($this->host . '?a=info');
            $data = $response->json(true);
            $this->assertEquals(isset($data['cookie']['time']) ? $data['cookie']['time'] : null, $time);
            $this->assertEquals(isset($data['cookie']['hash']) ? $data['cookie']['hash'] : null, $hash);
        });
    }

    /**
     * Request Header
     *
     * @return void
     */
    public function testRequestHeaders()
    {
        $this->call(function(){
            $http = new HttpRequest;
            $time = (string)time();
            $hash = uniqid();
            $response = $http->header('hash', $hash)
                                ->headers([
                                    'time'  =>  $time,
                                ])
                                ->get($this->host . '?a=info');
            $data = $response->json(true);
            $this->assertEquals(isset($data['server']['HTTP_TIME']) ? $data['server']['HTTP_TIME'] : null, $time);
            $this->assertEquals(isset($data['server']['HTTP_HASH']) ? $data['server']['HTTP_HASH'] : null, $hash);
        });
    }

    /**
     * Response Header
     *
     * @return void
     */
    public function testResponseHeaders()
    {
        $this->call(function(){
            $http = new HttpRequest;
            $response = $http->get($this->host . '?a=info');
            $this->assertEquals($response->getHeaderLine('Yurun-Http'), 'one suo');
        });
    }

}