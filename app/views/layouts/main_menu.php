<?php
    $menu = Router::getMenu('menu_acl');
    $currentPage = currentPage();
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="<?=PROOT?>"><?=MEBU_BRAND?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="main_menu">
        <ul class="navbar-nav mr-auto">
            <?php foreach ($menu as $key => $val):
                $active = ''?>
                <?php if (is_array($val)): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <?=$key?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($menu as $k => $v):
                                $active = ($v == $currentPage) ? 'active' : ''; ?>
                                <?php if ($k == 'separator'): ?>
                                    <div class="dropdown-divider"></div>
                                <?php else: ?>
                                    <a class="dropdown-item <?=$active?>" href="<?=$v?>"><?=$k?> </a>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </li>
                <?php else:
                    $active = ($val == $currentPage) ? 'active' : ''; ?>
                    <a class="dropdown-item <?=$active?>" href="<?=$val?>"><?=$key?> </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
        <ul class="navbar-nav navbar-right">
            <?php if (currentUser()): ?>
                <li class="nav-item dropdown">
                    <a href="#"> Y'ello <?= currentUser()->fname ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>



<!--<nav class="navbar navbar-expand-lg navbar-dark">-->
<!--    <a class="navbar-brand" href="#">Camagru</a>-->
<!--    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">-->
<!--        <span class="navbar-toggler-icon"></span>-->
<!--    </button>-->
<!--    <div class="collapse navbar-collapse" id="main_menu">-->
<!--        <ul class="navbar-nav mr-auto">-->
<!--            <li class="nav-item active">-->
<!--                <a class="nav-link" href="#">H ome <span class="sr-only">(current)</span></a>-->
<!--            </li>-->
<!--        </ul>-->
<!--        <span class="navbar-text">-->
<!--            <ul class="navbar-nav mr-auto">-->
<!--            <li class="nav-item">-->
<!--                <a class="nav-link" href="#">Register</a>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--                <a class="nav-link" href="#">Login</a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </span>-->
<!--    </div>-->
<!--</nav>-->
