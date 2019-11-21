<?php
namespace w2w\DAO;

use \w2w\Model\Role;
use \w2w\Model\User;

class UserDAO extends BaseDAO
{
    
    const SQL_SELECT = "SELECT us.id, user_name, email, email_verified, password_hash, first_name, last_name, created_at, updated_at, last_login_at, banned, number_reviews, ro.id AS role_id, ro.name AS role_name, ro.description as role_description FROM users AS us 
        INNER JOIN roles AS ro ON us.fk_role_id=ro.id";


    public function __construct()
    {
        parent::__construct("\\w2w\\Model\\User", "users");
    }


    public function fetchFromRow($row)
    {
        $item = new $this->className();
        if (isset($row["id"])) {
            $item->setId($row["id"]);
        }
        if (isset($row["user_name"])) {
            $item->setUserName($row["user_name"]);
        }
        if (isset($row["email"])) {
            $item->setEmail($row["email"]);
        }
        if (isset($row["email_verified"])) {
            $item->setEmailVerified($row["email_verified"]);
        }
        if (isset($row["password_hash"])) {
            $item->setPasswordHash($row["password_hash"]);
        }
        if (isset($row["first_name"])) {
            $item->setFirstName($row["first_name"]);
        }
        if (isset($row["last_name"])) {
            $item->setLastName($row["last_name"]);
        }
        if (isset($row["created_at"])) {
            $item->setCreatedAt(strtotime($row["created_at"]));
        }
        if (isset($row["updated_at"])) {
            $item->setUpdatedAt(strtotime($row["updated_at"]));
        }
        if (isset($row["last_login_at"])) {
            $item->setLastLoginAt(strtotime($row["last_login_at"]));
        }
        if (isset($row["banned"])) {
            $item->setBanned($row["banned"]);
        }
        if (isset($row["number_reviews"])) {
            $item->setNumberReviews($row["number_reviews"]);
        }
        if (isset($row["role_id"])) {
            $role = new Role();
            $role->setId($row["role_id"]);
            if (isset($row["role_name"])) {
                $role->setName($row["role_name"]);
            }
            if (isset($row["role_description"])) {
                $role->setDescription($row["role_description"]);
            }
            $item->setRole($role);
        }
        return $item;
    }

    public function selectAll()
    {
        $items = [];
        if ($pdo = $this->getPDO()) {
            $sql = self::SQL_SELECT;
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
            $sql = self::SQL_SELECT . " WHERE us.id=:id";
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
    
    public function selectByEmail($email)
    {
        if ($pdo = $this->getPDO()) {
            $sql = self::SQL_SELECT . " WHERE email=:email";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindValue(":email", $email);
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

    public function insert(User $user)
    {
        if ($pdo = $this->getPDO()) {
            $sql = "INSERT INTO users (user_name, email, email_verified, password_hash, first_name, last_name, created_at, updated_at, last_login_at, banned, number_reviews, fk_role_id) 
                VALUES (:user_name, :email, :email_verified, :password_hash, :first_name, :last_name, :created_at, :updated_at, :last_login_at, :banned, :number_reviews, :fk_role_id)";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindValue(":user_name", $user->getUserName());
                $stmt->bindValue(":email", $user->getEmail());
                $stmt->bindValue(":email_verified", $user->getEmailVerified() ? true : false, \PDO::PARAM_BOOL);
                $stmt->bindValue(":password_hash", $user->getPasswordHash());
                $stmt->bindValue(":first_name", $user->getFirstName());
                $stmt->bindValue(":last_name", $user->getLastName());
                $this->bindTimestampToDatetime($stmt, ":created_at", $user->getCreatedAt());
                $this->bindTimestampToDatetime($stmt, ":updated_at", $user->getUpdatedAt());
                $this->bindTimestampToDatetime($stmt, ":last_login_at", $user->getLastLoginAt());
                $stmt->bindValue(":banned", $user->isBanned() ? true : false, \PDO::PARAM_BOOL);
                $stmt->bindValue(":number_reviews", $user->getNumberReviews());
                if ($role = $user->getRole()) {
                    $roleId = $role->getId();
                } else {
                    $roleId = null;
                }
                $stmt->bindValue(":fk_role_id", $roleId);
                $rs = $stmt->execute();
                $id = $pdo->lastInsertId();
                if ($id > 0) {
                    $user->setId($id);
                    return $id;
                }
            }
        }
        return false;
    }
    
    public function update(User $user)
    {
        $items = [];
        if ($pdo = $this->getPDO()) {
            $sql = "UPDATE users SET user_name = :user_name, email = :email, email_verified = :email_verified, password_hash = :password_hash, first_name = :first_name, last_name = :last_name, created_at = :created_at, updated_at = :updated_at, last_login_at = :last_login_at, banned = :banned, number_reviews = :number_reviews, fk_role_id = :fk_role_id WHERE id = :id";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindValue(":user_name", $user->getUserName());
                $stmt->bindValue(":email", $user->getEmail());
                $stmt->bindValue(":email_verified", $user->getEmailVerified() ? true : false, \PDO::PARAM_BOOL);
                $stmt->bindValue(":password_hash", $user->getPasswordHash());
                $stmt->bindValue(":first_name", $user->getFirstName());
                $stmt->bindValue(":last_name", $user->getLastName());
                $this->bindTimestampToDatetime($stmt, ":created_at", $user->getCreatedAt());
                $this->bindTimestampToDatetime($stmt, ":updated_at", $user->getUpdatedAt());
                $this->bindTimestampToDatetime($stmt, ":last_login_at", $user->getLastLoginAt());
                $stmt->bindValue(":banned", $user->isBanned() ? true : false, \PDO::PARAM_BOOL);
                $stmt->bindValue(":number_reviews", $user->getNumberReviews());
                if ($role = $user->getRole()) {
                    $roleId = $role->getId();
                } else {
                    $roleId = null;
                }
                $stmt->bindValue(":fk_role_id", $roleId);
                $stmt->bindValue(":id", $user->getId());
                $rs = $stmt->execute();
                $affectedRows = $stmt->rowCount();
                echo "rs=$rs aff=$affectedRows\n";
                return $affectedRows;
            }
        }
        return false;
    }
}
