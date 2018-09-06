<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 06.09.18
 * Time: 10:07
 */

include "autoload.php";

use htmlOOP\Element\Element;

// do some tests

$test_element = new Element(
	[
		'class' => 'head'
	],
	new Element(['class' => 'inner_!']),
	new Element(['class' => 'inner_2'], new Element(['class' => 'inner_3']))
);

var_dump($test_element);
