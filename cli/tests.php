<?php

# delete or comment following line if in production env !
define("FR_ENV", "development");

require __DIR__ . "/../appsrc/bootstrap.php";



interface I
{
    public function erf($i);
}


class A implements I 
{
    function erf($i)
    {
        echo "erf $i\n";
    }
}


$a = new A();
$a->erf(45);


exit();


use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;



$paths = array(FR_SRCPATH . "/classes/w2w/Model");
$isDevMode = (FR_ENV !== FR_ENV_PRODUCTION);
// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'w2w',
    'password' => 'w2w',
    'dbname'   => 'w2w',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$em = EntityManager::create($dbParams, $config);


echo sprintf("FR_ENV=%s, devMode=%s\n", FR_ENV, ($isDevMode ? "T" : "F"));

echo $em->find("w2w\\Model\\Role", 1) . "\n";

if (0) {
    $role = new \w2W\Model\Role(time(), "Renés", "Tous les Renés");
    echo $role;
    $em->persist($role);
    $em->flush();
    echo $role;
}


echo $em->find("w2w\\Model\\User", 1) . "\n";
echo $em->find("w2w\\Model\\User", 2) . "\n";
echo $em->find("w2w\\Model\\User", 5) . "\n";
echo $em->find("w2w\\Model\\User", 6) . "\n";







exit();
$dao = new \w2w\DAO\BaseDAO();

$pdo = $dao->createPDO();

echo $pdo;


exit();
################################################################################
//40 u,80 a,81 root




################################################################################

function testSelect($pdo)
{
    $service = new \w2w\Service\PublicService();
    $role = $service->getRole(1);
    echo $role ." \n";
    $roles = $service->getRoles();
    foreach ($roles as $role) {
        echo sprintf("%s\n", (string) $role);
    }
}


function testSelectAll()
{
    $service = new \w2w\Service\PublicService();
    $users = $service->getUsers();
    foreach ($users as $user) {
        echo "- $user\n";
    }
}

function testAddUser($userName = "Roger", $email = "roger@erf.net", $password = "azerty", $roleId = 1)
{
    $service = new \w2w\Service\PublicService();
    $user = $service->addUser($userName, $email, $password, $roleId);
    echo $user;
}

function testAddAdmin($userName = "Léon", $email = "leon@erf.net", $password = "azerty", $roleId = 2)
{
    $service = new \w2w\Service\PublicService();
    $user = $service->addUser($userName, $email, $password, $roleId);
    echo $user;
}
function testAddRoot($userName = "Robert", $email = "robert@erf.net", $password = "azerty", $roleId = 3)
{
    $service = new \w2w\Service\PublicService();
    $user = $service->addUser($userName, $email, $password, $roleId);
    echo $user;
}

function testAddUsers($offset = 1, $num = 20)
{
    for ($i = $offset + 1 ; $i <= $offset + $num ; $i++) {
        testAddUser("Raoul $i", "raoul.$i@gmail.com");
    }
    
}

function testGetUser($id = 1)
{
    $service = new \w2w\Service\PublicService();
    $user = $service->getUser($id);
    echo sprintf("User by id $id : %s\n", $user);
}

function testLogin($email = "roger@erf.net", $password = "azerty")
{
    $service = new \w2w\Service\PublicService();
    $user = $service->login($email, $password);
    if ($user) {
        echo sprintf("login : %s\n", $user);
    } else {
        echo "login failed\n";
    }
}


function testUpdate($id = 36, $firstName = "Léon", $lastName = "Duboiss")
{
    $service = new \w2w\Service\PublicService();
    $affectedRows = $service->updateUser($id, $firstName, $lastName);
    echo "updated User#$id : $affectedRows.\n";
}


testAddAdmin();
testAddRoot();
//testAddUser();
//testAddUsers();

testSelectAll();

testGetUser();
//testLogin();
    
testUpdate();
