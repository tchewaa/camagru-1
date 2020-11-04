<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-4 col-md-offset-4 jumbotron">
    <h3 class="text-center">Log In</h3>
    <form class="form" action="" method="post">
        <?= FormHelper::csrfInput() ?>
        <?= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
        <?= FormHelper::inputBlock('text','Username','username',$this->auth->username,['class'=>'form-control'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('password','Password','password',$this->auth->password,['class'=>'form-control'],['class'=>'form-group']) ?>
        <?= FormHelper::checkboxBlock('Remember Me','remember_me',$this->auth->getRememberMeChecked(),[],['class'=>'form-group']) ?>
        <?= FormHelper::submitBlock('Login', ['class'=>'btn btn-large btn-primary'],['class'=>'form-group'])?>
        <div class="text-right">
            <a href="<?=PROOT?>login/forgotPassword" class="text-primary">Forgot password?</a>
        </div>
    </form>
</div>
<?php $this->end(); ?>




