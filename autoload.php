<?php

function autoload($className)
{
  $className = str_replace('\\', DS, $className);
  $file = DIR_APP . '/src/' . $className . '.php';
  $file = str_replace('\\', DS, $file);
  if (file_exists($file)) {
    include $file;
  }
}

spl_autoload_register('autoload');
