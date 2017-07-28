<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\widgets\Pjax;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CompaniesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

    $user = User::findOne($id_user);
?>
<link rel="stylesheet" href="css/profile.css">

<div class="container-fluid" style="background-color: white; padding: 20px; margin-bottom:20px; margin-top:50px;">
    <div class="row">
        <div class="col-md-3 col-xs-12 centro">
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img id="img-profile" class="img-circle" src=<?= $user->img_profile?> alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$user->name.' '.$user->last_name?></h3>
              <h5 class="widget-user-desc">@<?=$user->username?></h5>
              <h5 class="widget-user-desc"><?=$user->email?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php 
                $et=array();
                $val=array();
                for($i = 0; $i < count($etiquetas); $i++){
                    array_push($et,$etiquetas[$i][0]);
                    array_push($val,$datos[$etiquetas[$i][1]]);
                ?>
                <li><a><?=$etiquetas[$i][0]?> <span class="pull-right badge bg-green"><?=$datos[$etiquetas[$i][1]]?></span></a></li>
                <?php } ?>
                <li><a>Total <span class="pull-right badge bg-green" ><?= $total?></span></a></li>
              </ul>
            </div>
          </div>
        </div>        
        <div class="col-md-9 col-xs-12">
            <h3>Estadísticas personales</h3>
            <hr>    
        <?= ChartJs::widget([
            'type' => 'radar',
            'options' => [
                'height' => 390,
                'width' => 650
            ],
            'data' => [
                'labels' => $et,
                 'datasets' => [
                     [
                        'backgroundColor' => "rgba(0,166,90,0.2)",
                        'borderColor' => "rgba(0,166,90,1)",
                        'pointBackgroundColor' => "rgba(0,166,90,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(0,166,90,1)",
                        'label'=> 'Publicaciones',
                        'data' => $val
                     ],
                 ]
            ]
        ]);?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                        <h3>Publicaciones recientes</h3>
            <hr>
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'id'=>'grid-activity',
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'rowOptions'   => function ($model) {
                    if($model->status=='habilitado')
                        return ['data-id' => $model->id, 'class' => 'enlace success'];
                    else
                        return ['data-id' => $model->id, 'class' => 'enlace danger'];
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',],

                    'title',
                    'created_date',
                    'problem_name',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'buttons' => [
                                'view' => function ($url,$model,$key) {
                                    return Html::a('',["post/view",'id'=>$model->id],['class'=>'glyphicon glyphicon-eye-open']);
                                },
                    ],
                    ],
                    ],
            ]); ?>

        <?php Pjax::end();?>
        </div>
    </div>    
</div>