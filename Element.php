<?php

namespace htmlOOP;

class Element
{
	/**
	 * @var string name
	 */
	protected $name;

	/**
	 * @var Element parent
	 */
	protected $parent;

	/**
	 * @var string[] attributes
	 */
	protected $attributes;

	/**
	 * @var ElementCollection children
	 */
	protected $children;

	/**
	 * Element constructor.
	 *
	 * @param string[] $attributes
	 */
	public function __construct(array $attributes = [])
	{

		foreach ($attributes as $attribute => $value)
		{
			$this->setAttribute($attribute, $value);
		}

		$this->children = new ElementCollection();
	}

	/**
	 * @param string $value
	 */
	public function setName(string $value)
	{
		$this->name = $value;
	}

	public function append(Element $element)
	{
		$this->children->add_element($element);
		$element->setParent($this);
	}

	public function setAttribute(string $attribute, $value)
	{
		$this->attributes[$attribute] = (string) $value;
	}

	/**
	 * @param Element $parent
	 */
	protected function setParent(Element $parent)
	{
		$this->parent = $parent;
	}

}
