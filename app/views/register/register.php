<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-4 col-md-offset-4 jumbotron">
    <h3 class="text-center">Register Here!</h3><hr>
    <form class="form" action="<?=PROOT?>register/register" method="post">
        <?= FormHelper::csrfInput() ?>
        <?= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
        <?= FormHelper::inputBlock('text','First Name','first_name',(isset($this->user) ? $this->user->first_name : ''),['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('text','Last Name','last_name',(isset($this->user) ? $this->user->last_name : ''),['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('email','Email','email',(isset($this->user) ? $this->user->email : ''),['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('text','Username','username',(isset($this->user) ? $this->user->username : ''),['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('password','Password','password',(isset($this->user) ? $this->user->last_name : ''),['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
        <?= FormHelper::inputBlock('password','Confirm Password','confirm',(isset($this->user) ? $this->user->getConfirm() : ''),['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
        <?= FormHelper::submitBlock('Register',['class'=>'btn btn-primary btn-large'],['class'=>'form-group']) ?>
        <div class="text-right">
            <a href="<?=PROOT?>register/resendToken">Resend Verification</a>
        </div>
    </form>
</div>
<?php $this->end(); ?>


