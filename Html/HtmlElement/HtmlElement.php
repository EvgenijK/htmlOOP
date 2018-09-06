<?php
/**
 * Created by PhpStorm.
 * User: ekomov
 * Date: 05.09.18
 * Time: 10:10
 */

namespace htmlOOP\Html\HtmlElement;

use htmlOOP\Element\Element;

class HtmlElement extends Element
{

    /**
     * @var string index
     */
    private $index;

    /**
     * @var ElementCollection indexed_elements
     */
    private $indexed_elements;

    /**
     * Element constructor.
     *
     * @param Element|string $values
     */
    public function __construct(...$values)
    {
        $tmp_children = new ElementCollection();
        $tmp_attributes = [];

        foreach ($values as $index => $value)
        {
            if ($value instanceof Element)
            {

                if (is_string($index) && $this->check_index($index))
                {
                    $value->set_index($index);
                }

                $tmp_children[] = $value;
            } elseif ($value instanceof ElementCollection)
            {
                $tmp_children->merge_collection($value);
            } elseif (is_string($value) || is_numeric($value))
            {
                if (is_string($index))
                {
                    // добавляется аттрибут

                    if (key_exists($index, $this->attributes))
                    {
                        // todo throw exception
                    }

                    $tmp_attributes[$index] = $value;

                } elseif (is_numeric($index) && (is_string($value) || is_numeric($value)))
                {
                    // добавляется просто текст в значение элемента
                    $tmp_children[] = new Element($value);
                } else
                {
                    // todo throw exception
                }
            }
        }

        foreach ($tmp_children->get_elements() as $element)
        {
            $this->add_child($element);
        }

        foreach ($tmp_attributes as $attribute => $value)
        {
            $this->set_attribute($attribute, $value);
        }


    }

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

    public function get_index()
    {
        return $this->index;
    }

    /**
     * @param string $index
     *
     * @return bool
     */
    private function check_index(string $index)
    {
        return TRUE;
    }
}