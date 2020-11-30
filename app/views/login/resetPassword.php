<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-4 col-md-offset-4 jumbotron">
    <h3 class="text-center">Reset Password</h3>
    <form class="form" action="" method="post">
        <?= FormHelper::csrfInput() ?>
        <?= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
        <?= FormHelper::inputBlock('password','Password','password',"",['class'=>'form-control'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('password','Confirm Password','confirmPassword',"",['class'=>'form-control'],['class'=>'form-group']) ?>
        <?= FormHelper::submitBlock('Update', ['class'=>'btn btn-large btn-primary'],['class'=>'form-group'])?>
    </form>
</div>
<?php $this->end(); ?>
