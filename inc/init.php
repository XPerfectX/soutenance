<?php

//connexion à la BD
$pdo = new PDO('mysql:host=localhost;dbname=boutique_philiance', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'] );
//var_dump($pdo);

//-----------------------------------------------------------
//ouverture de session
session_start();

//-----------------------------------------------------------
//définition de constantes
define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT']. '/SiteDynamiquePHP/');
define("URL", 'http://localhost/sitedynamiquephp/');

//-----------------------------------------------------------
//déclaration de variable
$content = '';

//inclusion des fonctions
require_once('fonction.php');
?>