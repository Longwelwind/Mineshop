<h2>Installer une version</h2>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Comment installer une nouvelle version ?</h3>
            </div>
            <div class="panel-body">
                Mettre à jour votre installation est Mineshop est vitale pour maintenir la sécurité de celui-ci. De plus, ces mises à jours vous apporteront de nouvelles fonctionnalités pour votre boutique.
                <ul>
                    <li>La liste complète des changements est disponible ci-dessous, elle vous informe aussi d'une possible procédure à faire si jamais cela s'avère nécéssaire.</li>
                    <li>Par ailleurs, il se peut qu'un script de modification de base de données doivent être appliqué. Si une telle procédure est à faire, un encadré à droite vous expliquera la démarche.</i>
                    <li>Si tout est terminé, vous pouvez télécharger la nouvelle version via le bouton ci-dessous et uploader le contenu de l'archive téléchargé sur votre serveur web (En précisant d'écraser les fichiers déjà existants)</li>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php if ($this->version_model->hasADatabaseScript($version)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Modification de base de données</h3>
                </div>
                <div class="panel-body">
                    Cette version contient une modification de script de base de données, c'est à dire qu'avant d'installer cette version, vous devez éxécuter ce script.<br />
                    Il ne peut être executé qu'une fois et il est conseillé de le faire juste avant d'uploader la nouvelle version sur votre serveur web pour éviter tout risque d'erreur.
                    <div style="text-align: center;">
                        <a href="<?php echo site_url("admin/apply_script/" . $version); ?>" class='btn btn-warning btn-lg'>Appliquer</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Changelog</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <?php foreach ($changelog as $change) { ?>
                        <li><?php echo $change; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Télécharger</h3>
                </div>
                <div class="panel-body text-centered">
                    <a class="btn btn-default btn-lg" href="<?php echo $this->version_model->getDownloadLink($version); ?>">Télécharger</a>
                </div>
            </div>
        </div>
</div>