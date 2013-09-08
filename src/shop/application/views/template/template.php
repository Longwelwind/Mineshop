<?php
if ($this->usermanager->isAuthenticated())
  $userdata = $this->usermanager->getActualUserdata();
if ($this->usermanager->isAuthenticated() and $userdata->user_is_admin) {
    $next_version = $this->version_model->getNextVersionData();
    if ($next_version[0] == "NEW_VERSION") {
        $warningError = "Hurray ! Mineshop <strong>v" . $next_version[1] . "</strong> est sortie ! Mettez vous à jour le plus vite: 
            <a href=\"" . site_url("admin/version/" . $next_version[1]) . "\">Installez la v" . $next_version[1] . "</a>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title><?php echo $this->configmanager->getConfig("shop_title"); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url(); ?>libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url(); ?>style.css" rel="stylesheet" media="screen">
    <!-- Load Bootstrap's theme -->
    <link href="<?php echo base_url(); ?>libraries/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>libraries/font-awesome/css/font-awesome.min.css">
    <style>
    body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
    }
    </style>
  </head>
  <body>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="<?php echo base_url(); ?>libraries/bootstrap/js/bootstrap.min.js"></script>
    <nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo $this->configmanager->getConfig("shop_title_link"); ?>"><?php echo $this->configmanager->getConfig("shop_title"); ?></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo site_url("offer"); ?>"><i class="icon-shopping-cart"></i>Offres</a></li>
                <?php if ($this->usermanager->isAuthenticated() && $userdata->user_is_admin) { ?>
                    <li class="dropdown">
                        <a id="admin-menu" style="color: #b94a48" data-toggle="dropdown" href="<?php echo site_url("admin"); ?>"><i class="icon-minus-sign"></i>Administration <i class="icon-caret-down"></i></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="admin-menu">
                            <li><a href="<?php echo site_url("admin/users_list") ?>"><i class="icon-user"></i>Utilisateurs</a></li>
                            <li><a href="<?php echo site_url("admin/offers_list") ?>"><i class="icon-shopping-cart"></i>Offres</a></li>
                            <li><a href="<?php echo site_url("admin/servers_list") ?>"><i class="icon-hdd"></i>Serveurs</a></li>
                            <li><a href="<?php echo site_url("admin/payements_list") ?>"><i class="icon-briefcase"></i>Paiements</a></li>
                            <li><a href="<?php echo site_url("admin/stats") ?>"><i class="icon-bullhorn"></i>Statistiques</a></li>
                            <li><a href="<?php echo site_url("admin/configuration") ?>"><i class="icon-wrench"></i>Configuration</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <div class="pull-right">
                <?php if (!$this->usermanager->isAuthenticated()) { ?>
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo site_url("user/authenticate"); ?>">Se connecter</a></li>
                        <li><a href="<?php echo site_url("user/register"); ?>">S'inscrire</a></li>
                    </ul>
                <?php } else { ?>
                    <ul  class="nav navbar-nav">
                        <li><a href="#"><?php echo $userdata->user_count_tokens; ?> tokens</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle " id="user-menu" data-toggle="dropdown" href="#"><?php echo $userdata->user_name; ?> <i class="icon-caret-down"></i></b></a>
                            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="user-menu">
                                <li><a href="<?php echo site_url("user/profile/" . $userdata->user_name); ?>"><i class="icon-user"></i>Profil</a></li>
                                <li><a href="<?php echo site_url("payement"); ?>"><i class="icon-briefcase"></i>Acheter des tokens</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url("user/deco"); ?>"><i class="icon-off"></i>Se déconnecter</a></li>
                            </ul>
                        </li>

                    </ul>
                <?php } ?>
            </div>
        </div>
        
    </nav>
    <div class="container">
        <div class="row"  style="height:50px">
            <div class="col-md-5">
               <img src="<?php echo $this->configmanager->getConfig("shop_logo"); ?>" />
            </div>
            <div class="col-md-7">
                <?php if (isset($goodError)) { ?>
                    <div class="alert alert-success"><i class="icon-ok icon-large"></i> <span><?php echo $goodError; ?></span></div>
                <?php } else if (isset($error)) { ?>
                    <div class="alert alert-danger"><i class="icon-remove icon-large"></i> <span><?php echo $error; ?></span></div>
                <?php } else if (isset($warningError)) { ?>
                    <div class="alert alert-warning"><i class="icon-warning icon-large"></i> <span><?php echo $warningError; ?></span></div>
                <?php } ?>
            </div>
        </div>
        <?php echo $include; ?>
    </div>
    
  </body>
</html>