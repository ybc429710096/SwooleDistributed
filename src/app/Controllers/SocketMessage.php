<?php

namespace app\Controllers;

use app\Models\AppModel;
use Server\CoreBase\Controller;

/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午3:51
 */
class SocketMessage extends Controller
{
    /**
     * @var AppModel
     */
    public $AppModel;

    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
        $this->AppModel = $this->loader->model('AppModel', $this);
    }

    public function sub($sub)
    {
        $this->bindUid($this->fd);
        $this->addSub($sub);
        $this->send("ok.$this->fd");
    }

    public function pub($sub, $data)
    {
        $this->sendPub($sub, $data);
    }

    public function sendAll($data)
    {
        $this->sendToAll($data);
    }

    public function onClose()
    {
        var_dump('socketclose,fd'.$this->fd);
        $this->destroy();
    }

    public function onMessage(){
        echo "收到消息";
        $result = $this->sendToAll(['type' => '消息','hehe' => '33']);
        var_dump("发送消息",$result);
        $this->destroy();
    }

    public function onConnect()
    {
        var_dump('socketconnect,fd'.$this->fd);
        $uid = time();
        $this->bindUid($uid);
        $this->send(['type' => 'welcome', 'id' => $uid]);
        $this->destroy();
    }

    public function http_test()
    {
        $this->http_output->end("哈哈");
    }
}