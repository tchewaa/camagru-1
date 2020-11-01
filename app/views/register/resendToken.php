<?php
use Core\FormHelper;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="col-md-6 col-md-offset-3 well">
    <h3 class="text-center">Resend Verification Token</h3>
    <form class="form" action="<?=PROOT?>register/resendToken" method="post">
        <?= FormHelper::csrfInput() ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control input-sm" type="email" id="email" name="email" />
        </div>
        <?= FormHelper::submitBlock('Resend', ['class'=>'btn btn-large btn-primary'],['class'=>'form-group'])?>
    </form>
</div>
<?php $this->end(); ?>
