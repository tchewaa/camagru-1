<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-4 col-md-offset-4 jumbotron">
    <h3 class="text-center">Update Profile Details</h3><hr>
    <form class="form" action="" method="post">
        <?= FormHelper::csrfInput() ?>
<!--        --><?//= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
        <?= FormHelper::inputBlock('text','Username','username',"",['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
        <?= FormHelper::submitBlock('Update',['class'=>'btn btn-primary btn-large'],['class'=>'form-group']) ?>
        <div class="pull-left">
            <a href="<?=PROOT?>profile/updatePassword"><h5>Update Password</h5></a>
        </div>
        <div class="pull-right">
            <a href="<?=PROOT?>profile/updateEmail"><h5>Update Email Address</h5></a>
        </div>
    </form>
</div>
<?php $this->end(); ?>
