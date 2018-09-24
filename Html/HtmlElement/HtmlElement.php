<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 05.09.18
 * Time: 10:10
 */

namespace htmlOOP\Html\HtmlElement;

use htmlOOP\Element\Element;
use htmlOOP\Html\HtmlElementCollection\HtmlElementCollection;
use htmlOOP\Html\HtmlRenderer\HtmlRenderer;

class HtmlElement extends Element
{

	const SPECIAL_DATA_TAG = 'tag';

	const ELEMENT_TYPE_STANDARD = 'standard';
	const ELEMENT_TYPE_EMPTY    = 'empty';
	const ELEMENT_TYPE_TEXT     = 'text';

	/**
	 * @var string $element_type
	 */
	protected $element_type;

	/**
	 * Unique id in the structure
	 *
	 * @var string $id
	 */
	protected $id;

	/**
	 * @var string $tag
	 */
	protected $tag;

	/**
	 * @var HtmlElementCollection $indexed_elements
	 */
	protected $indexed_elements;

	/**
	 * HtmlElement constructor.
	 *
	 * @param array       $data
	 * @param HtmlElement ...$children
	 *
	 * @throws \Exception
	 */
	public function __construct(array $data = [], HtmlElement ...$children)
	{
		$this->specialData[] = HtmlElement::SPECIAL_DATA_ID;
		$this->specialData[] = HtmlElement::SPECIAL_DATA_TAG;

		parent::__construct($data, ...$children);
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
				$this->setAttribute($value, '');
			} else {
				$this->setAttribute($index, $value);
			}
		}
	}

	/**
	 * @param string $attribute
	 * @param        $value - Will be converted to a string by (string)
	 */
	public function setAttribute(string $attribute, $value)
	{
		$this->data[$attribute] = (string) $value;
	}

	// Tag

	/**
	 * @param string $value
	 */
	protected function setTag(string $value)
	{
		$this->tag = $value;
	}

	/**
	 * @return string
	 */
	public function getTag()
	{
		return $this->tag;
	}

	// Type

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->element_type;
	}

	protected function setElementTypeStandard()
	{
		$this->element_type = self::ELEMENT_TYPE_STANDARD;
	}

	protected function setElementTypeEmpty()
	{
		$this->element_type = self::ELEMENT_TYPE_EMPTY;
	}

	protected function setElementTypeText()
	{
		$this->element_type = self::ELEMENT_TYPE_TEXT;
	}

	// Render

	public function htmlRender()
	{
		HtmlRenderer::render($this);
	}

}