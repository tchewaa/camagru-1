<?php
use Core\Helper;
?>
<?php $this->start('body'); ?>
<div class="gallery">
    <?=Helper::displayGalleryImages($this->images, $this->page, $this->pageCount) ?>
</div>
<?php $this->end(); ?>
