<h2>Acheter des tokens</h2>
<?php foreach ($list_payements AS $type) { ?>
    <?php if (count($type["payements"]) > 0) { ?>
        <div style="margin-bottom: 10px;">
            <h3 style="display:inline;"><?php echo $type["name"]; ?></h3>
            <i><?php echo $type["description"]; ?></i>
        </div>
        <?php $c = 0; foreach ($type["payements"] AS $payement) { ?>
            <?php if (($c % 6) == 0) { ?><div class="row"><?php } ?>
                <div class="col-md-2">
                    <ul class="list-group">
                        <li class="list-group-item"><?php echo $payement->payement_name; ?></li>
                        <li class="list-group-item"><?php echo $payement->payement_token_reward; ?> tokens</li>
                        <li class="list-group-item" style="text-align: center;"><a href="<?php echo site_url("payement/pay/" . $payement->payement_id . "/"); ?>" class="btn btn-info btn-lg">Voir</a></li>
                    </ul>
                </div>
            <?php if (($c % 6) == 5) { ?></div><?php } ?>
        <?php $c++; } ?>
    <?php } ?>
<?php } ?>
