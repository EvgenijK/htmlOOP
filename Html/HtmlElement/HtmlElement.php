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

class HtmlElement extends Element
{

	const SPECIAL_DATA_ID  = 'id';
	const SPECIAL_DATA_TAG = 'tag';

	/**
	 * Root element of the structure
	 *
	 * @var HtmlElement $root
	 */
	protected $root;

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
	 * @var string[] $specialData
	 */
	protected $specialData = [
	];

	/**
	 * HtmlElement constructor.
	 *
	 * @param array       $data
	 * @param HtmlElement ...$children
	 */
	public function __construct(array $data = [], HtmlElement ...$children)
	{
		$this->specialData[] = HtmlElement::SPECIAL_DATA_ID;
		$this->specialData[] = HtmlElement::SPECIAL_DATA_TAG;

		$this->root = $this;

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
	 * @param string $value
	 */
	protected function setId(string $value)
	{
		$this->id = $value;
		$this->data[self::SPECIAL_DATA_ID] = $value;
	}

	/**
	 * @param string $value
	 */
	protected function setTag(string $value)
	{
		$this->tag = $value;
	}

	/////////////////////////////////////////

	/**
	 * @param HtmlElement      $root
	 * @param HtmlElement|NULL $oldRoot
	 */
	protected function setRoot(HtmlElement $root, $oldRoot = NULL)
	{
		if ($oldRoot === NULL && $this->root === $this)
		{
			foreach ($this->children as $child)
			{
				$child->setRoot($root, $this);
			}

			$this->root = $root;

		} elseif ($oldRoot instanceof HtmlElement)
		{
			if ($this->root === $oldRoot)
			{
				foreach ($this->children as $child)
				{
					$child->setRoot($root, $oldRoot);
				}

				$this->root = $root;
			}
		}
	}

	/**
	 * @return HtmlElement
	 */
	public function getRoot()
	{
		return $this->root;
	}

	/**
	 * @param HtmlElement $parent
	 */
	protected function setParent(HtmlElement $parent)
	{
		$this->setRoot($parent->getRoot());

		parent::setParent($parent);
	}

}