<h2>Statistiques</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Total tokens utilisés</h3>
            </div>
            <div class="panel-body" style="text-align: center;">
                <img src="<?php echo base_url(); ?>img/global_chart.png" />
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Offres de paiements les plus utilisés</h3>
            </div>
            <div class="panel-body">
                <table class="table table-stripped table-condensed table-bordered">
                    <tr>
                        <th>Nom</th>
                        <th>Nombre de fois utilisés</th>
                    </tr>
                    <?php if (count($payements_list) > 0) { ?>
                        <?php foreach($payements_list AS $payement) { ?>
                            <tr>
                                <td><?php echo $payement->payement_name; ?></td>
                                <td><?php echo $payement->number_used; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                            <tr><td style="text-align:center;" colspan="2">Aucune transaction</td></tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Offres d'achats qui ont le plus rapportés</h3>
            </div>
            <div class="panel-body">
                <table class="table table-stripped table-condensed table-bordered">
                    <tr>
                        <th>Nom</th>
                        <th>Tokens gagnés</th>
                    </tr>
                    <?php if (count($offers_list) > 0) { ?>
                        <?php foreach($offers_list AS $offer) { ?>
                            <tr>
                                <td><?php echo $offer->offer_name; ?></td>
                                <td><?php echo $offer->tokens_won; ?> <img src="<?php echo base_url(); ?>img/coin.png"></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                            <tr><td style="text-align:center;" colspan="2">Aucune transaction</td></tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>