<?php

require_once 'common.php';
$viewAutoLoader = include '../../library/Nbml/sandbox_runtime.php';

echo Blog::create()->formState(true);