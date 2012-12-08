<?php
/* Ceci est le fichier de configuration globale de la boutique.
 */
 
/* L'adresse URL menant vers ce dossier (Avec un slash au bout) */
$globalConfig["base_url"] = "http://maboutique.fr/shop/";

/* List des liens en haut à gauche */
$globalConfig["links"] = array(array("name" => "Support",
                                     "url" => "http://mysurvivalcraft.fr/Forum/index.php?forums/support-boutique.29/"),
                               array("name" => "",
                                     "url" => ""));

/* C'est les identifiants de la base de données */
$globalConfig["bdd_host"] = "localhost";
$globalConfig["bdd_name"] = "minecraft";
$globalConfig["bdd_login"] = "root";
$globalConfig["bdd_password"] = "";
?>