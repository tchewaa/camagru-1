<?php
use Core\Helper;
?>
<?php $this->start('body'); ?>
<h1 class="test">Welcome to Camagru</h1>
<div class="gallery">
    <?=Helper::displayGalleryImages($this->images) ?>
    <ul class="pagination">
        <?php
            $count = $this->page > 1 ? $this->page - 1 : $this->page;
            $pages = [];
            while ($count <= $this->pageCount) {
                $pages[] = '<li><a href="http://localhost/camagru/home/index/'.$count.'" class="pages" id="pageNumber'.$count.'">'.$count.'</a></li>';
                $count++;
            }
//            if (count($pages) > 3) {
//                $pages = array_slice($pages, 0, 3);
//            }
            echo '<li><a href="http://localhost/camagru/home/index/1" class="pages" id="beginPages">Prev</a></li>';
            foreach ($pages as $page) {
                echo $page;
            }
            echo '<li><a href="http://localhost/camagru/home/index/1" class="pages" id="endPages">Next</a></li>';
        ?>
    </ul>
</div>
<?php $this->end(); ?>
