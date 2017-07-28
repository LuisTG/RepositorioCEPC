<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use backend\models\SignupForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\ContactForm;
use yii\db\Connection;
use yii\data\Pagination;
use backend\models\Post;
use yii\widgets\LinkPager;
use backend\models\PostSearch;
use yii\db\Query;
use backend\models\PostCategoria;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'update', 'index', 'index-own','activity-own','delete-user','search'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function actionSearch($t){
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$query = Yii::$app->db->createCommand('SELECT * FROM post ORDER BY created_date DESC; ');
        $habilitado='habilitado';
        $query = Post::find()->orderBy(['created_date'=>SORT_DESC])->filterWhere(['status'=>$habilitado]);
        $consulta = new Query;
        $consulta->select('*')->from('post')->where('LOWER(title) LIKE \'%'.strtolower($t).'%\'');
        $rows = $consulta->all();
//die();
        
        $pages = new Pagination([
        'totalCount' => count($rows),
        'pageSize' => '4',]);
        
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        return $this->render('index', [
             'models' => $rows,
             'pages' => $pages,
             'searchModel' => $searchModel,
        ]);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$query = Yii::$app->db->createCommand('SELECT * FROM post ORDER BY created_date DESC; ');
        $habilitado='habilitado';
        $query = Post::find()->orderBy(['created_date'=>SORT_DESC])->filterWhere(['status'=>$habilitado]);
        
        $countQuery = clone $query;
        $pages = new Pagination([
        'totalCount' => $countQuery->count(),
        'pageSize' => '4',]);
        
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        return $this->render('index', [
             'models' => $models,
             'pages' => $pages,
             'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndexOwn()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$query = Yii::$app->db->createCommand('SELECT * FROM post ORDER BY created_date DESC; ');
        $userID = Yii::$app->user->id;
        $habilitada='habilitado';
        $query = Post::find()->orderBy(['created_date'=>SORT_DESC])->filterWhere(['id_user'=>$userID,'status'=>$habilitada]);
        
        $countQuery = clone $query;
        $pages = new Pagination([
        'totalCount' => $countQuery->count(),
        'pageSize' => '4',]);
        
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        return $this->render('index', [
             'models' => $models,
             'pages' => $pages,
             'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionActivityOwn($id)
    {
        $etiquetas=(new Query())->select(['id','nombre'])->from('categoria')->all();
        $nombres=array();
        $datos=array();
        foreach($etiquetas as $etiqueta){
            array_push($nombres,[$etiqueta['nombre'],$etiqueta['id']]);
            $datos[$etiqueta['id']]=0;
            //$count=(new Query())->select('count(postcategoria.id) as cant')->from(['post','postcategoria','categoria'])->where(["post.id_user"=>$id, 'postcategoria.id_categoria'=>$etiqueta['id'],'postcategoria.id_post'=>])->all();
            //array_push($datos, $count[0]['cant']);
        }
        $habilitada="habilitado";
        $posts=Post::find()->filterWhere(['id_user'=>$id,'status'=>$habilitada])->all();
        $total=count($posts);
        foreach($posts as $post){
            $postCats=PostCategoria::find()->filterWhere(['id_post'=>$post['id']])->all();
            foreach ($postCats as $postCat) {
                $datos[$postCat['id_categoria']]++;
            }
        }
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('activity', [
            'datos'=>$datos,
            'etiquetas'=>$nombres,
            'id_user' => $id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'total'=>$total,
        ]);

    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(){
        $model = new SignupForm();
        $userID = Yii::$app->user->id;
        $userModel = User::findIdentity($userID); //Obtenemos todos los datos de la BD

        if ($model->load(Yii::$app->request->post())) {
            print_r($model->getErrors());
            if($user = $model->update($userModel)){
                return $this->goHome();    
            }            
        }  
        $model->name = $userModel->name;
        $model->last_name = $userModel->last_name;
        $model->email = $userModel->email;
        $model->username = $userModel->username;
        $model->file = $userModel->img_profile;
        return $this->render('modify', [
            'model' => $model,
        ]);
    }

    public function actionDeleteUser($id){
        if(Yii::$app->user->id==$id){
            $user=User::findOne($id);
            $user->status=0;
            $user->save();
            Yii::$app->user->logout();
            return $this->goHome();
        }else{
            throw new NotFoundHttpException('Are you HackerMan?');
        }
    }
}
