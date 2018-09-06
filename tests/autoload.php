<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 06.09.18
 * Time: 11:20
 */

spl_autoload_register(function ($class_name)
{
	$actual_name = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, str_replace('htmlOOP\\', '', $class_name));
	include "../$actual_name.php";
});
