<?php
/**
 * Created by PhpStorm.
 * User: Faraday
 * Date: 26.09.2018
 * Time: 22:40
 */

namespace htmlOOP\Html\HtmlElement\Traits;

trait TraitHtmlElementTag
{
	/**
	 * @var string $tag
	 */
	protected $tag;

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
}