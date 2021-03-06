<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
    <div class="col-md-4 col-md-offset-4 jumbotron">
        <h3 class="text-center">Forgot Password?</h3>
        <form class="form" action="" method="post">
            <?= FormHelper::csrfInput() ?>
            <?= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
            <?= FormHelper::inputBlock('email','Email','email',"",['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
            <?= FormHelper::submitBlock('Send', ['class'=>'btn btn-large btn-primary', 'id' => 'forgot-pwd-btn'],['class'=>'form-group'])?>
        </form>
    </div>
<?php $this->end(); ?>