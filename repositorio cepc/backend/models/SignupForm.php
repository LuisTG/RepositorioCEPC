<?php
namespace backend\models;

use yii\base\Model;
use common\models\User;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $name;
    public $last_name;
    public $img_profile;
    public $file;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            [['password','name','last_name'], 'required'],
            ['password', 'string', 'min' => 6],

            [['last_name','name'],'trim'],
            [['last_name','name'], 'string', 'max' => 100],

            ['file', 'image','maxSize'=>15.5*1024*1024],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();

        $imageName=$this->username;
        $this->file=UploadedFile::getInstance($this,'file');

        if(!empty($this->file)){

        $this->file->saveAs('uploads/'.$imageName.'.'.$this->file->extension);
                //save the path in the db column
        $user->img_profile='uploads/'.$imageName.".".$this->file->extension;
        }

        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->name= $this->name;
        $user->last_name= $this->last_name;
        
        return $user->save() ? $user : null;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function update($user)
    {

        /*if (!$this->validate()) {
            return null;
        }*/


//        $user = new User();
//        $user->id = Yii::$app->user->id;

        $imageName=$this->username;
        $this->file=UploadedFile::getInstance($this,'file');

        if(!empty($this->file)){
            $this->file->saveAs('uploads/'.$imageName.'.'.$this->file->extension);
            $user->img_profile='uploads/'.$imageName.".".$this->file->extension;
        }

        /*$user->username = $this->username;
        $user->email = $this->email;*/
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->name= $this->name;
        $user->last_name= $this->last_name;
        return $user->save() ? $user : null;
    }
}
