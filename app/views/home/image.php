<?php
use Core\Helper;
?>
<?php $this->start('body'); ?>
    <div class="row polaroid">
<!--        <h1 class="welcomeHeader">ImageID </h1>-->
        <div class="col-lg-9 col-lg-offset-3 user-image">
            <img src="<?=$this->image->image_data?>" alt="article image">
        </div>
        <div class="col-lg-4 col-lg-offset-3 image-meta-data">
            <p>Author: test1 </p>
            <p>Timestamp: 20 November 2020</p>
            <button type="button" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-thumbs-up"></span> Like
            </button>
        </div>
        <div class="col-lg-4 col-lg-offset-3 comment-area">
            <form class="form" action="<?=PROOT?>home/comment" method="post">
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea class="form-control" id="comment-text" name="comment" rows="4" cols="50"></textarea>
                </div>
                <div class="pull-left">
                    <input type="submit" class="btn btn-primary btn-large" value="Submit">
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-lg-offset-3 comments">
            <small>Comment by: test1</small>
            <small>Timestamp: 20 November 2020</small>
            <p>
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s
                with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing.
            </p>
            <small>Comment by: test1</small>
            <small>Timestamp: 20 November 2020</small>
            <p>
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s
                with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing.
            </p>
        </div>
    </div>
    <div class="row">

    </div>
<?php $this->end(); ?>