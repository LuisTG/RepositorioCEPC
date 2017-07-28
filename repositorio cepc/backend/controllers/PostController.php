<?php

namespace backend\controllers;

use Yii;
use backend\models\Post;
use backend\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\Comment; 
use backend\models\PostCategoria;
use backend\models\Model;
use yii\helpers\ArrayHelper;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'undelete' => ['POST'],
                    'delete-comment' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        throw new NotFoundHttpException('this page does not Exist');
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $comment = new Comment();
        $model = $this->findModel($id);
        $habilitada='habilitado';
        $query = Comment::find()->orderBy(['created_date'=>SORT_DESC])->filterWhere(['id_post'=>$model->id,'status'=>$habilitada])->all();

        if ($comment->load(Yii::$app->request->post())) {
            $comment->id_user = Yii::$app->user->id;
            $comment->id_post = $model->id;
            $comment->created_date = date('Y-m-d h:i:s');
            $comment->save();
            $comment2 = new Comment();
            return Yii::$app->response->redirect(Url::to(['post/view', 'id' => $id]));
            /*return $this->render('view', [
                'model' => $model,
                'comment'=>$comment2,
                'comments'=>$query,
            ]);*/
        }else{
            return $this->render('view', [
                'model' => $model,
                'comment'=>$comment,
                'comments'=>$query,
            ]);
        }
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $modelsPoItems = [new PostCategoria];

        if ($model->load(Yii::$app->request->post()) ) {
            $model->id_user=Yii::$app->user->id;
            $model->created_date=date('Y-m-d h:i:s');
            $model->content=utf8_encode($model->content);
            $transaction = \Yii::$app->db->beginTransaction();
            $model->save();
            $modelsPoItem = Model::createMultiple(PostCategoria::classname());
            Model::loadMultiple($modelsPoItem, Yii::$app->request->post());

            // validate all models
            $et=array();
            $mod=array();
            foreach ($modelsPoItem as $modelPoItem) {
                $modelPoItem->id_post = $model->id;
                if(!in_array($modelPoItem->id_categoria,$et)){
                    array_push($et,$modelPoItem->id_categoria);
                    array_push($mod,$modelPoItem);
                }
            }
            $modelsPoItem=$mod;
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPoItem) && $valid;

            if ($valid) {

                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsPoItem as $modelPoItem) {
                            $modelPoItem->id_post = $model->id;
                            if (! ($flag = $modelPoItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
                //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'modelsPoItem' => (empty($modelsPoItem)) ? [new PostCategoria] : $modelsPoItem
            ]);
        }
    }
    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        if(Yii::$app->user->id==$model->id_user){
            $modelsPoItem=PostCategoria::find()->filterWhere(['id_post'=>$model->id])->all();//= $model->poItems;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $oldIDs = ArrayHelper::map($modelsPoItem, 'id_categoria', 'id');
                //print_r($oldIDs);
                //print_r("hola");
                $modelsPoItem = Model::createMultiple(PostCategoria::classname(), $modelsPoItem);
                Model::loadMultiple($modelsPoItem, Yii::$app->request->post());
                //print_r(ArrayHelper::map($modelsPoItem, 'id_categoria', 'id'));
                //print_r("hola");
                $deletedIDs = array_diff_key($oldIDs, ArrayHelper::map($modelsPoItem, 'id_categoria', 'id'));
                print_r($deletedIDs);
                //die();
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPoItems),
                    ActiveForm::validate($model)
                );
            }

           
            
            $et=array();
            $mod=array();
            foreach ($modelsPoItem as $modelPoItem) {
                $modelPoItem->id_post = $model->id;
                if(!in_array($modelPoItem->id_categoria,$et)){
                    array_push($et,$modelPoItem->id_categoria);
                    array_push($mod,$modelPoItem);
                    print_r("expression");
                    print_r($modelPoItem->id_categoria);

                }
            }
            $modelsPoItem=$mod;
            //die();
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPoItem) && $valid;
                if ($valid) {
                     $transaction = \Yii::$app->db->beginTransaction(); //here transaction
                    try {
                        if ($flag = $model->save(false)) {
                            if (! empty($deletedIDs)) {
                                PostCategoria::deleteAll(['id' => $deletedIDs]);
                            }
                            foreach ($modelsPoItem as $modelPoItem) {
                                print_r($modelPoItem->id_categoria);
                                
                                $modelPoItem->id_post = $model->id;
                                print_r($modelPoItem->getErrors());
                                if (!$modelPoItem->save()) {                                
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                            
                        }
                        if ($flag) {
                            $transaction->commit();
                            //die();
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
                //return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'modelsPoItem'=>(empty("modelsPoItem"))?[new PostCategoria]:$modelsPoItem
                ]);
            }
            /*$model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }*/
        }else{
            throw new NotFoundHttpException('Are you HackerMan?');
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($post)
    {
        $model=$this->findModel($post);
         if(Yii::$app->user->id==$model->id_user){
            $model->status='deshabilitado';
            $model->save();
            return Yii::$app->response->redirect(Url::to(['site/index']));
        }else{
            throw new NotFoundHttpException('Are you HackerMan?');
        }
    }

    public function actionUndelete($post)
    {
        $model=$this->findModel($post);
         if(Yii::$app->user->id==$model->id_user){
            $model->status='habilitado';
            $model->save();
            return Yii::$app->response->redirect(Url::to(['site/index']));
        }else{
            throw new NotFoundHttpException('Are you HackerMan?');
        }
    }

    public function actionDeleteComment($com,$post)
    {   $comment=Comment::findOne($com);
        if(Yii::$app->user->id==$comment->id_user){            
            $comment->status='deshabilitado';
            $comment->save();
            return Yii::$app->response->redirect(Url::to(['post/view', 'id' => $post]));
        }else{
            throw new NotFoundHttpException('Are you HackerMan?');
        }
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidation(){
            $model = new Post();
            if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
                Yii::$app->response->format = 'json';
                //if(!empty(ActiveForm::validate($model)))
                    return ActiveForm::validate($model);
            }
    }

        public function actionValidation2(){
            $model = new Comment();
            if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
                Yii::$app->response->format = 'json';
                //if(!empty(ActiveForm::validate($model)))
                    return ActiveForm::validate($model);
            }
    }
}
