<?php

namespace htmlOOP\Element;

use htmlOOP\ElementCollection\ElementCollection;

use htmlOOP\Element\Traits\TraitRootElement;
use htmlOOP\Element\Traits\TraitElementIndex;
use htmlOOP\Element\Traits\TraitParentElement;
use htmlOOP\Element\Traits\TraitElementData;

class Element implements \ArrayAccess
{
	use TraitRootElement;
	use TraitElementIndex;
	use TraitParentElement;
	use TraitElementData;

	const SPECIAL_DATA_ID = 'id';

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
		$this->specialData[] = Element::SPECIAL_DATA_ID;

		$this->root = $this;
		$this->index = new ElementCollection($this);

		foreach ($data as $index => $item)
		{
			$this->setData($index, $item);
		}

		$this->children = new ElementCollection($this);

		$this->appendChildren(...$children);
	}

	// Children

	/**
	 * @param Element           $root
	 * @param ElementCollection $newIndex
	 *
	 * @throws \Exception
	 */
	protected function updateTree(Element $root, ElementCollection $newIndex)
	{

		foreach ($this->children as $child)
		{
			$child->updateTree($root, $newIndex);
		}

		$this->root = $root;

		$this->setIndex($newIndex);
		$root->addIndex($this);
	}

	/**
	 * @param $elements
	 *
	 * @throws \Exception
	 */
	public function appendChildren(...$elements)
	{
		foreach ($elements as $element)
		{
			$this[] = $element;
		}
	}

	/**
	 * @param Element $element
	 * @param         $offset
	 *
	 * @return bool|Element
	 * @throws \Exception
	 */
	public function setChild($offset, Element $element)
	{
		if (!is_int($offset) && !is_null($offset))
		{
			// TODO: create specific class exception for this
			throw new \Exception('Offset must be int type');
		} elseif ($offset > count($this->data))
		{
			// TODO: create specific class exception for this
			throw new \Exception('Offset must be lower then count of elements in collection + 1');
		}

		if ($element->getRoot() !== $element)
		{
			// TODO: create specific class exception for this
			throw new \Exception('Appending element that isn\'t the root of it\'s tree');
		}

		if ($this->compareIndex($element->getIndex()))
		{
			// TODO: create specific class exception for this
			throw new \Exception('Appending element tree that has elements with same id as elements from parent tree');
		}

		if (isset($this->children[$offset]))
		{
			$previous_child = $this->children[$offset];
		}

		$element->setParent($this);
		$element->updateTree($this->getRoot(), $this->getIndex());

		if ($offset)
		{
			$this->children[$offset] = $element;
		} else
		{
			$this->children[] = $element;
		}

		if (isset($previous_child))
		{
			return $previous_child;
		}

		return TRUE;
	}

	public function getChildren()
	{
		return $this->children;
	}

	// Unset

	/**
	 * @param bool $unset_tree
	 *
	 * @return Element[]|bool
	 * @throws \Exception
	 */
	public function unsetElement(bool $unset_tree = FALSE)
	{
		// remove from parent
		if ($this->parent !== $this)
		{
			for ($i = 0; $i < count($this->parent->getChildren()); ++$i)
			{
				if ($this->parent[$i] === $this)
				{
					unset($this->parent[$i]);
				}
			}
		}

		// remove from index
		if ($this->getId())
		{
			unset($this->index[$this->getId()]);
		}

		// remove parent
		unset($this->parent);

		// remove root
		unset($this->root);

		if (!$unset_tree)
		{
			$children = $this->getChildren()->getElements();
		}

		// unset/update children
		foreach ($this->children as $child)
		{
			if ($unset_tree)
			{
				$child->unsetElement(TRUE);
			} else
			{
				$child->updateTree($child, new ElementCollection($child));
			}
		}

		$this->children = NULL;

		if (!$unset_tree)
		{
			return $children;
		}

		return TRUE;
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
		$this->setChild($offset, $value);
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
		unset($this->children[$offset]);
	}
}
