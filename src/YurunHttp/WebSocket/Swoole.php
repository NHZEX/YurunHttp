<?php
namespace Yurun\Util\YurunHttp\WebSocket;

use Yurun\Util\YurunHttp\Exception\WebSocketException;

class Swoole implements IWebSocketClient
{
    /**
     * Http Request
     *
     * @var \Yurun\Util\YurunHttp\Http\Request
     */
    private $request;

    /**
     * Http Response
     *
     * @var \Yurun\Util\YurunHttp\Http\Response
     */
    private $response;

    /**
     * Handler
     *
     * @var \Swoole\Coroutine\Http\Client
     */
    private $handler;

    /**
     * Http Handler
     *
     * @var \Yurun\Util\YurunHttp\Handler\IHandler
     */
    private $httpHandler;

    /**
     * 连接状态
     *
     * @var boolean
     */
    private $connected = false;

    /**
     * 初始化
     *
     * @param \Yurun\Util\YurunHttp\Handler\IHandler $httpHandler
     * @param \Yurun\Util\YurunHttp\Http\Request $request
     * @param \Yurun\Util\YurunHttp\Http\Response $response
     * @return void
     */
    public function init($httpHandler, $request, $response)
    {
        $this->httpHandler = $httpHandler;
        $this->request = $request;
        $this->response = $response;
        $this->handler = $this->httpHandler->getHandler();
        $this->connected = true;
    }

    /**
     * 获取 Http Handler
     *
     * @return  \Yurun\Util\YurunHttp\Handler\IHandler
     */ 
    public function getHttpHandler()
    {
        return $this->httpHandler;
    }

    /**
     * 获取 Http Request
     *
     * @return \Yurun\Util\YurunHttp\Http\Request
     */
    public function getHttpRequest()
    {
        return $this->request;
    }

    /**
     * 获取 Http Response
     *
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function getHttpResponse()
    {
        return $this->response;
    }

    /**
     * 连接
     *
     * @return bool
     */
    public function connect()
    {
        $this->httpHandler->websocket($this->request, $this);
        return $this->isConnected();
    }

    /**
     * 关闭连接
     *
     * @return void
     */
    public function close()
    {
        $this->handler->close();
        $this->connected = true;
    }

    /**
     * 发送数据
     *
     * @param mixed $data
     * @return bool
     */
    public function send($data)
    {
        $result = $this->handler->push($data);
        if(!$result)
        {
            throw new WebSocketException(sprintf('Send Failed, errorCode: %s', $this->handler->errCode), $this->handler->errCode);
        }
        return $result;
    }

    /**
     * 接收数据
     *
     * @return mixed
     */
    public function recv()
    {
        $result = $this->handler->recv();
        if(!$result)
        {
            throw new WebSocketException(sprintf('Recv Failed, errorCode: %s', $this->handler->errCode), $this->handler->errCode);
        }
        return $result->data;
    }

    /**
     * 是否已连接
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->connected;
    }

}