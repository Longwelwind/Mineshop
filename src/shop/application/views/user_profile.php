<h2>Profil de <?php echo htmlspecialchars($userProfile->user_name); ?></h2>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Informations</h3>
            </div>
            <div class="panel-body">
                <b>Tokens:</b> <?php echo $userProfile->user_count_tokens; ?><br />
                <b>Création du compte:</b> <?php echo date("d/m/Y à G:i", $userProfile->user_register_time); ?><br />
                <b>Email:</b> <?php echo $userProfile->user_email; ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Historique de transaction</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th width="150px">Date d'achat</th>
                        <th width="150px">Dépense</th>
                        <th>Achat</th>
                    </tr>
                    <?php if (count($userProfile->transactionsHistory) > 0) {
                        foreach($userProfile->transactionsHistory AS $transaction) {
                            // On fait rapidos le truc pour avoir l'offre choisie
                            $offer = $this->offer_model->getOfferById($transaction->offer_id); ?>
                            <tr>
                              <td><?php echo date("d/m/Y à G:i", $transaction->offer_history_time); ?></td>
                              <td><?php echo $transaction->offer_history_price; ?> tokens</td>
                              <td><?php echo $offer->offer_name; ?></td>
                            </tr>
                        <?php }
                    } else {
                      ?>
                      <tr>
                        <td colspan="3"><div class="text-center">Aucune transaction</div></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>