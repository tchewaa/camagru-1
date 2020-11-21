<?php
use Core\Helper;
?>
<?php $this->start('body'); ?>
<h1 class="test">Welcome to Camagru</h1>
<div class="gallery">
    <?=Helper::displayGalleryImages($this->images) ?>
</div>
<?php $this->end(); ?>
