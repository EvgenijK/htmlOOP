<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 26.09.18
 * Time: 12:45
 */

namespace htmlOOP\Element\Traits;

use htmlOOP\Element\Element;

trait TraitParentElement
{
	/**
	 * @var Element $parent
	 */
	protected $parent;

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

}
