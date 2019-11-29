<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:30
 */

namespace w2w\DAO;


use w2w\Model\Category;

class CategoryDAO extends BaseDAO
{

    private $table;
    
    /**
     * CategoryDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = "categories";
    }
    
    
    /**
     * categoryObjectBinder
     * Binds a PDO::fetchAll result row to a new Category Object
     * @param array $categoriesArray
     * @return bool|Category
     */
    public function categoryObjectBinder(array $categoriesArray)
    {
        if (isset($categoriesArray['id']) && isset($categoriesArray['name'])) {
            $category = new Category(
                $categoriesArray['id'],
                $categoriesArray['name']
            );
            
            if ($categoriesArray['description']) {
                $category->setDescription($categoriesArray['description']);
            }
            
            return $category;
        } else {
            return false;
        }
    }

    /**
     * @return bool|Category[]
     */
    public function selectAllCategories()
    {
        $categories = [];
        
        $sql = "SELECT  {$this->table}.id,
                        {$this->table}.name,
                        {$this->table}.description
                FROM {$this->table}
                ORDER BY {$this->table}.name;
                ";

        $result = $this->select($sql);

        if (is_array($result)) {
            foreach ($result as $category) {
                array_push($categories, $this->categoryObjectBinder($category));
            }
            return $categories;
        }

        return false;
    }

    /**
     * @param int $id
     * @return bool|Category
     */
    public function selectCategoryById(int $id)
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
            return $this->categoryObjectBinder($result[0]);
        }

        return false;
    }

    /**
     * @param string $name
     * @return bool|Category
     */
    public function selectCategoryByName(string $name)
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
            return $this->categoryObjectBinder($result[0]);
        }

        return false;
    }

    /**
     * @param Category $category
     * @return bool|int
     */
    public function insertCategory(Category $category)
    {
        $data = [
            'name' => [$category->getName(), 2],
            'description' => [$category->getDescription(), 2]
        ];

        $result = $this->insert($this->table, $data);

        if (is_string($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Category $category
     * @return bool|int
     */
    public function updateCategory(Category $category)
    {
        $data = [
            'name' => [$category->getName(), 2],
            'description' => [$category->getDescription(), 2]
        ];

        $condition = "{$this->table}.id = :id";

        $result = $this->update($this->table, $data, $condition, $category->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */
        return false;
    }

    /**
     * @param Category $category
     * @return bool|int
     */
    public function deleteCategory(Category $category)
    {
        $condition = "{$this->table}.id = :id";

        $result = $this->delete($this->table, $condition, $category->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

}