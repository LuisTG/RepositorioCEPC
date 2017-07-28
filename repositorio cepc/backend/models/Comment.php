<?php

namespace backend\models;

use Yii;
use common\models\User; 

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_post
 * @property string $content
 * @property string $created_date
 * @property string $status
 *
 * @property User $idUser
 * @property Post $idPost
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_post', 'content', 'created_date'], 'required'],
            [['id_user', 'id_post'], 'integer'],
            [['content', 'status'], 'string'],
            [['created_date'], 'safe'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_post'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['id_post' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_post' => 'Id Post',
            'content' => '',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
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
    public function getIdPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'id_post']);
    }
}
