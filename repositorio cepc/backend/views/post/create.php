<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <h1></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsPoItem'=>$modelsPoItem,
    ]) ?>

</div>
