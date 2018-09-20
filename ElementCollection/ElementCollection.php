<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 04.09.18
 * Time: 15:01
 */

namespace htmlOOP\ElementCollection;

use htmlOOP\Element\Element;
use \Traversable;

class ElementCollection implements \ArrayAccess, \IteratorAggregate
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
		$this->elements = [];
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
	 * @return Element Can return all value types.
	 * @since 5.0.0
	 */
	public function offsetGet($offset)
	{
		return isset($this->elements[$offset]) ? $this->elements[$offset] : null;
	}

	/**
	 * Offset to set
	 * @link  https://php.net/manual/en/arrayaccess.offsetset.php
	 *
	 * @param Element $offset <p>
	 *                        The offset to assign the value to.
	 *                        </p>
	 * @param mixed   $value  <p>
	 *                        The value to set.
	 *                        </p>
	 *
	 * @return void
	 * @since 5.0.0
	 * @throws \Exception
	 */
	public function offsetSet($offset, $value)
	{
		if (is_null($offset)) {
			$this->elements[] = $value;
		} else if(is_int($offset)) {
			$this->elements[$offset] = $value;
		} else {
			// TODO: create specific class exception for this class
			throw new \Exception('only numeric offset allowed in ElementsCollection');
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

	/**
	 * Retrieve an external iterator
	 * @link  https://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 * @since 5.0.0
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->elements);
	}
}