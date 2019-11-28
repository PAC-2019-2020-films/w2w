<?php


namespace w2w\DAO;


use w2w\Model\Artist;

class ArtistDAO extends BaseDAO
{
    private $table = 'artists';

    /**
     * ArtistDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * artistObjectBinder
     * @param array $artistArray
     * @return bool|Artist
     */
    public function artistObjectBinder(array $artistArray)
    {
        if (isset($artistArray['id']) && isset($artistArray['last_name'])) {
            $artist = new Artist(
                $artistArray['id'],
                $artistArray['last_name']
            );
            
            if (isset($artistArray['first_name'])) {
                $artist->setFirstName($artistArray['first_name']);
            }
            
            return $artist;
        } else {
            return false;
        }
    }


    /**
     * @return bool|Artist[]
     */
    public function selectAllArtists()
    {
        $artists = [];
        
        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name
                FROM {$this->table}
                ORDER BY {$this->table}.first_name;  
        ";

        $result = $this->select($sql);

        if (is_array($result)) {
            foreach ($result as $artist) {
                array_push($artists, $this->artistObjectBinder($artist));
            }
            return $artists;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param int $id
     * @return bool|Artist
     */
    public function selectArtistById(int $id)
    {
        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name
                FROM {$this->table}
                WHERE {$this->table}.id = :id;
        ";

        $condition = [":id" => $id];
        $dataType = 2;

        $result = $this->select($sql, $condition, $dataType);
        
        if (is_array($result) && isset($result[0])) {
            return $this->artistObjectBinder($result[0]);
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param string $name
     * @return bool|Artist[]
     */
    public function selectArtistsByName(string $name)
    {
        $artists = [];
        
        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name
                FROM {$this->table}
                WHERE {$this->table}.first_name = :name 
                    OR {$this->table}.last_name = :name 
                ORDER BY {$this->table}.first_name;  
        ";

        $condition = [':name' => $name];
        $dataType = 2;

        $result = $this->select($sql, $condition, $dataType);
    
        if (is_array($result)) {
            foreach ($result as $artist) {
                array_push($artists, $this->artistObjectBinder($artist));
            }
            return $artists;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


    /**
     * @param Artist $artist : the Artist to insert in the DB
     * @return bool|int : returns false if it fails to insert into the DB, returns value of PDO::lastInsertId if it succeeds.
     */
    public function insertArtist(Artist $artist)
    {
        $data = [
            'first_name' => [$artist->getFirstName(), 2],
            'last_name' => [$artist->getLastName(), 2]
        ];


        $result = $this->insert($this->table, $data);

        if (is_string($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return $result;
    }

    /**
     * @param Artist $artist
     * @return bool|int
     */
    public function updateArtist(Artist $artist)
    {
        $data = [
            'first_name' => [$artist->getFirstName(), 2],
            'last_name' => [$artist->getLastName(), 2]
        ];

        $condition = "{$this->table}.id = :id";

        $result = $this->update($this->table, $data, $condition, $artist->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Artist $artist
     * @return bool|int
     */
    public function deleteArtist(Artist $artist)
    {
        $condition = "{$this->table}.id = :id";

        $result = $this->delete($this->table, $condition, $artist->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

}