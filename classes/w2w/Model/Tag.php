<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:49
 */

namespace w2w\Model;

/**
 * @Entity
 * @table(name="tags")
 */
class Tag
{
    const TOSTRING_FORMAT = "Tag#%d (name='%s', description='%s')";

 	/**
	 * @Id 
	 * @Column(type="integer") 
	 * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column
     */
    private $name;

    /**
     * @Column
     */
    private $description;

    /**
     * Tag constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id = null, string $name = null, $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function __toString()
    {
        return sprintf(self::TOSTRING_FORMAT, $this->id, $this->name, $this->description);
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


}
