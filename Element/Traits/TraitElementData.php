<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 26.09.18
 * Time: 12:58
 */

namespace htmlOOP\Element\Traits;


trait TraitElementData
{
	/**
	 * @var array $data
	 */
	protected $data;

	/**
	 * @var string[] $specialData
	 */
	protected $specialData = [];

	/**
	 * @param string $value
	 */
	public function addData(string $value)
	{
		$this->data[] = $value;
	}

	/**
	 * @param array $new_data
	 */
	public function setAllData(array $new_data)
	{
		$this->data = $new_data;
	}

	/**
	 * @param $index
	 * @param $value
	 */
	public function setData($index, $value)
	{
		if (!$this->setSpecialData($index, $value))
		{
			if (is_int($index) && !empty((string) $value))
			{
				$this->data[$index] = $value;
			} else
			{
				$this->data[$value] = '';
			}
		}

		$this->data[$index] = $value;
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
	 * @param $index
	 *
	 * @return mixed
	 */
	public function getData($index)
	{
		return $this->data[$index];
	}

	/**
	 * @return array
	 */
	public function getAllData()
	{
		return $this->data;
	}

}