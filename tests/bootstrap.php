<?php

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_NO_ACCELERATOR_RESET', true);
define('BX_CRONTAB', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_STATISTIC', 'Y');
define('DisableEventsCheck', true);
define('NO_AGENT_CHECK', true);

if (empty($_SERVER['DOCUMENT_ROOT'])) {
    $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../public/');
}
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
// require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

@session_destroy();

require_once realpath(__DIR__ . '/../vendor/autoload.php');
