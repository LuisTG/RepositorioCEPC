<?php

namespace backend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $created_date
 * @property integer $id_user
 * @property string $problem_name
 * @property string $problem_link
 *
 * @property Comment[] $comments
 * @property User $idUser
 * @property Postcategoria[] $postcategorias
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'created_date', 'id_user', 'problem_name', 'problem_link'], 'required'],
            [['content','status'], 'string'],
            [['created_date'], 'safe'],
            [['id_user'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['problem_name'], 'string', 'max' => 100],
            [['problem_link'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'created_date' => 'Created Date',
            'id_user' => 'Id User',
            'problem_name' => 'Problem Name',
            'problem_link' => 'Problem Link',
            'status'=> 'Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['id_post' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostcategorias()
    {
        return $this->hasMany(Postcategoria::className(), ['id_post' => 'id']);
    }
}
