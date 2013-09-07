<h2>Configuration</h2>
<div class="row">
    <div class="col-md-12 module">
        <form method="post" role="form">
            <div class="form-group">
                <label>Titre de la boutique:</label>
                <input class="form-control" name="shop_title" value="<?php echo $this->configmanager->getConfig("shop_title"); ?>" />
            </div>
            <div class="form-group">
                <label>Url du titre de la boutique:</label>
                <input class="form-control" name="shop_title_link" value="<?php echo $this->configmanager->getConfig("shop_title_link"); ?>" />
            </div>
            <div class="form-group">
                <label>Description de la boutique</label>
                <textarea class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-default">Modifier</button>
        </form>
    </div>
</div>