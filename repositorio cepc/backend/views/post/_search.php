<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="" style="float:right; margin-bottom: 20px;">
    <form class="form-inline" method="get" action=""> <!--action="/cepcrep/backend/web/index.php"-->
        <div class="input-group form-group" style="">
            <input type="text" value="site/search" name="r" style="display:none;">
            <input type="text" id="postsearch-search" class="form-control" name="t" placeholder="Busca por título..." 
            style="width:300px;">

            <span class="input-group-btn" >
                <button type="submit" class="btn btn-primary ">Buscar</button>
            </span>
        </div>
    </form>

</div>