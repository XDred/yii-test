<?php
	
	namespace app\models;
	use yii\db\ActiveRecord;
	
	class User extends ActiveRecord implements \yii\web\IdentityInterface
	{
		//public $id;
		//public $username;
		//public $password;
		//public $authKey;
		// public $accessToken;
		
		
		/**
			* @inheritdoc
		*/
		public static function tableName()
		{
			return 'users';
		}
		
		public function rules()
		{
			return [
			[['username', 'password'], 'required'],
            [['username','password','ref_key'], 'string', 'max' => 255]
			];
		}
		
		/**
			* {@inheritdoc}
		*/
		public static function findIdentity($id)
		{
			return static::findOne($id);
		}
		
		/**
			* {@inheritdoc}
		*/
		public static function findIdentityByAccessToken($token, $type = null)
		{
			foreach (self::$users as $user) {
				if ($user['accessToken'] === $token) {
					return new static($user);
				}
			}
			
			return null;
		}
		
		/**
			* Finds user by username
			*
			* @param string $username
			* @return static|null
		*/
		public static function findByUsername($username)
		{
			return static::findOne(['username' => $username]);
		}
		
		public static function findByRefKey($refKey)
		{
			return static::findOne(['ref_key' => $refKey]);
		}
		
		public static function findByReferrer($referrerId)
		{
			return static::findAll(['from' => $referrerId]);
		}
		
		/**
			* {@inheritdoc}
		*/
		public function getId()
		{
			return $this->id;
		}	
		
		public function getRefKey()
		{
			return $this->ref_key;
		}
		
		/**
			* {@inheritdoc}
		*/
		public function getAuthKey()
		{
			return $this->authKey;
		}
		
		/**
			* {@inheritdoc}
		*/
		public function validateAuthKey($authKey)
		{
			return static::findOne(['authKey' => $authKey]);
		}
		
		/**
			* Validates password
			*
			* @param string $password password to validate
			* @return bool if password provided is valid for current user
		*/
		public function validatePassword($password)
		{
			return \Yii::$app->security->validatePassword($password, $this->password);
		}
	}
