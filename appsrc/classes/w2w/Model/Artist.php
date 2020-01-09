<?php

namespace w2w\Model;

/**
 * @Entity
 * @Table(name="artists")
 */
class Artist
{
    const TOSTRING_FORMAT = "Artist#%d (firstName='%s', lastName='%s')";

  	/**
	 * @Id 
	 * @Column(type="integer") 
	 * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(name="first_name")
     */
    private $firstName;

    /**
     * @Column(name="last_name")
     */
    private $lastName;

    /**
     * Artist constructor.
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(int $id = null, string $firstName = null, string $lastName = null)
    {
        $this->id = $id;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
    }

    public function __toString()
    {
        return sprintf(
            self::TOSTRING_FORMAT, 
            $this->id, 
            $this->firstName,
            $this->lastName
        );
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
     * @todo : utile ?
     */
    public function serialize()
    {
    }

}
