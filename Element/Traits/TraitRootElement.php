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
	 * @param Element      $new_root
	 * @param Element|NULL $oldRoot
	 *
	 * @throws \Exception
	 */
	protected function setRoot(Element $new_root, Element $oldRoot = NULL)
	{
		echo 'set root for ' . $this->getData('id') . ', new root is ' . $new_root->getData('id') . PHP_EOL;
		echo 'old root is ';
		if ($oldRoot instanceof Element) {
			echo $oldRoot->getData('id');
		} else {
			echo 'NULL';
		}
		echo PHP_EOL;
		if ($oldRoot === NULL && $this->getRoot() === $this)
		{

			echo 'Affected children: ' . PHP_EOL;
			foreach ($this->children as $child)
			{
				echo $child->getData('id') . ', ';
				$child->setRoot($new_root, $this);
			}
			echo PHP_EOL;

			$this->root = $new_root;
		} elseif ($oldRoot instanceof Element)
		{
			if ($this->root === $oldRoot)
			{
				foreach ($this->children as $child)
				{
					$child->setRoot($new_root, $oldRoot);
				}
				$this->root = $new_root;
			}
		} else {
			// TODO: create specific class exception for this class
			throw new \Exception('appending element isn\'t the root of it\'s tree');
		}

		echo PHP_EOL;
	}

	/**
	 * @return Element
	 */
	public function getRoot()
	{
		return $this->root;
	}

}