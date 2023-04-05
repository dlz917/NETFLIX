<?php
function getBD(){
$servername = "localhost";
$username = "root";
$dbname = "nchoice";
$bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username,"");
return $bdd;
}
?>