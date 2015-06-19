<?php

namespace app\controllers;

use Yii;
use app\models\Users;
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
			/* TODO: добавить запись в журнал событий */
			return $this->redirect(['/hosting/index']);
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}
	
	public function actionLogout()
	{
		Yii::$app->user->logout();
		/* TODO: добавить запись в журнал событий */
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
				/* TODO: добавить запись в журнал событий */
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
					/* TODO: добавить запись в журнал событий */
					return $this->refresh();
				} else {
					Yii::$app->getSession()->setFlash('auth_message', 'К сожалению, сбросить пароль для указанного e-mail не удалось.');
				}
			} else {
				return $this->render('recovery', [
					'model' => $model,
				]);
			}
		}
	}
}
