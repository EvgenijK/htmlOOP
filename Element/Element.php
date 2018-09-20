<?php

namespace htmlOOP\Element;

use htmlOOP\ElementCollection\ElementCollection;

use htmlOOP\Element\Traits\TraitRootElement;
use htmlOOP\Element\Traits\TraitElementIndex;

class Element implements \ArrayAccess
{
	use TraitRootElement;
	use TraitElementIndex;

    const SPECIAL_DATA_ID  = 'id';

	/**
	 * @var Element $parent
	 */
	protected $parent;

	/**
	 * @var array $data
	 */
	protected $data;

    /**
     * @var string[] $specialData
     */
    protected $specialData = [];

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

		$this->addChildren(...$children);
	}

	// Data

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
        if (!$this->setSpecialData($index, $value))
        {
            if (is_int($index) && !empty((string) $value))
            {
//                $this->setAttribute($value, '');
            } else {
//                $this->setAttribute($index, $value);
            }
        }

		$this->data[$index] = $value;
	}

    /**
     * @param        $index
     * @param string $value
     *
     * @return bool
     */
    protected function setSpecialData($index, string $value)
    {
        if (in_array($index, $this->specialData, TRUE))
        {
            $setMethodName = 'set' . ucfirst($index);
            $this->$setMethodName($value);

            return TRUE;
        }

        return FALSE;
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
	 * @return array
	 */
	public function getAllData()
	{
		return $this->data;
	}

	// Parent

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

	// Index

	protected function compareIndex(ElementCollection $additional_index)
	{
		if (!array_intersect_key($this->getIndex()->getElements(), $additional_index->getElements()))
		{
			return FALSE;
		}

		return TRUE;
	}

	// Children

	/**
	 * @param Element $element
	 *
	 * @throws \Exception
	 */
	public function append(Element $element)
	{
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

		$this->children[] = $element;
		$element->setParent($this);
		$element->updateTree($this->getRoot(), $this->getIndex());
	}

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

		$this->addToIndex($this, $newIndex);
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
