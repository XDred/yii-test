<?php
	
	namespace app\controllers;
	
	use Yii;
	use yii\filters\AccessControl;
	use yii\web\Controller;
	use yii\web\Response;
	use yii\helpers\Url;
	use yii\filters\VerbFilter;
	use app\models\LoginForm;
	use app\models\ContactForm;
	use app\models\SignupForm;
	use app\models\User;
	use app\models\ProfileForm;
	
	
	class SiteController extends Controller
	{
		/**
			* {@inheritdoc}
		*/
		public function behaviors()
		{
			return [
            'access' => [
			'class' => AccessControl::className(),
			'only' => ['logout'],
			'rules' => [
			[
			'actions' => ['logout'],
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
			* {@inheritdoc}
		*/
		public function actions()
		{
			return [
            'error' => [
			'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
			'class' => 'yii\captcha\CaptchaAction',
			'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
			];
		}
		
		/**
			* Displays homepage.
			*
			* @return string
		*/
		public function actionIndex()
		{
			return $this->render('index');
		}
		
		/**
			* Login action.
			*
			* @return Response|string
		*/
		public function actionLogin()
		{
			if (!Yii::$app->user->isGuest) {
				return $this->goHome();
			}
			
			$model = new LoginForm();
			if ($model->load(Yii::$app->request->post()) && $model->login()) {
				return $this->goBack();
			}
			
			$model->password = '';
			return $this->render('login', [
            'model' => $model,
			]);
		}
		
		/**
			* Logout action.
			*
			* @return Response
		*/
		public function actionLogout()
		{
			Yii::$app->user->logout();
			
			return $this->goHome();
		}
		
		/**
			* Displays contact page.
			*
			* @return Response|string
		*/
		public function actionContact()
		{
			$model = new ContactForm();
			if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
				Yii::$app->session->setFlash('contactFormSubmitted');
				
				return $this->refresh();
			}
			return $this->render('contact', [
            'model' => $model,
			]);
		}
		
		public function actionSignup(){
			if (!Yii::$app->user->isGuest) {
				return $this->goHome();
			}
			
			$referrer = null;
			if(Yii::$app->request->get('ref')){
				$referrer = User::findByRefKey(Yii::$app->request->get('ref'));
			}
			
			
			$model = new SignupForm();
			if($model->load(\Yii::$app->request->post()) && $model->validate()){
				$user = new User();
				$user->username = $model->username;
				$user->password = \Yii::$app->security->generatePasswordHash($model->password);
				$user->authKey = Yii::$app->security->generateRandomString();

					if(isset($referrer)){
						$user->from = $referrer->getId();
					}
				if($user->save()){
					return $this->goHome();
				}
			}
			
			return $this->render('signup', compact('model','referrer'));
		}
		
		public function actionProfile()
		{	
			$model = new ProfileForm();
			if(\Yii::$app->request->post()){
				$user = User::findIdentity(Yii::$app->user->getId());
				$user->ref_key = Yii::$app->security->generateRandomString();
				$ref = $user->ref_key;
				$user->save();
				
				}else{
				$ref = Yii::$app->user->identity->ref_key;
			}
			if(!empty($ref)){
				$url = Url::toRoute(['site/signup', 'ref' => $ref],true);
				}else{
				$url="";
			}
			
			$referrer = User::findIdentity(Yii::$app->user->identity->from);
			$referrals = User::findByReferrer(Yii::$app->user->getId());
			
			/*print_r($referrals);
			die();*/
			
			return $this->render('profile', compact('model','url','referrer','referrals'));
		}
		
		
		/**
			* Displays about page.
			*
		* @return string
		*/
		public function actionAbout()
		{
			return $this->render('about');
		}
		}
		