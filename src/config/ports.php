<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-14
 * Time: 下午1:58
 */

use Server\CoreBase\PortManager;

/**
 *   -----------HTTP------------
 *   request
 *   handshake
 *   ------------WS-------------
 *   open
 *   message
 *   close
 *   handshake
 *   ---------TCP/UDP--------
 *   connect
 *   receive
 *   close
 *   packet
 *
 *   还有些特殊的配置
 *
 *       method_prefix 设置该端口访问的方法名前缀
 *       event_controller_name 设置该端口conect,close触发的控制器名称，不填默认是Appserver设置的
 *       close_method_name 设置该端口close触发的方法，不填默认是Appserver设置的
 *       connect_method_name 设置该端口conect触发的方法，不填默认是Appserver设置的
 */

$config['ports'][] = [
    'socket_type' => PortManager::SOCK_TCP,
    'socket_name' => '0.0.0.0',
    'socket_port' => 9091,
    'pack_tool' => 'LenJsonPack',
    'route_tool' => 'NormalRoute',
    'middlewares' => ['MonitorMiddleware']
];

$config['ports'][] = [
    'socket_type' => PortManager::SOCK_TCP,
    'socket_name' => '0.0.0.0',
    'socket_port' => 1883,
    'pack_tool' => 'MqttPack',
    'route_tool' => 'NormalRoute',
    'middlewares' => ['MonitorMiddleware']
];

$config['ports'][] = [
    'socket_type' => PortManager::SOCK_HTTP,
    'socket_name' => '0.0.0.0',
    'socket_port' => 8081,
    'route_tool' => 'NormalRoute',
    'middlewares' => ['MonitorMiddleware', 'NormalHttpMiddleware'],
    'method_prefix' => 'http_'
];

$config['ports'][] = [
    'socket_type' => PortManager::SOCK_WS,
    'socket_name' => '0.0.0.0',
    'socket_port' => 8083,
    'route_tool' => 'SocketRoute',
    'pack_tool' => 'NonJsonPack',
    'opcode' => PortManager::WEBSOCKET_OPCODE_TEXT,
    'middlewares' => ['MonitorMiddleware'],
    'event_controller_name' => 'SocketMessage'
];

return $config;