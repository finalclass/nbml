<?php
require_once 'common.php';
$model = new \Blog\TopicModel();

$model->save($_POST['title'], $_POST['body'], $_POST['id']);

header('Location: /');
