<?php
use Core\Helper;
?>
<?php $this->setSiteTitle("Camagru | Upload or take a picture"); ?>
<?php $this->start('body'); ?>
    <div class="row jumbotron" id="gallery">
        <?= Helper::validationMessage((isset($this->validationMessages) ? $this->validationMessages : '')) ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <video id="video">Stream not available</video>
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-dark" id="photo-button">Take Photo</button>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <form id="upload-form" action="<?=PROOT?>editor/upload" method="post" enctype="multipart/form-data" name="imageUpload">
                            <input id="image-upload" name="image-upload" type="file"/>
                            <input class="btn btn-dark" value="upload" type="submit"/>
                        </form>  
                    </div>
                </div>
                <canvas id="canvas"></canvas>
                <!--TODO do I need this-->
                <div id="photos"></div>
                <div id="stickers" class="hide">
                    <input type="checkbox" name="sticker-menu" id="sticker" value="1.png">
                    <label for="sticker1" id="sticker-1">
                        <img src="<?=PROOT?>app/assets/stickers/1.png" width="100px" height="100px"  alt="sticker 1">
                    </label>
                    <input type="checkbox" name="sticker-menu" id="sticker" value="2.png">
                    <label for="sticker2" id="sticker-2">
                        <img src="<?=PROOT?>app/assets/stickers/2.png" width="100px" height="100px"  alt="sticker 2">
                    </label>
                    <input type="checkbox" name="sticker-menu" id="sticker" value="3.png">
                    <label for="sticker3" id="sticker-3">
                        <img src="<?=PROOT?>app/assets/stickers/3.png" width="100px" height="100px"  alt="sticker 3">
                    </label>
                    <input type="checkbox" name="sticker-menu" id="sticker" value="4.png">
                    <label for="sticker4" id="sticker-4">
                        <img src="<?=PROOT?>app/assets/stickers/4.png" width="100px" height="100px"  alt="sticker 4">
                    </label>
                </div>
                <button class="btn btn-dark hide" id="save-button">Save</button>
                <button class="btn btn-dark hide" id="clear-button">Clear</button>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= Helper::displayImages($this->userImages); ?>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="<?=PROOT?>js/editor.js"></script>
<?php $this->end(); ?>