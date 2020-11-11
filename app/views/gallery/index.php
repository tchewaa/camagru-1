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
    <div class="main-section">
        <div class="top-container">
            <video id="video">Stream not available</video>
            <button class="btn btn-dark" id="photo-button">
                Take Photo
            </button>
            <select id="photo-filter">
                <option value="none">Normal</option>
                <option value="grayscale(100%)">Grayscale</option>
                <option value="sepia(100%)">Sepia</option>
                <option value="invert(100%)">Invert</option>
                <option value="hue-rotate(90deg)">Hue</option>
                <option value="blur(10px)">Blur</option>
                <option value="contrast(200%)">Contrast</option>
            </select>
            <button class="btn btn-dark" id="clear-button">Clear</button>
            <canvas id="canvas"></canvas>
        </div>
        <div class="bottom-container">
            <div id="photos"></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=PROOT?>js/webcam.js"></script>
<?php $this->end(); ?>