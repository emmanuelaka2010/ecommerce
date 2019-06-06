<?php

require 'database.php';

$nom = $prenom = $email = $mdp = $cmdp =$nomError = $prenomError = $emailError = $mdpError = $cmdpError = "";
if(!empty($_POST)){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $cmdp = $_POST['cmdp'];
    $isSuccess = true;

    if(empty($nom)){
        $nomError = "Veuillez enter votre nom";
        $isSuccess = "false";
    }

    if(empty($prenom)){
        $prenomError = "Veuillez enter votre prenom";
        $isSuccess = "false";
    }

    if(empty($email)){
        $emailError = "Veuillez enter votre Email";
        $isSuccess = "false";
    }


    if(empty($mdp)){
        $mdpError = "Veuillez enter un mot de passe";
        $isSuccess = "false";
    }

    if(empty($cmdp)){
        $cmdpError = "Veuillez comfirmer le mot de passe";
        $isSuccess = "false";
    }

    if($mdp != $cmdp){
        $mdpError = "Les mots de passe ne sont pas conformes";
        $cmdpError = "Les mots de passe ne sont pas conformes";
        $isSuccess = "false";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailError = "Veuillez entrer un email correct comme abc@example.com";
        $isSuccess = false;
    }

    $db = database::connect();
    $req = $db->prepare("SELECT COUNT(id_users) FROM users WHERE email = ?");
    $req->execute(array($email));
    $count = $req->fetch();
    if($count[0] >= 1){
        $emailError = "Email déja utilisé";
        $isSuccess = false;
    }
    Database::disconnect();
    if($isSuccess){
        $db = Database::connect();
        // $req = "INSERT INTO users (nom,prenom,email,mdp) values(?, ?, ?, ?)"
        $statement = $db->prepare('INSERT INTO users (nom,prenom,email,mdp) values(?, ?, ?, ?)');
        $statement->execute(array($nom,$prenom,$email,$mdp));
        Database::disconnect();
        header("Location: index.php");
    }        

}

function checkInput($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
