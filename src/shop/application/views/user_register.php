<h2 class="col-md-offset-2">Inscription</h2>
<div class="row">
    <div class='col-md-offset-2 col-md-8 module'>
        <form method='post' class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-4">Pseudo:</label>
                <div class="col-md-6">
                    <input name="nickname" class="form-control">
                    <span class="help-block">Celui-ci doit être le même que votre pseudo Minecraft.net</span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Mot de passe:</label>
                <div class="col-md-6">
                    <input type="password" name="password" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Confirmation du mot de passe:</label>
                <div class="col-md-6">
                    <input type="password" name="passwordBis" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Email:</label>
                <div class="col-md-6">
                    <input name="email" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label style="text-align:center;" class="control-label col-md-4">
                    Etes-vous un robot ?<br />
                    <img style="border: 1px grey solid;padding: 2px;border-radius: 4px 4px;" id="captcha" src="<?php echo base_url(); ?>libraries/securimage/securimage_show.php" alt="CAPTCHA Image" />
                </label>
                <div class="col-md-3" style="padding-top: 50px;">
                    <input name="captcha_code" maxlength="6" class="form-control">
                    <a style="font-size: 10px;" href="#" onclick="document.getElementById('captcha').src = '<?php echo base_url(); ?>libraries/securimage/securimage_show.php?' + Math.random(); return false">
                        Autre image ?
                    </a>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-8 col-md-offset-4">
                    <input type="submit" class="btn btn-default">
                </div>
            </div>
        </form>
    </div>
</div>