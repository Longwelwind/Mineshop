<?php
function tableExists($pdo, $table) {

    // Try a select statement against the table
    // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
    try {
        $result = $pdo->query("SELECT 1 FROM " . $table . " LIMIT 1");
    } catch (Exception $e) {
        // We got an exception == table not found
        return FALSE;
    }

    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
}

include("libraries/confighandler.class.php");

// Defines the constants we'll use to know which page displays.
$enum = array("DB_LOGIN_REQUIRED", "FAILED_TO_DB_LOGIN", "FAILED_TO_INSTALL_DB", "SUCCESS_INSTALL_TABLES",  "DB_INSTALL_REQUIRED", "BASIC_INFO_REQUIRED");
$c = 0;
foreach ($enum as $value) {
    define($value, $c);
    $c++;
}
define("FINISHED", 99);
$state = -1;
/*
 * Controller to process input data
 */
if (isset($_POST["db_login_form"])) {
    // On enregistre les infos
    $config = array("db_host" => $_POST["db_host"],
                    "db_name" => $_POST["db_name"],
                    "db_login" => $_POST["db_login"],
                    "db_password" => $_POST["db_password"]);
    
    // We save the config
    confighandler_setConfig("config.txt", $config);
} else if (isset($_POST["basic_info_form"])) {
    $config = confighandler_getConfig("config.txt");
    // On rajoute les informations suivantes
    $config["base_url"] = $_POST["info_url_base"];
    // On enregistre le nom de la boutique
    $db = @new PDO("mysql:dbname=" . $config["db_name"] . ";host=" . $config["db_host"], $config["db_login"], $config["db_password"]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("DELETE FROM shp_config WHERE name = \"shop_title\";
            INSERT INTO shp_config(name, value) VALUES(\"shop_title\", \"" . $_POST["info_name"] . "\");");
    confighandler_setConfig("config.txt", $config);
}
/* 
 * Deciding which page we have to display
 */
// If config.txt doesn't exist
if (!file_exists("config.txt")) {
    $state = DB_LOGIN_REQUIRED;
} else {
    // We fetch the config
    $config = confighandler_getConfig("config.txt");
    // If there's database config
    if (array_key_exists("db_login", $config)) {
        // We check if the database config works
        try {
            $db = @new PDO("mysql:dbname=" . $config["db_name"] . ";host=" . $config["db_host"], $config["db_login"], $config["db_password"]);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // We check if tables already exist
            if (tableExists($db, "shp_users")) {
                // We check if "basic" info are already saved
                if (array_key_exists("base_url", $config)) {
                    // EVERYTHING IS DONE
                    $state = FINISHED;
                } else {
                    $state = BASIC_INFO_REQUIRED;
                }
            } else {
                // If they don't exist, we create them
                try {
                    $db->exec(file_get_contents("db_install.sql"));
                    $state = SUCCESS_INSTALL_TABLES;
                } catch (Exception $e) {
                    $state = FAILED_TO_INSTALL_DB;
                    $error = $e->getMessage();
                }
            }
        } catch(Exception $e) {
            $state = FAILED_TO_DB_LOGIN;
            $error = $e->getMessage();
        }
    } else {
        // There's no config
        $state = DB_LOGIN_REQUIRED;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Installation de Mineshop</title>
        <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <div class="body" style="margin-top: 100px;width: 700px;margin-left: auto;margin-right: auto;">
            <h1>Mineshop</h1>
            <div>
                <?php
                if ($state == DB_LOGIN_REQUIRED OR $state == FAILED_TO_DB_LOGIN) {
                    if ($state == FAILED_TO_DB_LOGIN) {
                        ?>
                        <div class="returnbox errorbox">Impossible de se connecter à la base de données</div>
                        <?php
                    }
                    ?><b>Etape 1</b>
                    <div>
                        Bienvenue sur l'installeur de Mineshop, votre boutique personnalisé pour votre serveur Minecraft.<br />
                        Il prend, entre autre, en charge l'installation de la base de données requise pour utiliser Mineshop correctement. Vous pouvez reprendre cette installation à tout moment, si vous devez recommencer cette installation,
                        supprimer le fichier config.txt situé à la racine de Mineshop.
                        Veuillez remplir les champs suivants concernants l'identification à la base de données
                    </div>
                    <form method="post" action="">
                        <input type="hidden" name="db_login_form" value="1">
                        <table>
                            <tr>
                                <td>Adresse:</td><td><input type="text" name="db_host"></td>
                            </tr>
                            <tr>
                                <td>Nom de la base de données:</td><td><input type="text" name="db_name"></td>
                            </tr>
                            <tr>
                                <td>Login:</td><td><input type="text" name="db_login"></td>
                            </tr>
                            <tr>
                                <td>Mot de passe:</td><td><input type="password" name="db_password"></td>
                            </tr>
                            <tr>
                                <td></td><td><input type="submit"></td>
                            </tr>
                        </table>
                    </form>
                    <?php
                } else if ($state == FAILED_TO_INSTALL_DB OR $state == SUCCESS_INSTALL_TABLES) {
                    if ($state == SUCCESS_INSTALL_TABLES) {
                        ?><div class="returnbox gooderrorbox">Réussite de l'installation des tables de base de donnéess !</div><?php
                    } else {
                        ?><div class="returnbox errorbox">Une erreur est survenue durant l'installation:<br /><?php echo $error; ?></div><?php
                    }
                    ?>  
                    <b>Etape 2</b>
                    <div>
                        Cette étape à pour but d'installer les tables de base de données nécéssaires au bon fonctionnement de Mineshop.<br />
                        <?php if ($state == SUCCESS_INSTALL_TABLES) {
                            ?><a class="button" href="">Passer à l'étape suivant</a><?php
                        } ?>
                    </div>
                    <?php
                } else if ($state == BASIC_INFO_REQUIRED) {
                    ?>
                        <b>Etape 3</b>
                        <div>
                            Veuillez maintenant remplir les informations basiques relatives à votre boutique Minecraft. Ces informationss serviront à configurer la boutique,
                            mais pourront être modifiés ultérieurement via le panel d'administration.
                            <form method="post" action="">
                            <input type="hidden" name="basic_info_form" value="1">
                            <table>
                                <tr>
                                    <td>
                                        Nom de votre serveur:<br />
                                        <i style="font-size: 13px;">Ex: PtibiscuitCraft</i>
                                    </td><td><input type="text" name="info_name"></td>
                                </tr>
                                <tr>
                                    <td>
                                        Url d'accès à votre boutique (Avec slash final):<br />
                                        <i style="font-size: 13px;">Ex: http://ptibiscuit.net/mineshop/</i>
                                    </td><td><input type="text" name="info_url_base"></td>
                                </tr>
                                <tr>
                                    <td></td><td><input type="submit"></td>
                                </tr>
                            </table>
                        </form>
                        </div>
                    <?php
                } else if ($state == FINISHED) {
                    ?><b>Installation terminée</b><br />
                        L'installation de Mineshop est (enfin ?) terminée.<br />
                        <p>
                            Vous pouvez dés maintenant vous rendre sur votre boutique à l'adresse <a href="<?php echo $config["base_url"]; ?>"><?php echo $config["base_url"]; ?></a>, et vous y inscrire
                            (Vous serez automatiquement mis en administrateur de la boutique). La documentation pour vous aider dans le reste de la configuration de Mineshop est disponible
                            à l'adresse <a href="http://ptibiscuit.net/wiki">http://ptibiscuit.net/wiki</a>.
                        </p>
                        <p>
                            Bonne utilisation de Mineshop !
                        </p>
                    <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>