<?php
namespace w2w\DAO;

class RoleDAO extends BaseDAO
{

    public function __construct()
    {
        parent::__construct("\\w2w\\Model\\Role", "roles");
    }


    public function fetchFromRow($row)
    {
        $item = new $this->className();
        if (isset($row["id"])) {
            $item->setId($row["id"]);
        }
        if (isset($row["name"])) {
            $item->setName($row["name"]);
        }
        if (isset($row["description"])) {
            $item->setDescription($row["description"]);
        }
        return $item;
    }

    public function selectAll()
    {
        $items = [];
        if ($pdo = $this->getPDO()) {
            $sql = "SELECT id, name, description FROM roles";
            if ($stmt = $pdo->query($sql)) {
                while ($row = $stmt->fetch()) {
                    if ($item = $this->fetchFromRow($row)) {
                        $items[] = $item;
                    }
                }
                $stmt->closeCursor();
            }
        }
        return $items;
    }
    
    public function select($id)
    {
        if ($pdo = $this->getPDO()) {
            $sql = "SELECT id, name, description FROM roles WHERE id=:id";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindValue(":id", $id);
                if ($stmt->execute()) {
                    if ($row = $stmt->fetch()) {
                        if ($item = $this->fetchFromRow($row)) {
                            return $item;
                        }
                    }
                }
                $stmt->closeCursor();
            }
        }
    }
    
}
