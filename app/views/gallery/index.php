<?php $this->setSiteTitle('upload or take a pic'); ?>
<?php $this->start('body'); ?>
<div class="primary">
    <div class="side-bar jumbotron">
        <h4>Select a Sticker</h4>
        <ul class="nav">
            <?php
            //TODO refactor: move to Helpers class - getStickers()
            $fileDir = ROOT . DS . 'app' . DS . 'assets' . DS . 'stickers';
            if (is_dir($fileDir)) {
                $files = scandir($fileDir);
                $itr = 2;
                while ($itr < count($files)) {
                    echo '<li class="nav-item">';
                    echo "<img src=\"" . PROOT . 'app' . DS . 'assets' . DS . "stickers" . DS . "{$files[$itr]}\" class=\"frame sticker\" alt=\"frame\">";
                    echo '</li>';
                    $itr++;
                }
            }
            ?>
        </ul>
    </div>
    <div class="main-section" style="flex: 2;">
        <div class="col-md-6  submit-form">
            <form action="<?=PROOT?>gallery/upload" method="post" enctype="multipart/form-data" name="get_image">
                <label>Image File:</label><br/>
                <input class="form-group" name="image" id="imageLoader" type="file"/>
                <input name="hidden_data" id='hidden_data' type="hidden"/>
                <input name="hidden_top" id='hidden_top' type="hidden"/>
                <input type="submit" class="btn btn-primary btn-large" value="upload" id="image_submit">
                <input type="button" value="Camera" class="btn btn-large btn-primary" onclick="toggleCamera()" id="photograph">
            </form>
        </div>
        <canvas id="canvas" style="display: none;"></canvas>
        <br>
        <canvas id="imageCanvas" style="width: 100%; height: 100%; max-height: 480px; max-width: 640px;"></canvas></center>
        <div class="camera">
            <video id="video" style="width: 100%; height: 100%; max-height: 480px; max-width: 640px;">Video stream not available</video> <br />
            <button id="startbutton" class="btn btn-primary btn-large" style="display: inline-block;">Take photo</button>
        </div>
    </div>
    <div class="side-bar jumbotron">
        <h4>Your Images:</h4>
    </div>
</div>
<?php $this->end(); ?>