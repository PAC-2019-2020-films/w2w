<?php


namespace w2w\DAO;

use w2w\Model\Movie;
use w2w\Model\Tag;

class MovieTagsDAO extends BaseDAO
{
    private $table = 'movies_tags';
    private $tableTag = 'tags';
    private $tagDAO;

    /**
     * MovieDirectorDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->tagDAO = new TagsDAO();
    }

    /**
     * @param Movie $movie
     * @return bool|Tag[]
     */
    public function selectMovieTagsByMovie(Movie $movie)
    {
        $movieTags = [];
        $sql = "
                SELECT {$this->table}.fk_movie_id, 
                       {$this->table}.fk_tag_id, 
                       {$this->tableTag}.id, 
                       {$this->tableTag}.name, 
                       {$this->tableTag}.description
                FROM {$this->table}
                    LEFT JOIN {$this->tableTag} 
                            ON {$this->tableTag}.id = {$this->table}.fk_tag_id
                WHERE {$this->table}.fk_movie_id = :id;
        ";

        $condition = [':id' => $movie->getId()];
        $dataType = 1;
        
        $result = $this->select($sql, $condition, $dataType);

        if (is_array($result)) {
            foreach ($result as $tag) {
                array_push($movieTags, $this->tagDAO->tagObjectBinder($tag));
            }
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


    /**
     * @param Tag $tag
     * @param Movie $movie
     * @return bool|int
     */
    public function insertMovieTag(Tag $tag, Movie $movie)
    {
        $data = [
            "fk_movie_id" => [$movie->getId(), 1],
            "fk_tag_id" => [$tag->getId(), 1]
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
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovieTag(Tag $tag, Movie $movie)
    {
        $condition = "{$this->table}.fk_movie_id = :id AND {$this->table}.fk_tag_id = :idBis";

        $result = $this->delete($this->table, $condition, $movie->getId(), $tag->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }
}