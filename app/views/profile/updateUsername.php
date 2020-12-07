<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-4 col-md-offset-4 jumbotron">
    <h3 class="text-center">Update Username</h3>
    <form class="form" action="<?=PROOT?>profile/updateUsername" method="post">
        <?= FormHelper::csrfInput() ?>
        <?= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
        <?= FormHelper::inputBlock('text','Username','username',"",['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
        <?= FormHelper::submitBlock('Update',['class'=>'btn btn-primary btn-large'],['class'=>'form-group']) ?>
        <div class="text-center">
            <a href="<?=PROOT?>profile/index"><h5>Go back</h5></a>
        </div>
    </form>
</div>
<?php $this->end(); ?>
