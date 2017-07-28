<?php
use yii\widgets\LinkPager;
use common\models\User;
use backend\models\Categoria; 
use backend\models\PostCategoria; 
?>
<div class="container-fluid" style="margin-top: 40px;">
<link rel="stylesheet" href="css/post.css">



<?php
echo $this->render('../post/_search',['model'=>$searchModel]);
$counter = 0;
foreach ($models as $model) {
        $counter++;
        $user = User::findOne($model['id_user']);
    ?>

    <div class="content shadow" style="clear:both;">   
    
        <div class="row">
            <div class="col-md-2 img-user-desktop">
                <img src=<?=$user->img_profile?> alt="" class="user-img">
                <br><br>
                <p class="name-user">Publicado por <strong>
                <a href=<?php echo "index.php?r=site/activity-own&id=".$user->id; ?>><?= $user->name.' '.$user->last_name;?></a>  </strong></p>
            </div>
            <div class="col-md-10 col-xs-12">
                <a href=<?php echo "index.php?r=post/view&id=".$model['id']; ?> class='button-problem shadow' style="float: right; text-decoration=none; color:white; padding:5px 10px;"><small>Ver más</small></a>
                
                <div>
                    
                    <h3><a rel="nofollow" rel="noreferrer" href=<?php echo "index.php?r=post/view&id=".$model['id']; ?>><?=$model['title']?></a></h3> 
                    </div>
                <hr />
                <p><strong>Descripción</strong></p>
                <p><?= $model['content'] ?></p>
                <hr />
                <p><span class="mini-view">Tú también puedes resolver este problema: <a href=<?= $model['problem_link']; ?>><strong><?=$model['problem_name']?></strong></a></span></p>
                <div>
                    <?php $data=PostCategoria::find()->filterWhere(['id_post'=>$model['id']])->all();
                        for($x=0;$x<count($data);$x++){
                            ?>
                        <span class="tag-category"><small><?=Categoria::findOne($data[$x]['id_categoria'])->nombre ?></small></span>
                        <?php }

                    ?>
                </div>
            </div>
        </div>

    </div>

<?php
}
if($counter==0){
    echo '<p>¡Ups! No se han encontrado publicaciones relacionadas.</p>';
}
?>
</div>



	


<?php
// display pagination
echo LinkPager::widget([
    'pagination' => $pages,
]);
?>