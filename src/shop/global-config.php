<?php
/* Ceci est le fichier de configuration globale de la boutique.
 */
 
/* L'adresse URL menant vers ce dossier (Avec un slash au bout) */
$globalConfig["base_url"] = "http://maboutique.fr/shop/";
 
/* C'est le nom affiché en haut à droite, ainsi que le lien vers lequel il renvoie */
$globalConfig["name_index_link"] = "MineShop - Boutique";
$globalConfig["url_index_link"] = "http://maboutique.fr/";

/* Url du logo */
$globalConfig["logo_url"] = "http://mysurvivalcraft.fr/wp-content/uploads/2012/07/logo1.png1.png";

/* List des liens en haut à gauche */
$globalConfig["links"] = array(array("name" => "Support",
                                     "url" => "http://mysurvivalcraft.fr/Forum/index.php?forums/support-boutique.29/"),
                               array("name" => "",
                                     "url" => ""));
 
/* C'est la description qui s'affiche dans la page d'accueil du site. */
$globalConfig["description"] = "Bienvenue sur la boutique de MySurvivalCraft !<br />
Ici, vous pourrez, tout d'abord, achetez votre rang de paysan (Gratuit bien sûr) et ensuite, acheter d'autres bonus. En achetant des bonus, vous soutenez le travail du staff de MySurvivalCraft, et surtout, vous nous permettez de le financer ! Bla bla bla ...";

/* C'est les identifiants de la base de données */
$globalConfig["bdd_host"] = "localhost";
$globalConfig["bdd_name"] = "minecraft";
$globalConfig["bdd_login"] = "root";
$globalConfig["bdd_password"] = "";
?>