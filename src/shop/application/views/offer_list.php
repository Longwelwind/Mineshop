<h2>Boutique</h2>
<div class="row">
    <div class="col-md-12">
        <ul style="margin-left: 10px;margin-right: 15px;margin-bottom: 0px;" class="nav nav-tabs" id="offer-tab">
            <?php $first = true; $c = 1; foreach ($categories_list AS $category) { ?>
                <li <?php if ($first) { ?>class="active"<?php } ?>><a href="#tab<?php echo $c; ?>" data-toggle="tab"><?php echo $category->category_name; ?></a></li>
            <?php $first = false; $c++; } ?>
        </ul>
        <div style="padding-top: 10px;margin-top: -1px;" class="tab-content module">
            <?php $first = true; $c = 1; foreach($categories_list AS $category) { ?>
                <div id="tab<?php echo $c; ?>" class="tab-pane<?php if ($first) { ?> active<?php } ?>">
                    <p><?php echo $category ?></p>
                    <table class="table table-bordered table-stripped table-condensed">
                        <tr>
                            <th>Offre</th>
                            <th>Prix</th>
                            <th width="55px"></th>
                        </tr>
                        <?php foreach ($category->offers_list AS $offer) { ?>
                            <tr>
                                <td><?php echo $offer->offer_name; ?></td>
                                <td><?php echo $offer->offer_price; ?> <img src="<?php echo base_url(); ?>img/coin.png">
                                  <?php if ($offer->offer_time_required > 0) { ?>(requiert <?php echo $offer->offer_time_required/(3600*24); ?> jours d'anciennetés)<?php } ?></td>
                                <td><a class="btn btn-info" href="<?php echo site_url("offer/show/" . $offer->offer_id); ?>">Voir</a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php $first = false; $c++; } ?>
        </div>
    </div>
</div>