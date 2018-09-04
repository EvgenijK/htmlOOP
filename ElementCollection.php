<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 04.09.18
 * Time: 15:01
 */

namespace htmlOOP;


class ElementCollection
{

	/**
	 * @var array elements
	 */
	private $elements;

	public function get_elements()
	{
		return $this->elements;
	}

	public function add_element(Element $element)
	{
		$this->elements[] = $element;
	}

	public function merge_collection(ElementCollection $collection)
	{
		array_merge($this->elements, $collection->get_elements());
	}

	public function each($callback)
	{
		if (!is_callable($callback))
		{
			// todo throw exception: Must provide a valid callback
		}

		foreach ($this->get_elements() as $element)
		{
			call_user_func_array($callback, [$element]);
		}
	}

}