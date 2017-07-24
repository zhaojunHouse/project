<?php
//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501);


$serv->set([
    'reactor_num' => 2,
    'worker_num' => 4,
    'task_worker_num' => 2,
    'log_file' => 'swoole.log',
    'log_level' => 5,
    'open_eof_check' => true,//当包的结尾是制定字符串时才 投向worker进程
    'package_eof' => "\n",
    //'heartbeat_check_interval' => 12,  //10min心跳
    'daemonize' => false
]);

//监听连接进入事件
$serv->on('connect', function ($serv, $fd) {
    echo "Client $fd: Connect.\n";
    foreach($serv->connections as $f)
    {
        $serv->send($f, "hello");
    }
    $nums = $serv->connections;
    file_put_contents("swoole.log", time()."  connections num is ".json_encode($nums)." \n", FILE_APPEND);
    echo "当前服务器共有 ".count($serv->connections). " 个连接\n";
});

//task事件
$serv->on('task',function($serv, $task_id, $src_worker_id,$data){
    echo "from work $src_worker_id and task_id is $task_id and data is $data";
});

//finish 事件
$serv->on('finish',function($serv, $task_id, $data){
    echo "task_id is $task_id and data is $data";
});

$serv->on('WorkerStart',function($serv,$worker_id){
    if($worker_id >= $serv->setting['worker_num']) {
        file_put_contents("swoole.log", time()." task work start $worker_id\n", FILE_APPEND);
    }else{
        file_put_contents("swoole.log", time()." work start $worker_id\n", FILE_APPEND);
    }

});

//和workStart同时,没有先后顺序
$serv->on('start',function($serv){
    $masterPid = $serv->master_pid;
    $managerPid = $serv->manager_pid;
    file_put_contents("swoole.log", time()."  start master_pid is $masterPid manager_id is $managerPid\n", FILE_APPEND);
});

$serv->on('ManagerStart',function($serv){
    $managerId = $serv->manager_pid;
    file_put_contents("swoole.log", time()." manager worker start pid is $managerId \n", FILE_APPEND);
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    file_put_contents("swoole.log", time()." reactor_id is  $from_id Server send fd $fd :".json_encode($data)."\n", FILE_APPEND);
    echo "Server send $fd : $data";
    $serv->send($fd, "Server: ".$data);
});

$serv->on('ShutDown',function($serv){
    file_put_contents("swoole.log", time()." shutdown\n", FILE_APPEND);
});


//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client $fd: Close.\n";
});

//启动服务器
$serv->start();