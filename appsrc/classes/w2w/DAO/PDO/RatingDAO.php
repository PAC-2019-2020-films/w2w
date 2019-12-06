<?php


namespace w2w\DAO\PDO;


use w2w\Model\Rating;

class RatingDAO extends BaseDAO
{
    private $table = "ratings";

    /**
     * RatingDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * ratingObjectBinder
     * @param array $ratingArray
     * @return bool|Rating
     */
    public function ratingObjectBinder(array $ratingArray)
    {
        if (isset($ratingArray['id']) && isset($ratingArray['name']) && isset($ratingArray['value'])) {
            $rating = new Rating(
                $ratingArray['id'],
                $ratingArray['name'],
                $ratingArray['value']
            );
            
            if ($ratingArray['description']) {
                $rating->setValue($ratingArray['description']);
            }
            
            return $rating;
        } else {
            return false;
        }
    }
    
    /**
     * @return bool|Rating[]
     */
    public function selectAllRatings()
    {
        $ratings = [];
        
        $sql = "SELECT  {$this->table}.id,
                        {$this->table}.name, 
                        {$this->table}.description, 
                        {$this->table}.value
                FROM {$this->table}
                ORDER BY {$this->table}.value;
                ";

        $result = $this->select($sql);

        if (is_array($result)) {
            foreach ($result as $rating) {
                array_push($ratings, $this->ratingObjectBinder($rating));
            }
            return $ratings;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param int $id
     * @return bool|Rating
     */
    public function selectRatingById(int $id)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description, 
                        {$this->table}.value
                FROM {$this->table} 
                WHERE {$this->table}.id = :id";


        $condition = [':id' => $id];
        $dataType = 1;

        $result = $this->select($sql, $condition, $dataType);

        if (is_array($result)) {
            return $this->ratingObjectBinder($result[0]);
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param string $name
     * @return bool|Rating
     */
    public function selectRatingByName(string $name)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description, 
                        {$this->table}.value
                FROM {$this->table} 
                WHERE {$this->table}.name = :name";


        $condition = [':name' => $name];
        $dataType = 2;

        $result = $this->select($sql, $condition, $dataType);

        if (is_array($result)) {
            return $this->ratingObjectBinder($result[0]);
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param int $value
     * @return bool|Rating
     */
    public function selectRatingByValue(int $value)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description, 
                        {$this->table}.value
                FROM {$this->table} 
                WHERE {$this->table}.value = :value";


        $condition = [':value' => $value];
        $dataType = 1;

        $result = $this->select($sql, $condition, $dataType);

        if (is_array($result)) {
            return $this->ratingObjectBinder($result[0]);
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


    /**
     * @param Rating $rating
     * @return bool|int
     */
    public function insertRating(Rating $rating)
    {
        $data = [
            'name' => [$rating->getName(), 2],
            'description' => [$rating->getDescription(), 2],
            'value' => [$rating->getValue(), 1]
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
     * @param Rating $rating
     * @return bool|int
     */
    public function updateRating(Rating $rating)
    {
        $data = [
            'name' => [$rating->getName(), 2],
            'description' => [$rating->getDescription(), 2],
            'value' => [$rating->getValue(), 1]
        ];

        $condition = "{$this->table}.id = :id";

        $result = $this->update($this->table, $data, $condition, $rating->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */
        return false;
    }

    /**
     * @param Rating $rating
     * @return bool|int
     */
    public function deleteRating(Rating $rating)
    {
        $condition = "{$this->table}.id = :id";

        $result = $this->delete($this->table, $condition, $rating->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


}
