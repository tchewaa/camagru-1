<?php
use Core\Helper;
?>
<?php $this->setSiteTitle("Camagru"); ?>
<?php $this->start('body'); ?>
<div class="gallery">
    <?=Helper::displayGalleryImages($this->images, $this->page, $this->pageCount) ?>
</div>
<?php $this->end(); ?>
