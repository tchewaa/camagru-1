<?php
use Core\Helper;
?>
<?php $this->start('body'); ?>
<h1 class="welcomeHeader">Welcome to Camagru</h1>
<div class="gallery">
    <?=Helper::displayGalleryImages($this->images, $this->page, $this->pageCount) ?>
</div>
<?php $this->end(); ?>
