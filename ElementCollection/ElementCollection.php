<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 04.09.18
 * Time: 15:01
 */

namespace htmlOOP\ElementCollection;

use htmlOOP\Element\Element;

class ElementCollection implements \ArrayAccess
{

	/**
	 * @var Element[] elements
	 */
	protected $elements;

	/**
	 * @var Element $owner
	 */
	protected $owner;

	/**
	 * ElementCollection constructor.
	 *
	 * @param Element $owner
	 */
	public function __construct(Element $owner)
	{
		$this->owner = $owner;
	}

	/**
	 * @return Element
	 */
	public function getOwner()
	{
		return $this->owner;
	}

	/**
	 * @return array
	 */
	public function get_elements()
	{
		return $this->elements;
	}

	/**
	 * @param ElementCollection $collection
	 */
	public function merge_collection(ElementCollection $collection)
	{
		array_merge($this->elements, $collection->get_elements());
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
		return isset($this->elements[$offset]);
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
		return isset($this->elements[$offset]) ? $this->elements[$offset] : null;
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
			$this->elements[] = $value;
		} else if(is_int($offset)) {
			$this->elements[$offset] = $value;
		} else {
			// only numeric offset allowed in ElementsCollection
			// todo throw exception
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
		unset($this->elements[$offset]);
	}
}