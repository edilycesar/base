<?php
require_once './vendor/autoload.php';

ini_set("display_errors", "on");

$router = new Hoa\Router\Http();

$router
    ->get('u', '/hello', function () {
        echo 'world!', "\n";
    })
    ->post('v', '/hello', function (Array $_request) {
        echo $_request['a'] + $_request['b'], "\n";
    })
    ->get('w', '/bye', function () {
        echo 'ohh :-(', "\n";
    })
    ->get('x', '/hello_(?<nick>\w+)', function ($nick) {
        echo 'Welcome ', ucfirst($nick), '!', "\n";
    });
    
   
//print_r($request);    


//$dispatcher = new Hoa\Dispatcher\Basic();
//$dispatcher->dispatch($router);
    
// View.
$superview   = new SuperView('Out.phtml', $output, $router);