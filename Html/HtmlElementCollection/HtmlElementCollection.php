<?php
/**
 * Created by PhpStorm.
 * User: Faraday
 * Date: 08.09.2018
 * Time: 13:55
 */

namespace htmlOOP\Html\IndexedCollection;

use htmlOOP\Html\HtmlElement\HtmlElement;

use htmlOOP\ElementCollection\ElementCollection;

class HtmlElementCollection extends ElementCollection
{
	/**
	 * @var HtmlElement[] elements
	 */
	protected $elements;

	/**
	 * @var HtmlElement $owner
	 */
	protected $owner;

	public function __construct(HtmlElement $owner)
	{
		parent::__construct($owner);
	}

}