<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 05.09.18
 * Time: 10:10
 */

namespace htmlOOP\Html\HtmlElement;

use htmlOOP\Element\Element;
use htmlOOP\Html\IndexedCollection\HtmlElementCollection;

class HtmlElement extends Element
{

	const SPECIAL_DATA_NAME = 'name';
	const SPECIAL_DATA_ID = 'id';

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
		$this->specialData[] = HtmlElement::SPECIAL_DATA_NAME;

		$this->root = $this;

		parent::__construct($data, $children);
	}

	/**
	 * @param        $index
	 * @param string $value
	 */
	public function setData($index, string $value)
	{
		if (!$this->setSpecialData($index, $value))
		{
			$this->data[$index] = $value;
		}
	}

	/**
	 * @param        $index
	 * @param string $value
	 *
	 * @return bool
	 */
	protected function setSpecialData($index, string $value)
	{
		if (in_array($index, $this->specialData))
		{
			$this->$index = $value;

			return TRUE;
		}

		return FALSE;
	}

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


	/////////////////////////////////////////


	public function set_index(string $value)
	{
		// todo добавить проверку
		if (!$this->check_index($value))
		{
			// todo throw exception
		}

		$this->index = $value;
		$this->indexed_elements->add_element($this);
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
	 * @param string $value
	 */
	public function setName(string $value)
	{
		$this->name = $value;
	}

	public function get_index()
	{
		return $this->index;
	}

	/**
	 * @param string $index
	 *
	 * @return bool
	 */
	protected function check_index(string $index)
	{
		return TRUE;
	}
}