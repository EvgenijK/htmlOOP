<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 20.09.18
 * Time: 18:49
 */

namespace htmlOOP\Element\Traits;

use htmlOOP\Element\Element;
use htmlOOP\ElementCollection\ElementCollection;

trait TraitElementIndex
{
	/**
	 * Root element of the structure
	 *
	 * @var ElementCollection $root
	 */
	protected $index;

	/**
	 * @var string $id
	 */
	protected $id;

	protected function setIndex(ElementCollection $newIndex)
	{
		$this->index = $newIndex;
	}

	/**
	 * @return ElementCollection
	 */
	public function getIndex()
	{
		return $this->index;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	public function getIndexKeys()
	{
		return array_keys($this->getIndex()->getElements());
	}

	public function getById(string $id)
	{
		return $this->index[$id];
	}

	/**
	 * @param string            $id
	 * @param ElementCollection $index
	 *
	 * @return bool
	 */
	protected function checkIdInIndex(string $id, ElementCollection $index)
	{
		return in_array($id, array_keys($index->getElements()));
	}

	public function checkId(string $id)
	{
		return $this->checkIdInIndex($id, $this->getIndex());
	}

	/**
	 * @param Element           $element
	 * @param ElementCollection $index
	 *
	 * @throws \Exception
	 */
	protected function addElementToIndex(Element $element, ElementCollection $index)
	{
		if ($element->getId())
		{
			if ($this->checkIdInIndex($element->getId(), $index))
			{
				throw new \Exception('There is already an element with the same id in index');
			}

			$this->index[$element->getId()] = $element;
		}
	}

	/**
	 * @param Element $element
	 *
	 * @throws \Exception
	 */
	protected function addIndex(Element $element)
	{
		$this->addElementToIndex($element, $this->getIndex());
	}

}