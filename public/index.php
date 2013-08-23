<?php
require __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

// データベース接続情報の読込
$env = getenv('APP_ENV') ?: 'development';
$config = require __DIR__ . "/../config/$env.php";
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $config['db'],
));

// トップ画面
$app->get('/', function(Silex\Application $app) {
    $posts = $app['db']->fetchAll('
        SELECT name, message, unix_timestamp(created) as created
        FROM posts ORDER BY created DESC LIMIT 5
    ');
    return $app['twig']->render('index.twig', array(
        'posts' => $posts,
    ));
});

// 投稿処理
$app->post('/speak', function(Silex\Application $app) {
    $name = $app['request']->get('name');
    $message = $app['request']->get('message');
    if ($name && $message) {
        $app['db']->insert('posts', array('name' => $name, 'message' => $message));
    }
    return $app->redirect('/');
});

$app->run();
