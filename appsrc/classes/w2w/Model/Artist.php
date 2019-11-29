<?php


namespace w2w\Model;


class Artist
{
    private $id;
    private $firstName;
    private $lastName;

    /**
     * Artist constructor.
     * @param int $id
     * @param string $lastName
     */
    public function __construct(int $id, string $lastName, string $firstName = null)
    {
        $this->id = $id;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
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
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     *
    */
    public function serialize()
    {

    }


}