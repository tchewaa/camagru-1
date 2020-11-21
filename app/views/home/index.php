<?php $this->start('body'); ?>
<h1 class="test">Welcome to Camagru</h1>
<div class="gallery">
    <?php
        foreach($this->images as $image) {
            echo '<a href="http://localhost/camagru/home/article/'.$image->id.'"><img src="'. $image->image_data .'" class="images" id="'. $image->id .'"></a>';
        }
    ?>
</div>
<?php $this->end(); ?>
