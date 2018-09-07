<?php

namespace htmlOOP\Element;

use htmlOOP\ElementCollection\ElementCollection;

class Element implements \ArrayAccess
{
	/**
	 * @var string $name
	 */
	protected $name;

	/**
	 * @var Element $parent
	 */
	protected $parent;

	/**
	 * @var string[] $attributes
	 */
	protected $attributes;

	/**
	 * @var string[] $specialAttributes
	 */
	protected $specialAttributes = [
		'name'
    ];

	/**
	 * @var ElementCollection $children
	 */
	protected $children;

	/**
	 * Element constructor.
	 *
	 * @param string[] $attributes
	 * @param Element[] $children
	 */
	public function __construct(array $attributes = [], Element ...$children)
	{

		foreach ($attributes as $attribute => $value)
		{
			$this->setAttribute($attribute, $value);
		}

		$this->children = new ElementCollection();

		$this->addChildren(...$children);
	}

	/**
	 * @param string $value
	 */
	public function setName(string $value)
	{
		$this->name = $value;
	}

	/**
	 * @param Element $element
	 */
	public function append(Element $element)
	{
		$this->children[] = $element;
		$element->setParent($this);
	}

	/**
	 * @param Element $element
	 * @param int $offset
	 */
	public function setChild(int $offset, Element $element)
	{
		$this->children[$offset] = $element;
		$element->setParent($this);
	}

	/**
	 * @param string $attribute
	 * @param $value - Will be converted to a string by (string)
	 */
	public function setAttribute(string $attribute, $value)
	{
	    if (!$this->setSpecialAttribute($attribute, $value))
        {
            $this->attributes[$attribute] = (string) $value;
        }
	}

    /**
     * @param string $attribute
     * @param $value
     * @return bool
     */
    private function setSpecialAttribute(string $attribute, $value)
	{
		if (in_array($attribute, $this->specialAttributes))
		{
			$this->$attribute = $value;
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * @param Element $parent
	 */
	protected function setParent(Element $parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @param Element ...$elements
	 */
	public function addChildren(Element ...$elements)
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

	/**
	 * Whether a offset exists
	 * @link https://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
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
	 * @link https://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 * @since 5.0.0
	 */
	public function offsetGet($offset)
	{
		return isset($this->children[$offset]) ? $this->children[$offset] : null;
	}

	/**
	 * Offset to set
	 * @link https://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetSet($offset, $value)
	{
		if (is_null($offset)) {
			$this->append($value);
		} else {
			$this->setChild($offset, $value);
		}
	}

	/**
	 * Offset to unset
	 * @link https://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetUnset($offset)
	{
		$this->unsetChild($offset);
	}
}
