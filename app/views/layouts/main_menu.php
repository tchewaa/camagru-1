<?php
    use Core\Router;
    use Core\Helpers;
    use App\Models\Users;
    $menu = Router::getMenu('menu_acl');
    $currentPage = Helpers::currentPage();
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=PROOT?>home"><?=MENU_BRAND?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="main_menu">
            <ul class="nav navbar-nav">
                <?php foreach($menu as $key => $val):
                    $active = '';
                    $active = ($val == $currentPage)? 'active':''; ?>
                    <li><a class="<?=$active?>" href="<?=$val?>"><?=$key?></a></li>
                <?php endforeach; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(Users::currentUser()): ?>
                    <li><a href="#">Y'ello <?=Users::currentUser()->username?></a></li>
                <?php endif; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
