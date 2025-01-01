<?php

$directory =  __DIR__;

chdir($directory);

$command = 'git pull origin master';

$output = shell_exec($command);

echo "Output: " . $output;
