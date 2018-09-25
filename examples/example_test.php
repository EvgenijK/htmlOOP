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
try
{
	$test_element = new HtmlElement(
		[
			'id'    => 'top_header',
			'class' => 'head',
			'tag'   => 'div',
			'disabled',
		],
		new HtmlElement(['tag' => 'p', 'id' => 'inner_1_1']),
		new HtmlElement(['tag' => 'div', 'id' => 'inner_1_2'],
			new HtmlElement(['tag' => 'div','class' => 'blockquote', 'id' => 'inner_1_2_1']),
			new HtmlElement(['tag' => 'div','class' => 'blockquote', 'id' => 'inner_1_2_2']),
			new HtmlElement(['tag' => 'div','class' => 'blockquote', 'id' => 'inner_1_2_3'])
		)
	);

	$test_element_2 = new HtmlElement(
		['tag' => 'div','id' => 'old_root'],
		new HtmlElement(['tag' => 'div','id' => 'old_el_1']),
		new HtmlElement(['tag' => 'div','id' => 'old_el_2']),
		new HtmlElement(['tag' => 'div','id' => 'old_el_3'])
	);

	$test_element[0]->addChildren($test_element_2);
//	var_dump($test_element_2[1]->getRoot()->getIndexKeys());
//	var_dump($test_element_2[1]->getIndex()['inner_1_2_2']->getId());
//	var_dump($test_element->getById('old_el_3')->getParent()->getId());
//
	$test_element->htmlRender();

	$fired_tree = $test_element_2->unsetElement(false);
	$test_element->htmlRender();

	echo 'fired:: count = ' . count($fired_tree) . PHP_EOL;
	foreach($fired_tree as $item)
	{
		echo '__' . PHP_EOL;
		echo $item->getId() . PHP_EOL;
		echo $item->getParent()->getId() . PHP_EOL;
		echo $item->getRoot()->getId() . PHP_EOL;
		var_dump($item->getIndexKeys());
		echo PHP_EOL;
	}

} catch (Exception $e)
{
	throw $e;
}
