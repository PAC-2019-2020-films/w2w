<?php


namespace w2w\DAO;


use w2w\Model\Tag;

class TagsDAO extends BaseDAO
{
    private $table = 'tags';

    /**
     * TagsDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * tagObjectBinder
     * @param array $tagArray
     * @return bool|Tag
     */
    public function tagObjectBinder(array $tagArray)
    {
        if (isset($tagArray['id']) && isset($tagArray['name'])) {
            $tag = new Tag(
                $tagArray['id'],
                $tagArray['name']
            );
            
            if (isset($tagArray['description'])) {
                $tag->setDescription($tagArray['description']);
            }
            return $tag;
        } else {
            return false;
        }
    }


    /**
     * @return bool|Tag[]
     */
    public function selectAllTags()
    {
        $tags = [];
        
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description
                FROM {$this->table}
                ORDER BY {$this->table}.name;
                ";

        $result = $this->select($sql);

        if (is_array($result)) {
            foreach ($result as $tag) {
                array_push($tags, $this->tagObjectBinder($tag));
            }
            return $tags;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param int $id
     * @return bool|Tag
     */
    public function selectTagById(int $id)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description
                FROM {$this->table}
                WHERE {$this->table}.id = :id;
                ";

        $condition = [':id' => $id];
        $dataType = 1;

        $result = $this->select($sql, $condition, $dataType);

        if (is_array($result)) {
            return $this->tagObjectBinder($result[0]);
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param string $name
     * @return bool|Tag
     */
    public function selectTagByName(string $name)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description
                FROM {$this->table}
                WHERE {$this->table}.name = :name;
                ";

        $condition = [':name' => $name];
        $dataType = 2;

        $result = $this->select($sql, $condition, $dataType);

        if (is_array($result)) {
            return $this->tagObjectBinder($result[0]);
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Tag $tag
     * @return bool|int
     */
    public function insertTag(Tag $tag)
    {
        $data = [
            'name' => [$tag->getName(), 2],
            'description' => [$tag->getDescription(), 2]
        ];

        $result = $this->insert($this->table, $data);

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Tag $tag
     * @return bool|int
     */
    public function updateTag(Tag $tag)
    {
        $data = [
            'name' => [$tag->getName(), 2],
            'description' => [$tag->getDescription(), 2]
        ];

        $condition = "{$this->table}.id = :id";

        $result = $this->update($this->table, $data, $condition, $tag->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */
        return false;
    }

    /**
     * @param Tag $tag
     * @return bool|int
     */
    public function deleteTag(Tag $tag)
    {
        $condition = "{$this->table}.id = :id";

        $result = $this->delete($this->table, $condition, $tag->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


}