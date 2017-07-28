<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "prueba".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $nombre
 */
class Prueba extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'nombre'], 'required'],
            [['username'], 'string', 'max' => 20],
            [['email', 'nombre'], 'string', 'max' => 45],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'nombre' => 'Nombre',
        ];
    }
}
