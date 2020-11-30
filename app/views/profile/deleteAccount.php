<?php
use Core\FormHelper;
?>
<?php $this->setSiteTitle("Delete Account"); ?>
<?php $this->start('body'); ?>
    <div class="col-md-4 col-md-offset-4 jumbotron">
        <h3 class="text-center">Delete Account</h3>
        <form class="form" action="" method="post">
            <?= FormHelper::csrfInput() ?>
            <?= FormHelper::displayValidationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
            <?= FormHelper::inputBlock('password','Password','password',"",['class'=>'form-control'],['class'=>'form-group']) ?>
            <?= FormHelper::submitBlock('Delete', ['class'=>'btn btn-large btn-primary'],['class'=>'form-group'])?>
            <div class="text-center">
                <a href="<?=PROOT?>profile/index"><h5>Go back</h5></a>
            </div>
        </form>
    </div>
<?php $this->end(); ?>