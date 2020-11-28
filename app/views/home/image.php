<?php

use Core\FormHelper;
use Core\Helper;
?>
<?php $this->start('body'); ?>
    <div class="row polaroid">
        <div class="col-lg-9 col-lg-offset-3 user-image">
            <img src="<?=$this->image->image_data?>" alt="article image">
        </div>
        <div class="col-lg-4 col-lg-offset-3 image-meta-data">
            <p>Author: <?=$this->image->username?></p>
            <p>Timestamp: <?=$this->image->date?></p>
            <button type="button" class="btn btn-default" id="like-button" value="<?=$this->image->id?>">
                <?php
                    if ($this->imageLiked) {
                        echo "unlike";
                    } else {
                        echo "like";
                    }
                ?>
            </button>
        </div>
        <div class="col-lg-4 col-lg-offset-3 comment-area">
            <?= FormHelper::csrfInput() ?>
            <form class="form" action="<?=PROOT?>home/comment" method="post">
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea class="form-control" id="comment-text" name="comment-text" rows="4" cols="50"></textarea>
                </div>
                <button type="button" class="btn btn-default pull-left" id="comment-button" value="<?=$this->image->id?>">Submit</button>
            </form>
        </div>
        <div class="col-lg-4 col-lg-offset-3 comments">
            <?=Helper::displayComments($this->comments) ?>
        </div>
    </div>
    <div class="row">

    </div>
    <script type="text/javascript" src="<?=PROOT?>js/main.js"></script>
<?php $this->end(); ?>