<?php
/**
 * Socket路由
 * User: ybc
 * Date: 17-11-30
 * Time: 下午3:11
 */

namespace app\Route;

use Server\Route\IRoute;
use Server\CoreBase\SwooleException;

class SocketRoute implements IRoute
{
    private $client_data;

    public function __construct()
    {
        $this->client_data = new \stdClass();
    }

    /**
     * 设置反序列化后的数据 Object
     * @param $data
     * @return \stdClass
     */
    public function handleClientData($data)
    {
        $this->client_data = $data;
        return $this->client_data;
    }

    /**
     * 处理http request
     * @param $request
     */
    public function handleClientRequest($request)
    {
        $this->client_data->path = $request->server['path_info'];
        $route = explode('/', $request->server['path_info']);
        $this->client_data->controller_name = $route[1]??null;
        $this->client_data->method_name = $route[2]??null;
    }

    /**
     * 获取控制器名称
     * @return string
     */
    public function getControllerName()
    {
        return 'SocketMessage';
    }

    /**
     * 获取方法名称
     * @return string
     */
    public function getMethodName()
    {
        return $this->client_data->method_name;
    }

    public function getPath()
    {
        return $this->client_data->path??null;
    }

    public function getParams()
    {
        return $this->client_data->params??null;
    }

    public function errorHandle(\Exception $e, $fd)
    {
        //get_instance()->close($fd);
    }

    public function errorHttpHandle(\Exception $e, $request, $response)
    {
        // TODO: Implement errorHttpHandle() method.
    }
}
