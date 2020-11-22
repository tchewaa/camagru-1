<?php
use Core\Helper;
?>
<?php $this->start('body'); ?>
<h1 class="test">Welcome to Camagru</h1>
<div class="gallery">
    <?=Helper::displayGalleryImages($this->images) ?>
    <ul class="pagination">
        <?php
            echo '<li><a href="http://localhost/camagru/home/index/1" class="pages" id="beginPages">Begin</a></li>';
//            echo '<li><a href="http://localhost/camagru/home/index/1" class="pages" id="beginPages">Test 1</a></li>';
            echo '<li><a href="http://localhost/camagru/home/index/1" class="pages" id="endPages">End</a></li>';
        ?>
    </ul>
</div>
<?php $this->end(); ?>
