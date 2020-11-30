<?php $this->setSiteTitle("Profile"); ?>
<?php $this->start('body'); ?>
    <div class="col-md-4 col-md-offset-4 jumbotron">
        <div class="text-center">
            <a href="<?=PROOT?>profile/updateUsername"><h5>Update Username</h5></a>
            <a href="<?=PROOT?>profile/updateEmail"><h5>Update Email</h5></a>
            <a href="<?=PROOT?>profile/updatePassword"><h5>Update Password</h5></a>
            <a href="<?=PROOT?>profile/deleteAccount"><h5>Delete Account</h5></a>
        </div>
    </div>
<?php $this->end(); ?>