<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 21.09.18
 * Time: 17:58
 */

namespace htmlOOP\Html\HtmlRenderer;

use htmlOOP\Html\HtmlElement\HtmlElement;

class HtmlRenderer
{

	protected static $indent = '  ';
	protected static $depth = 0;

	protected static function pasteIndent()
	{
		echo str_repeat(self::$indent, self::$depth);
	}

	public static function render(HtmlElement $element)
	{

		switch ($element->getType())
		{
			case HtmlElement::ELEMENT_TYPE_TEXT:
				self::pasteIndent();
				echo $element->getData('text') . PHP_EOL;

				break;
			case HtmlElement::ELEMENT_TYPE_EMPTY:
				self::pasteIndent();

				echo '<' . $element->getTag() . ' ';

				foreach ($element->getAllData() as $attribute => $value)
				{
					if (empty($value))
					{
						echo "$attribute ";
					} else {
						echo $attribute . '="' . $value . '" ';
					}
				}

				echo '>' . PHP_EOL;

				break;
			case HtmlElement::ELEMENT_TYPE_STANDARD:
			default:
				self::pasteIndent();

				echo '<' . $element->getTag();

				foreach ($element->getAllData() as $attribute => $value)
				{
					if (empty($value))
					{
						echo " $attribute";
					} else {
						echo ' ' . $attribute . '="' . $value . '"';
					}
				}

				echo '>';

				if (count($element->getChildren()->getElements()))
				{
					echo PHP_EOL;

					self::$depth++;

					foreach ($element->getChildren() as $child)
					{
						$child->htmlRender();
					}

					self::$depth--;

					self::pasteIndent();
				}


				echo '</' . $element->getTag() . '>' . PHP_EOL;

				break;
		}
	}

}