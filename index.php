<?php

use Mpemba\Entity\Router;

require __DIR__ . '/config/bootstrap.php';
session_start();

Router::load();
