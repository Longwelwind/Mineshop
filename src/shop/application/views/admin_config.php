<h2>Configuration</h2>
<div class="row">
    <div class="col-md-12 module">
        <form method="post" role="form">
            <h3>Configuration de la boutique</h3>
            <div class="form-group">
                <label>Titre de la boutique:</label>
                <input class="form-control" name="shop_title" value="<?php echo $this->configmanager->getConfig("shop_title"); ?>" />
            </div>
            <div class="form-group">
                <label>Url du titre de la boutique:</label>
                <input class="form-control" name="shop_title_link" value="<?php echo $this->configmanager->getConfig("shop_title_link"); ?>" />
            </div>
            <div class="form-group">
                <label>Url du logo:</label>
                <input class="form-control" name="shop_logo" value="<?php echo $this->configmanager->getConfig("shop_logo"); ?>" />
            </div>
            <div class="form-group">
                <label>Description de la boutique</label>
                <textarea name="home_page" class="form-control" rows="4"><?php echo $this->configmanager->getConfig("home_page"); ?></textarea>
            </div>
            
            <h3>Configuration technique</h3>
            <div class="form-group">
                <label>Url du serveur de mise à jour:</label>
                <input class="form-control" name="update_server_host" value="<?php echo $this->configmanager->getConfig("update_server_host"); ?>" />
            </div>
            <button type="submit" class="btn btn-default">Modifier</button>
        </form>
    </div>
</div>