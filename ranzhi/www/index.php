<?php
/* Get the config file. */
$configFile = dirname(dirname(__FILE__)) . '/config/config.php';
include $configFile;

/* Locate to diffrent entry according installed or not. */
empty($config->installed) ?  header('location: sys/install.php') : header('location: sys/index.php');
