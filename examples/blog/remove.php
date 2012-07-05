<?php

require_once 'common.php';
$model = new \Blog\TopicModel();
$model->remove($_GET['id']);
header('Location: /');