<?php $this->setSiteTitle('upload or take a pic'); ?>
<?php $this->start('body'); ?>
    <div class="row" id="gallery">
        <div class="col-md-8 jumbotron">
            <h3>Upload or Take a Picture</h3>
            <div class="row">
                <div class="col-md-6">
                    <h3>Editor</h3>
                    <video id="video">Stream not available</video>
                    <button class="btn btn-dark" id="photo-button">
                        Take Photo
                    </button>
                    <input name="image" id="image-upload" type="file"/>
<!--                    <select class="btn btn-dark" id="photo-filter" >-->
<!--                        <option value="none">Normal</option>-->
<!--                        <option value="grayscale(100%)">Grayscale</option>-->
<!--                        <option value="sepia(100%)">Sepia</option>-->
<!--                        <option value="invert(100%)">Invert</option>-->
<!--                        <option value="hue-rotate(90deg)">Hue</option>-->
<!--                        <option value="blur(10px)">Blur</option>-->
<!--                        <option value="contrast(200%)">Contrast</option>-->
<!--                    </select>-->
                    <div id="stickers">
                        <input type="checkbox" name="sticker-menu2" id="sticker1" value="">
                        <label for="sticker1">
                            <img src="<?=PROOT?>app/assets/stickers/580b57fcd9996e24bc43c319.png" width="100px" height="100px"  alt="sticker 1">
                        </label>
                        <input type="checkbox" name="sticker-menu2" id="sticker1" value="">
                        <label for="sticker2">
                            <img src="<?=PROOT?>app/assets/stickers/580b57fcd9996e24bc43c319.png" width="100px" height="100px"  alt="sticker 1">
                        </label>
                        <input type="checkbox" name="sticker-menu2" id="sticker1" value="">
                        <label for="sticker1">
                            <img src="<?=PROOT?>app/assets/stickers/580b57fcd9996e24bc43c319.png" width="100px" height="100px"  alt="sticker 1">
                        </label>
                        <input type="checkbox" name="sticker-menu2" id="sticker1" value="">
                        <label for="sticker2">
                            <img src="<?=PROOT?>app/assets/stickers/580b57fcd9996e24bc43c319.png" width="100px" height="100px"  alt="sticker 1">
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Captured Image</h3>
                    <canvas id="canvas"></canvas>
                    <button class="btn btn-dark" id="clear-button">Clear</button>
                    <!--TODO do I need this-->
                    <div id="photos"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 sidebar">
            <h3>Your images</h3>
            <div class="row">
                <div class="col-sm-6 thumbnail">
                    <img src="<?=PROOT?>app/assets/dummy/sanfran.jpg" class="img-rounded" alt="sanfran">
                </div>
                <div class="col-sm-6 thumbnail">
                    <img src="<?=PROOT?>app/assets/dummy/sanfran.jpg" class="img-rounded" alt="sanfran">
                </div>
                <div class="col-sm-6 thumbnail">
                    <img src="<?=PROOT?>app/assets/dummy/sanfran.jpg" class="img-rounded" alt="sanfran">
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="<?=PROOT?>js/webcam.js"></script>
<?php $this->end(); ?>