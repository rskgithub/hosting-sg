<?php

namespace app\controllers;

use Yii;
use app\components\AuthControl;
use app\models\Users;
use app\models\UsersLog;
use app\models\LoginForm;
use app\models\RecoveryForm;
use app\models\ResetPasswordForm;
use yii\data\ActiveDataProvider;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

class UsersController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index', 'view', 'logout'],
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
						'denyCallback' => function() {
							return Yii::$app->response->redirect(['/users/login']);
						},
					],
				
				]
			],
			'authcontrol' => [
				'class' => AuthControl::className()
			],
		];
	}
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Users::find()->where('status > 0')->orderBy('status DESC'),
			'sort' => false,
			'pagination' => false,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	protected function findModel($id)
	{
		if (($model = Users::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('Ничего не найдено.');
		}
	}
	
	public function actionLogin()
	{
		$model = new LoginForm();
		
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			$log = new UsersLog();
			$log->logSave(Yii::$app->user->identity->id, 'Вход');
			return $this->redirect(['/hosting/index']);
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}
	
	public function actionLogout()
	{
		$log = new UsersLog();
		$log->logSave(Yii::$app->user->identity->id, 'Выход');
		Yii::$app->user->logout();
		return $this->redirect(['login']);
	}
	
	public function actionRecovery()
	{
		$key = Yii::$app->request->get('key');
		if (!empty($key)) {
			try {
				$model = new ResetPasswordForm($key);
			} catch (InvalidParamException $e) {
				throw new BadRequestHttpException($e->getMessage());
			}
			
			if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
				Yii::$app->getSession()->setFlash('auth_message', 'Новый пароль успешно сохранён.');
				$this->redirect(['/users/login']);
			} else {
				return $this->render('reset-password', [
					'model' => $model,
				]);
			}
		} else {
			$model = new RecoveryForm();
			if ($model->load(Yii::$app->request->post()) && $model->validate()) {
				if ($model->sendEmail()) {
					Yii::$app->getSession()->setFlash('auth_message', 'На указанный e-mail выслана инструкция по восстановлению пароля.');
					return $this->refresh();
				} else {
					Yii::$app->getSession()->setFlash('auth_message', 'К сожалению, сбросить пароль для указанного e-mail не удалось.');
					return $this->render('recovery', [
						'model' => $model,
					]);
				}
			} else {
				return $this->render('recovery', [
					'model' => $model,
				]);
			}
		}
	}
}
