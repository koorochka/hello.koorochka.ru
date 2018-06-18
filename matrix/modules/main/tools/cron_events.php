#!/usr/local/bin/php
<?php
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../../../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("BX_CRONTAB", true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CACHED_b_event', false);

require($_SERVER["DOCUMENT_ROOT"]."/matrix/modules/main/include/prolog_before.php");



@set_time_limit(0);
@ignore_user_abort(true);

CEvent::CheckEvents();


?>
