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

class ElementCollection implements \ArrayAccess, \IteratorAggregate, \Countable
{

	/**
	 * @var Element[] elements
	 */
	protected $elements;

	/**
	 * @var Element $owner
	 */
	protected $owner = null;

	/**
	 * ElementCollection constructor.
	 *
	 * @param Element $owner
	 */
	public function __construct(Element $owner = null)
	{
		if ($owner instanceof Element)
		{
			$this->owner = $owner;
		}

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
	public function getElements()
	{
		return $this->elements;
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
	 * @return Element|null Can return all value types.
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
	 * @param string|int $offset <p>
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
		} else {
			$this->elements[$offset] = $value;
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

	/**
	 * Count elements of an object
	 * @link  https://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 * @since 5.1.0
	 */
	public function count()
	{
		return count($this->elements);
	}
}