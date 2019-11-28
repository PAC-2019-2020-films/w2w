<?php
    /**
     * Created by PhpStorm.
     * User: Meh
     * Date: 14/11/2019
     * Time: 20:50
     */
    
    namespace w2w\Model;
    
    
    class Rating
    {
        private $id;
        private $name;
        private $description;
        private $value;

        /**
         * Rating constructor.
         * @param int $id
         * @param string $name
         * @param int $value
         */
        public function __construct(int $id, string $name, int $value)
        {
            $this->id = $id;
            $this->name = $name;
            $this->value = $value;
        }


        /**
         * @return int
         */
        public function getId(): int
        {
            return $this->id;
        }

        /**
         * @param int $id
         */
        public function setId(int $id): void
        {
            $this->id = $id;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @param string $name
         */
        public function setName(string $name): void
        {
            $this->name = $name;
        }

        /**
         * @return string
         */
        public function getDescription(): string
        {
            return $this->description;
        }

        /**
         * @param string $description
         */
        public function setDescription(string $description): void
        {
            $this->description = $description;
        }

        /**
         * @return int
         */
        public function getValue(): int
        {
            return $this->value;
        }

        /**
         * @param int $value
         */
        public function setValue(int $value): void
        {
            $this->value = $value;
        }
        
    }