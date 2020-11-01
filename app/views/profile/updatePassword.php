<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-6 col-md-offset-3 well">
    <h3 class="text-center">Update Password</h3>
    <form class="form" action="" method="post">
        <?= FormHelper::csrfInput() ?>
        <!--        FormHelper::displayErrors($this->displayErrors)-->
        <?= FormHelper::inputBlock('password','Current Password','password',"",['class'=>'form-control'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('password','New Password','password',"",['class'=>'form-control'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('password','Confirm Password','confirm_password',"",['class'=>'form-control'],['class'=>'form-group']) ?>
        <?= FormHelper::submitBlock('Update', ['class'=>'btn btn-large btn-primary'],['class'=>'form-group'])?>
    </form>
</div>
<?php $this->end(); ?>
