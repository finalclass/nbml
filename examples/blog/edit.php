<?php

require 'common.php';
$viewAutoLoader = include '../../library/Nbml/sandbox_runtime.php';

echo Blog::create()->formState(true);