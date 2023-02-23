<?php

function autoload($className) {
  $className = str_replace('\\', '/', $className);
  $file = __DIR__ .'/src/' . $className . '.php';
  $file = str_replace('\\', '/', $file );
  if (file_exists($file)) {
    include $file;
  }
}

spl_autoload_register('autoload');

