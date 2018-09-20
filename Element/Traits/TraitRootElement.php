<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 20.09.18
 * Time: 12:32
 */

namespace htmlOOP\Element\Traits;

use htmlOOP\Element\Element;

trait TraitRootElement
{
	/**
	 * Root element of the structure
	 *
	 * @var Element $root
	 */
	protected $root;

	/**
	 * @return Element
	 */
	public function getRoot()
	{
		return $this->root;
	}

}