<?php

namespace htmlOOP\Element;

use htmlOOP\ElementCollection\ElementCollection;
use htmlOOP\Element\Traits\TraitRootElement;

class Element implements \ArrayAccess
{
	use TraitRootElement;

	/**
	 * @var Element $parent
	 */
	protected $parent;

	/**
	 * @var array $data
	 */
	protected $data;

	/**
	 * @var ElementCollection $children
	 */
	protected $children;

	/**
	 * Element constructor.
	 *
	 * @param array   $data
	 * @param Element ...$children
	 *
	 * @throws \Exception
	 */
	public function __construct(array $data = [], Element ...$children)
	{
		$this->root = $this;

		foreach ($data as $index => $item)
		{
			$this->setData($index, $item);
		}

		$this->children = new ElementCollection($this);

		$this->addChildren(...$children);
	}

	/**
	 * @param string $value
	 */
	public function addData(string $value)
	{
		$this->data[] = $value;
	}

	/**
	 * @param        $index
	 * @param string $value
	 */
	public function setData($index, string $value)
	{
		$this->data[$index] = $value;
	}

	/**
	 * @return array
	 */
	public function getAllData()
	{
		return $this->data;
	}

	/**
	 * @param array $new_data
	 */
	public function setAllData(array $new_data)
	{
		$this->data = $new_data;
	}

	/**
	 * @param $index
	 *
	 * @return mixed
	 */
	public function getData($index)
	{
		return $this->data[$index];
	}

	/**
	 * @param Element $element
	 *
	 * @throws \Exception
	 */
	public function append(Element $element)
	{
		if ($element->getRoot() === $element)
		{
			$this->children[] = $element;
			$element->setParent($this);
			$element->updateTree($this->getRoot());
		} else {
			throw new \Exception('Appending element that isn\'t the root of it\'s tree');
		}
	}

	/**
	 * TODO Rework this method to work with id and root update
	 *
	 * @param Element $element
	 * @param int     $offset
	 */
	public function setChild(int $offset, Element $element)
	{
		$this->children[$offset] = $element;
		$element->setParent($this);
	}

	/**
	 * @param Element $parent
	 */
	protected function setParent(Element $parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @return Element
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * @param Element $root
	 *
	 * @throws \Exception
	 */
	protected function updateTree(Element $root)
	{

		foreach ($this->children as $child)
		{
			$child->updateTree($root);
		}

		$this->root = $root;
	}

	/**
	 * @param $elements
	 *
	 * @throws \Exception
	 */
	public function addChildren(...$elements)
	{
		foreach ($elements as $element)
		{
			$this->append($element);
		}
	}

	/**
	 * @param int $offset
	 */
	public function unsetChild(int $offset)
	{
		unset($this->children[$offset]);
	}

	// Interface implementation

	/**
	 * Whether a offset exists
	 * @link  https://php.net/manual/en/arrayaccess.offsetexists.php
	 *
	 * @param mixed $offset <p>
	 *                      An offset to check for.
	 *                      </p>
	 *
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 * @since 5.0.0
	 */
	public function offsetExists($offset)
	{
		return isset($this->children[$offset]);
	}

	/**
	 * Offset to retrieve
	 * @link  https://php.net/manual/en/arrayaccess.offsetget.php
	 *
	 * @param mixed $offset <p>
	 *                      The offset to retrieve.
	 *                      </p>
	 *
	 * @return Element Can return all value types.
	 * @since 5.0.0
	 */
	public function offsetGet($offset)
	{
		return isset($this->children[$offset]) ? $this->children[$offset] : NULL;
	}

	/**
	 * Offset to set
	 * @link  https://php.net/manual/en/arrayaccess.offsetset.php
	 *
	 * @param mixed $offset <p>
	 *                      The offset to assign the value to.
	 *                      </p>
	 * @param mixed $value  <p>
	 *                      The value to set.
	 *                      </p>
	 *
	 * @return void
	 * @since 5.0.0
	 * @throws \Exception
	 */
	public function offsetSet($offset, $value)
	{
		if (is_null($offset))
		{
			$this->append($value);
		} else
		{
			$this->setChild($offset, $value);
		}
	}

	/**
	 * Offset to unset
	 * @link  https://php.net/manual/en/arrayaccess.offsetunset.php
	 *
	 * @param mixed $offset <p>
	 *                      The offset to unset.
	 *                      </p>
	 *
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetUnset($offset)
	{
		$this->unsetChild($offset);
	}
}
