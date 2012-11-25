<h1>Statistiques</h1>
<hr />
<img src="<?php echo base_url(); ?>img/global_chart.png" />
<table style="width: 100%;">
  <tr style="vertical-align: top;">
    <td style="width: 50%;">
      <div class="box">
        <div class="box_title">Les offres de payements les plus utilisés</div><br />
        <table class="datatable" style="width: 100%;">
          <tr>
            <th>Nom</th>
            <th>Nombre de fois utilisés</th>
          </tr>
          <?php
          foreach($payements_list AS $payement) {
            ?>
            <tr>
              <td><?php echo $payement->payement_name; ?></td>
              <td><?php echo $payement->number_used; ?></td>
            </tr>
            <?php
          }
          ?>
        </table>
      </div>
    </td>
    <td>
      <div class="box">
        <div class="box_title">Les offres d'achats qui vous ont rapportés</div><br />
        <table class="datatable" style="width: 100%;">
          <tr>
            <th>Nom</th>
            <th>Tokens gagnés</th>
          </tr>
          <?php
          foreach($offers_list AS $offer) {
            ?>
            <tr>
              <td><?php echo $offer->offer_name; ?></td>
              <td><?php echo $offer->tokens_won; ?> <img src="<?php echo base_url(); ?>img/coin.png"></td>
            </tr>
            <?php
          }
          ?>
        </table>
      </div>
    </td>
  </tr>
</table>