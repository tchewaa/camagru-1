<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-4 col-md-offset-4 jumbotron">
    <h3 class="text-center">Resend Verification Token</h3>
    <form class="form" action="<?=PROOT?>register/resendToken" method="post">
        <?= FormHelper::csrfInput() ?>
        <?= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
        <?= FormHelper::inputBlock('email','Email','email',"",['class'=>'form-control input-sm'],['class'=>'form-group']) ?>
        <?= FormHelper::submitBlock('Send', ['class'=>'btn btn-primary btn-large', 'id' => 'resend-btn'],['class'=>'form-group'])?>
    </form>
</div>
<?php $this->end(); ?>
