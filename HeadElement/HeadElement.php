<?php
    /**
     * Created by PhpStorm.
     * User: ekomov
     * Date: 19.09.18
     * Time: 11:21
     */

    namespace htmlOOP\HeadElement;

    use htmlOOP\Element\Element;

    /**
     * Class HeadElement
     * @package htmlOOP\HeadElement
     */
    class HeadElement
    {

        /**
         * @var Element
         */
        protected $head;

        /**
         * HeadElement constructor.
         *
         * @param Element $head
         */
        public function __construct(Element $head)
        {
            $this->head = $head;
        }

        /**
         * @return Element
         */
        public function getHead(): Element
        {
            return $this->head;
        }

        /**
         * @param Element $head
         */
        public function setHead(Element $head)
        {
            $this->head = $head;
        }

    }