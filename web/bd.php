<?php
function getBD(){
$servername = "localhost";
$username = "root";
$dbname = "nchoice_definitif";
$bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username,"");
return $bdd;
}
?>