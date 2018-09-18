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
	    'name' => 'div',
		'class' =>'head',
	],
	new Element(['name' => 'p', 'class' => 'inner_1_1']),
	new Element(
	    ['name' => 'div', 'class' => 'inner_1_2'],
        new Element(['name' => 'blockquote', 'class' => 'inner_1_2_1']),
        new Element(['name' => 'blockquote', 'class' => 'inner_1_2_2']),
        new Element(['name' => 'blockquote', 'class' => 'inner_1_2_3'])
    )
);

$test_element_2 = new Element();

var_dump($test_element->getAllData());
