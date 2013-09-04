<?php
// Cette page envoie la prochaine version depuis le param�tre $_GET["version"].
// On lit chaque entr�e de version.txt jusqu'� tomber sur notre version.
$file = fopen('versions.txt', 'r');
if ($file) {
  $count_version = 0;
  $new_version = false;
  $next_version = "";
  $last_version = "";
  while (!feof($file)) {
    $line = str_replace(array("\n", "\r"), "", fgets($file));
    $count_version++;
    
    if ($line == $_GET["version"]) {
      // On est sur la bonne ligne, on regarde si on peut aller une ligne plus loin.
      if (!feof($file)) {
        // Il existe une version apr�s celle l� !
        $next_version = str_replace(array("\n", "\r"), "", fgets($file));
        $new_version = true;
        // On remet le compteur � 0
        $count_version = 0;
        // Si maintenant c'est la derni�re version, on la met
        if (feof($file)) {
          // Si c'est la derni�re version, on met quelques infos
          $last_version = $next_version;
        }
      } else {
        // Il n'existe pas de version apr�s celle l�, il est dans sa derni�re version.
        echo "LAST_VERSION";
        exit();
      }
    }
    if ($last_version == "" and feof($file)) {
      // Si c'est la derni�re version, on met quelques infos
      $last_version = $line;
    }
  }
  
  if ($new_version) {
    // NEW_VERSION Prochaine_Version Nombre_Versions Last_Version
    echo "NEW_VERSION " . $next_version . " " . $count_version . " " . $last_version;
  } else {
    // Si on a pas r�ussi � trouver sa version, c'est qu'elle est inconnue.
    echo "UNKNOWN_VERSION";
  }
}
?>