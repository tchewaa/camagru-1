<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
    <div class="col-md-6 col-md-offset-3 well">
        <h3 class="text-center">Forgot Password?</h3>
        <form class="form" action="" method="post">
            <?= FormHelper::csrfInput() ?>
            <?= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
            <?= FormHelper::inputBlock('email','Email','email',"",['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
            <?= FormHelper::submitBlock('Send', ['class'=>'btn btn-large btn-primary'],['class'=>'form-group'])?>
        </form>
    </div>
<?php $this->end(); ?>