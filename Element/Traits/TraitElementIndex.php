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

	/**
	 * @return ElementCollection
	 */
	public function getIndex()
	{
		return $this->index;
	}

    /**
     * @param string  $id
     * @param Element $element
     *
     * @throws \Exception
     */
    public function setId(string $id, Element $element)
    {
        if (!$this->checkIdInIndex($id, $element->getIndex()))
        {
            throw new \Exception('There is already an element with the same id in index');
        }

        $this->addToIndex($element, $element->getIndex());
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

	/**
	 * @param string            $id
	 * @param ElementCollection $index
	 *
	 * @return bool
	 */
	public function checkIdInIndex(string $id, ElementCollection $index)
	{
		return in_array($id, array_keys($index->getElements()));
	}

	/**
	 * @param Element           $element
	 * @param ElementCollection $index
	 *
	 * @throws \Exception
	 */
	protected function addToIndex(Element $element, ElementCollection $index)
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

}