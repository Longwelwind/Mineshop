<h2>Gestion des offres </h2>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Ajouter une catégorie</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post" action="<?php echo site_url("admin/create_category"); ?>">
                    <div class="form-group">
                        <label class="control-label col-md-3">Nom</label>
                        <div class="col-md-9">
                            <input class="form-control" name="category_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-offset-2">Description</label>
                        <textarea class="form-control" name="category_description"></textarea>
                       
                    </div>
                    <button class="btn btn-default" type="submit">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Ajouter une offre</h3>
            </div>
            <div class="panel-body">
                <form method="post" class="form-horizontal" action="<?php echo site_url("admin/create_offer"); ?>">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Nom</label>
                        <div class="col-md-8">
                            <input class="form-control" name="offer_name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Prix</label>
                        <div class="col-md-8">
                            <input class="form-control" name="offer_price" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Catégorie</label>
                        <div class="col-md-8">
                            <select class="form-control" name="offer_category_id">
                                <?php foreach($categoriesList AS $categoryBis) { ?>
                                    <option value="<?php echo $categoryBis->category_id; ?>"><?php echo $categoryBis->category_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Offre requise</label>
                        <div class="col-md-8">
                            <select class="form-control" name="offer_offer_required">
                                <option value="0">Aucun</option>
                                <?php foreach($allOffers AS $offerBis) { ?>
                                    <option value="<?php echo $offerBis->offer_id; ?>"><?php echo $offerBis->offer_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Achat Unique</label>
                        <div class="col-md-8">
                            <input type="checkbox" name="offer_is_unique" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-default" >Créer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Offres</h3>
            </div>
            <div class="panel-body">
                <?php foreach($categoriesList as $category) { ?>
                    <div>
                        <h3><?php echo $category->category_name; ?></h3>
                        <div>
                            <form style="display:inline;" method="post" action="<?php echo site_url("admin/update_category/" . $category->category_id); ?>">
                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea class="form-control" rows="7" cols="80" name="category_description"><?php echo $category->category_description; ?></textarea>
                                </div>
                                <button class="btn btn-default" type="submit">Modifier</button>
                            </form>
                            <form style="display:inline;" method="post" onSubmit="return (confirm('Êtes vous-sur de vouloir supprimer cette catégorie (Ainsi que toutes les offres qui y sont contenue) ?'))" action="<?php echo site_url("admin/delete_category"); ?>">
                                <input type="hidden" name="category_id" value="<?php echo $category->category_id; ?>"><button class="btn btn-danger" type="submit">Supprimer</button>
                            </form>
                        </div>
                        <div>
                            <table class="table table-stripped table-condensed table-bordered table-centered">
                                <tr>
                                    <th>Nom de l'offre</th>
                                    <th>Prix</th>
                                    <th>Ancienneté req</th>
                                    <th>Offre requise</th>
                                    <th>Catégorie</th>
                                    <th>Unique</th>
                                    <th>Ordre</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <?php foreach ($category->elements AS $offer) { ?>
                                    <form method="post">
                                        <tr>
                                            <td><input name="offer_name" value="<?php echo $offer->offer_name; ?>" class="form-control"></td>
                                            <td><input name="offer_price" value="<?php echo $offer->offer_price; ?>" class="form-control"></td>
                                            <td><input name="offer_time_required" value="<?php echo $offer->offer_time_required; ?>" class="form-control"></td>
                                            <td>
                                                <select name="offer_offer_required" class="form-control">
                                                    <option value="0">Aucun</option>
                                                    <?php foreach($allOffers AS $offerBis) { ?>
                                                        <option <?php if ($offerBis->offer_id == $offer->offer_offer_required) {?>selected<?php } ?> value="<?php echo $offerBis->offer_id; ?>"><?php echo $offerBis->offer_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="offer_category_id">
                                                    <?php foreach($categoriesList AS $categoryBis) { ?>
                                                        <option <?php if ($categoryBis->category_id == $offer->offer_category_id) {?>selected<?php } ?> value="<?php echo $categoryBis->category_id; ?>"><?php echo $categoryBis->category_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td><input type="hidden" name="offer_is_unique_present" value="1"><input type="checkbox" name="offer_is_unique" <?php if ($offer->offer_is_unique) { ?>checked<?php } ?>></td>
                                            <td><input name="offer_order" value="<?php echo $offer->offer_order; ?>" class="form-control"></td>
                                            <td><input type="hidden" name="offer_id" value="<?php echo $offer->offer_id; ?>"><button class="btn btn-default" type="submit">Modifier</button></td>
                                  </form>
                                            <td>
                                                <form onSubmit="return (confirm('Êtes vous-sur de vouloir supprimer cette offre ?'))" action="<?php echo site_url("admin/delete_offer"); ?>" method="post">
                                                    <input type="hidden" name="offer_id" value="<?php echo $offer->offer_id; ?>"><button class="btn btn-danger" type="submit">Supprimer</button>
                                                </form>
                                            </td>
                                            <td><a class="btn btn-info" href="<?php echo site_url("admin/elements_list/" . $offer->offer_id); ?>">Voir</a></td>
                                        </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>