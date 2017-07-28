<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\MainAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

MainAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>

<header>
        <?php
        NavBar::begin([
            'brandLabel' => 'Repositorio de Conocimientos CEPC',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top same-color',
            ],
        ]);

        $menuItems = [['label' => 'Home', 'url' => ['/site/index']],//cambie site por mi usuario

        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            $menuItems[] = ['label' => 'Sign up', 'url' => ['/site/signup']]; //site por miusuario
        } else {
            $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post')  //site por mi usuario
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',//cambie user por miusuario
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    ?>
</header>

<!--<div class="wrap">-->
<div class="wrapper">

    <?php
        if (!Yii::$app->user->isGuest) {
            require_once("../web/requireds/aside-menu.php");                
        }else{
            require_once("../web/requireds/aside-menu-guest.php");
        }
    ?>
    
     <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <br>
        <!-- Main content -->
        <section class="container-fluid" style="margin:10px;">
            <?=  $content ?>
        </section>
    </div>

</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
