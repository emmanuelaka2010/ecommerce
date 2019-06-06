<?php
require 'database.php';
$db = database::connect();
$req = $db->prepare("SELECT COUNT(id_users) FROM users WHERE email = 'abc@abc.fr'");
$req->execute(array());
$count = $req->fetch();
if($count[0] >= 1){
    echo "Email déja utilisé";
}
Database::disconnect();

?>