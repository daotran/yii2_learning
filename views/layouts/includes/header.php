<?php 

use Yii;
use yii\helpers\Html;
?>

<div class="header">
    <nav id="w0" class="navbar-inverse navbar-fixed-top navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>site/index">My Company</a>
            </div>
            <div id="w0-collapse" class="collapse navbar-collapse">
                <ul id="w1" class="navbar-nav navbar-right nav">
                    <li><a href="<?= Yii::$app->homeUrl ?>site/index">Home</a></li>
                    <li><a href="<?= Yii::$app->homeUrl ?>site/about">About</a></li>
                    <li><a href="<?= Yii::$app->homeUrl ?>posts/index">Posts</a></li>
                    <li><a href="<?= Yii::$app->homeUrl ?>users/index">Users</a></li>
                    <li><a href="<?= Yii::$app->homeUrl ?>status/index">Status</a></li>
                    <li><a href="<?= Yii::$app->homeUrl ?>site/contact">Contact</a></li>
                    
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <li class="myaccount log-buttons">
                            <a href="" class="login-link">Login |</a>
                            <a href="" class="register-link">Register</a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="<?= Yii::$app->homeUrl ?>site/logout" data-method='post'><?= Yii::t('app', 'Logout ' . '(' . Yii::$app->user->identity->email . ')') ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
</div>