<h2><?php echo $offer->offer_name; ?></h2>
<div class="row">
    <div class="col-md-4 <?php if (empty($offer->offer_description)) { ?>col-md-offset-4<?php } ?>">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Que contient elle ?</h3>
            </div>
            <div class="panel-body">
                <ul class='list-group'>
                    <?php foreach ($offer->elements AS $element) { ?>
                        <li class="list-group-item"><?php echo $element->getExplainString(); ?></li>
                    <?php } ?>
                </ul>
                <div style="text-align: center;">
                    <?php if (isset($errorPay)) { ?>
                        <button class="btn btn-danger disabled"><?php echo $errorPay; ?></button>
                    <?php } else { ?>
                        <a class="btn btn-lg btn-success" href="<?php echo site_url("offer/buy/" . $offer->offer_id); ?>">ACHETER</a>
                    <?php } ?>
                </div>
           </div>
        </div>
    </div>
    <?php if (!empty($offer->offer_description)) { ?>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Description</h3>
                </div>
                <div class="panel-body">
                    
                </div>
            </div>
        </div>
    <?php } ?>
</div>