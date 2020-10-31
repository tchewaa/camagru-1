<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <form class="form" action="<?=PROOT?>register/login" method="post">
                <?= FormHelper::csrfInput()?>
                <div class="bg-danger"><?=$this->displayErrors ?></div>
                <!--                <h3 class="text-center">Login</h3>-->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="remember_me">Remember Me
                        <input type="checkbox" id="remember_me" name="remember_me" value="on">
                    </label>
                </div>
                <div class="form-group">
                    <input type="submit" value="Login" class="btn btn-large">
                </div>
                <div class="text-right">
                    <a href="<?=PROOT?>/register/register" class="text-primary">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->end(); ?>




