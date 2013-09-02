<h1>Gestion des utilisateurs</h1>
<hr />
<?php
if (isset($goodError)) { ?>
  <div class="gooderrorbox returnbox"><span><?php echo $goodError; ?></span></div>
  <?php
}
?>
<form method="post" action="">
  Recherche: <input name="searchName">
  <input type="submit">
</form>
<table class="datatable" style="width: 100%;">
  <tr>
    <th>Nom</th>
    <th>Tokens</th>
    <th>Email</th>
    <th>Ancienneté</th>
    <th>Admin</th>
    <th>#</th>
    <th>#</th>
  </tr>
<?php
foreach ($usersList AS $user) {
  ?>
  <tr>
    <form action="<?php echo site_url("admin/user_update/" . $user->user_id); ?>" method="POST">
    <td><input name="user_name" value="<?php echo htmlspecialchars($user->user_name); ?>"></td>
    <td><input name="user_count_tokens" value="<?php echo $user->user_count_tokens; ?>" style="width: 50px;"> <img src="<?php echo base_url(); ?>img/coin.png"></td>
    <td><input name="user_email" value="<?php echo htmlspecialchars($user->user_email); ?>"></td>
    <td><input name="user_register_time" value="<?php echo $user->user_register_time; ?>"></td>
    <td><input name="user_is_admin" type="checkbox" <?php if ($user->user_is_admin) { ?>checked="checked"<?php }  ?>></td>
    <td><input class="button" type="submit"></td>
    <td><a class="button" href="<?php echo site_url("user/profile/" . $user->user_name); ?>">Profil</a></td>
    </form>
  </tr>
  <?php
}
?>
</table>