<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-4 col-md-offset-4 jumbotron">
    <h3 class="text-center">Update Email</h3>
    <form class="form" action="" method="post">
        <?= FormHelper::csrfInput() ?>
        <?= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
        <?= FormHelper::inputBlock('email','Email','email',"",['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
        <?= FormHelper::checkboxBlock('Notification','notification',$this->user->getNotificationChecked(),['class'=>'form-group']) ?>
        <?= FormHelper::submitBlock('Update', ['class'=>'btn btn-large btn-primary'],['class'=>'form-group'])?>
        <div class="text-center">
            <a href="<?=PROOT?>profile/index"><h5>Go back</h5></a>
        </div>
    </form>
</div>
<?php $this->end(); ?>
