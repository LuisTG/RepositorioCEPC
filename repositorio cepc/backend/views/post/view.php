<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\controllers\CategoriaController;
use backend\models\Categoria;
use common\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\PostCategoria;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$user=User::findOne($model->id_user);

?>
<link rel="stylesheet" href="css/post.css">

    <h1><?php
    date_default_timezone_set('America/Mexico_City');
     //echo Html::encode($this->title); ?></h1>


<div class="content shadow" style="background-color: white; padding: 20px; margin-bottom:20px; margin-top:50px;">
	<div>
		<h1><?= $model->title ?> 
            <?php if(Yii::$app->user->id== $model->id_user) { 
            		if($model->status=='habilitado'){
            	?>
					<a class="btn btn-danger btn-xs"  data-method='POST' href=<?="index.php?r=post/delete&post=".$model->id?> style="float:right; color:white; margin:3px 5px;"><span class="glyphicon glyphicon-remove"></span></a>
			    <?php } else{ ?>
			    	<a class="btn btn-success btn-xs"  data-method='POST' href=<?="index.php?r=post/undelete&post=".$model->id?> style="float:right; color:white; margin:3px 5px;"><span class="glyphicon glyphicon-ok"></span></a>
			    
				    <?php
				    	}
				    ?>
			    <a href=<?php echo"index.php?r=post/update&id=".$model->id?> class='button-problem shadow' style="float: right; text-decoration=none; color:white; padding:5px 10px;">Actualizar</a>
            <?php } ?>
        </h1>
		<p><small>Publicado por <a href=<?php echo "index.php?r=site/activity-own&id=".$user->id; ?>><?= $user->name.' '.$user->last_name;?></a> - <?= date('d \d\e F \d\e Y', strtotime($model->created_date)) ?></small></p>
	</div>
	<hr />
	<h4>Contenido</h4>
	<div class="content-text">
		<?= $model->content ?>
		<!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci fugiat ullam possimus earum dolor minima suscipit quibusdam impedit dicta assumenda inventore officiis quisquam, consectetur rerum corporis sapiente illum cumque nisi!</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores qui doloribus eum facere est laudantium cum expedita delectus. Nobis sequi iste accusamus, rerum sint, nam enim voluptatum illum aliquid alias.</p>
		<p>
			<pre><code>
public class HelloWorld
  {
     public static void main(String[] args) {
     System.out.println("Hello World!");
  }
}
			</code></pre>
		</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi dignissimos nemo, eaque sint impedit excepturi perferendis, reprehenderit, saepe, doloribus laboriosam aperiam placeat exercitationem unde amet ad cum rem aliquid illum!</p>-->
	<hr />
	<p class="button-text">
		<a href=<?=$model->problem_link?>><button class="button-problem shadow">Ver problema</button></a>
	</p>
	<h3>Tags</h3>
	<div>
        <?php $data=PostCategoria::find()->filterWhere(['id_post'=>$model->id])->all();
            for($x=0;$x<count($data);$x++){
        ?>
        <span class="tag-category"><small><?=Categoria::findOne($data[$x]['id_categoria'])->nombre ?></small></span>
        <?php }
        ?>
	</div>
	</div>
</div>



<div class="content-comments">
	<h2>Comentarios</h2>

	<?php $form = ActiveForm::begin(['id'=>$comment->formName(),
        'enableAjaxValidation'=>true,
        'validationUrl'=>Url::toRoute('post/validation2')]); ?>

                <div class="comment-user">
                    <?= $form->field($comment, 'content')->textarea(['rows' => 6, 'placeholder'=>'Escribe tu comentario...']) ?>
                    <div class="form-group">
                        <?= Html::submitButton($comment->isNewRecord ? 'Send' : 'Update', ['class' => $comment->isNewRecord ? 'button-send btn btn-success' : 'button-send btn btn-primary']) ?>
                    </div>
                </div>
    <?php ActiveForm::end() ?>
	<br />
	<?php 
		//print_r($comments);
		foreach($comments as $comm){
			$usuario = User::findOne($comm->id_user);
	 ?>
	<div class="row">
		<?php if(Yii::$app->user->id== $usuario->id) { ?>
			<a data-confirm="Are you sure want to delete this comment?" class="btn btn-danger btn-xs" data-method='post' href=<?="index.php?r=post/delete-comment&com=".$comm->id.'&post='.$model->id?> style="float:right; margin:10px;"><span class="glyphicon glyphicon-remove"></span></a>
		<?php } ?>
		<div class="col-md-2" style="text-align: center;">
			<div class="user-img"><img src=<?= $usuario->img_profile ?> alt="" class="user-img"></div>
		</div>
		<div class="col-md-10 comment">
			<h4><?= $usuario->name.' '.$usuario->last_name ?> <small>escribió lo siguiente:</small><small><span style="float:right;"><?= date('h:i:s A \e\l d \d\e F \d\e Y', strtotime($comm->created_date)) ?></span></small></h4>

			<hr />
			<p><?= $comm->content ?></p>
		</div>
	</div>
	<br />
	<?php } ?>

	
</div>