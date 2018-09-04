<?

namespace htmlOOP;

class Element
{
	/**
	 * @var string name
	 */
	private $name;

	/**
	 * @var Element parent
	 */
	private $parent;

	/**
	 * @var string index
	 */
	private $index;

	/**
	 * @var array attributes
	 */
	private $attributes;

	/**
	 * @var ElementCollection children
	 */
	private $children;

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

	/**
	 * @param string $value
	 */
	protected function set_name(string $value)
	{
		$this->name = $value;
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


	public function add_child(Element $element)
	{
		// todo
	}

	public function set_attribute(string $attribute, $value)
	{
		// todo проверка входящий данных
		$this->attributes[$attribute] = $value;
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