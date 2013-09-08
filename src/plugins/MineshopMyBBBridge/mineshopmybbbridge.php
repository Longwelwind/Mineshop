<?php
 
/*
 * Configuration
 */
$databaseMineshop["host"] = "localhost";
$databaseMineshop["login"] = "root";
$databaseMineshop["password"] = "";
$databaseMineshop["name"] = "mineshop";

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

$plugins->add_hook("member_do_register_end", "mineshopmybbbridge_user_register");

function mineshopmybbbridge_info() {
    return array(
		"name"			=> "Mineshop MyBB Bridge",
		"description"	=> "A simple plugin to make the user created in MyBB automatically created in Mineshop.",
		"website"		=> "http://ptibiscuit.net",
		"author"		=> "MsPtibiscuit",
		"authorsite"	=> "http://ptibiscuit.net",
		"version"		=> "1.0",
		"guid" 			=> "",
		"compatibility" => "*"
	);
}

function mineshopmybbbridge_user_register($userdata) {
    global $user_info;
    var_dump($user_info);
    // On connecte a la base de données
    $pdo = new PDO("mysql:host=" . $databaseMineshop["host"] . ";dbname=" . $databaseMineshop["name"], $databaseMineshop["login"], $databaseMineshop["password"]);
    $q = $pdo->prepare("INSERT INTO shp_users(user_name, user_email, user_password, user_register_time) VALUES(:name, :email, :password, :time)");
    $q->bindValue(":name", $user_info["username"]);
    $q->bindValue(":email", $user_info["email"]);
    $q->bindValue(":password", $user_info["password"]);
    $q->bindValue(":time", time());
    $q->execute();
}

