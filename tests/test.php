<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 06.09.18
 * Time: 10:07
 */

include "autoload.php";

use htmlOOP\Element\Element;
use htmlOOP\Html\HtmlElement\HtmlElement;

// do some tests

//$test_element = new Element(
$test_element = new HtmlElement(
	[
	    'id' => 'top_header',
		'class' =>'head',
        'tag' => 'div',
	],
	new HtmlElement(['name' => 'p', 'class' => 'inner_1_1']),
	new HtmlElement(
	    ['name' => 'div', 'class' => 'inner_1_2'],
        new HtmlElement(['name' => 'blockquote', 'class' => 'inner_1_2_1']),
        new HtmlElement(['name' => 'blockquote', 'class' => 'inner_1_2_2']),
        new HtmlElement(['name' => 'blockquote', 'class' => 'inner_1_2_3'])
    )
);

$test_element_2 = new HtmlElement();

var_dump($test_element->getAllData());
