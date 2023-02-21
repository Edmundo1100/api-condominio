<?php

function autoload($className) {
  $className = str_replace('\\', '/', $className);
  $file = './src/' . $className . '.php';

  if (file_exists($file)) {
    require $file;
  }
}

spl_autoload_register('autoload');

