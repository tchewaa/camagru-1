<?php $this->setSiteTitle('upload or take a pic'); ?>
<?php $this->start('body'); ?>
    <div class="row" id="gallery">
        <div class="col-md-8 jumbotron">
            <h3>Upload or Take a Picture</h3>
            <div class="row">
                <div class="col-md-6">
                    <h3>Editor</h3>
                    <form>
                        <input id="file-upload" class="p-0" required name="photo" type="file" accept="image/jpeg, image/png, application/pdf" />
                        <!--                <button> Take Photo</button>-->
                    </form>
                </div>
                <div class="col-md-6">
                    <h3>Captured Image</h3>
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