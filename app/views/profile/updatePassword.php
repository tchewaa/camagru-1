<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-4 col-md-offset-4 jumbotron">
    <h3 class="text-center">Update Password</h3>
    <form class="form" action="" method="post">
        <?= FormHelper::csrfInput() ?>
        <?= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
        <?= FormHelper::inputBlock('password','Current Password','password',"",['class'=>'form-control'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('password','New Password','new_password',"",['class'=>'form-control'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('password','Confirm Password','confirm_password',"",['class'=>'form-control'],['class'=>'form-group']) ?>
        <?= FormHelper::submitBlock('Update', ['class'=>'btn btn-large btn-primary'],['class'=>'form-group'])?>
        <div class="text-center">
            <a href="<?=PROOT?>profile/updateUsername"><h5>Update Username</h5></a>
            <a href="<?=PROOT?>profile/updateEmail"><h5>Update Email Address</h5></a>
        </div>
    </form>
</div>
<?php $this->end(); ?>
