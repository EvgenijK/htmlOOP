<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 06.09.18
 * Time: 10:07
 */

include "autoload.php";

use htmlOOP\Html\HtmlElement\HtmlElement;

// do some tests

$test_element = new HtmlElement(
	[
		'id' => 'top_header',
		'class' =>'head',
		'tag' => 'div',
		'disabled',
	],
	new HtmlElement(['tag' => 'p', 'id' => 'inner_1_1']),
	new HtmlElement(['tag' => 'div', 'id' => 'inner_1_2'],
		new HtmlElement(['class' => 'blockquote', 'id' => 'inner_1_2_1']),
		new HtmlElement(['class' => 'blockquote', 'id' => 'inner_1_2_2']),
		new HtmlElement(['class' => 'blockquote', 'id' => 'inner_1_2_3'])
	)
);

$test_element_2 = new HtmlElement(['id' => 'old_root'],
	new HtmlElement(['id' => 'old_el_1']),
	new HtmlElement(['id' => 'old_el_2']),
	new HtmlElement(['id' => 'old_el_3'])
);

$test_element[1][2]->addChildren($test_element_2);
var_dump($test_element_2[0]->getRoot()->getId());

