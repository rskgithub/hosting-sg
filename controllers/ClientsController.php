<?php

namespace app\controllers;

use Yii;
use app\components\AuthControl;
use app\models\Hosting;
use app\models\HostingUsers;
use app\models\Users;
use app\models\UsersLog;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ClientsController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index', 'view', 'create', 'update', 'delete', 'hosting'],
				'rules' => [
					[
						'allow' => true,
						'actions' => ['delete', 'hosting'],
						'roles' => ['admin'],
					],
					[
						'allow' => true,
						'actions' => ['index', 'view', 'create', 'update'],
						'roles' => ['@'],
						'denyCallback' => function() {
							return Yii::$app->response->redirect(['/users/login']);
						},
					],
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
			'authcontrol' => [
				'class' => AuthControl::className()
			],
		];
	}

	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Users::find()->where('status = 0')->orderBy('name'),
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

	public function actionCreate()
	{
		$model = new Users();
		$model->scenario = 'create';

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$log = new UsersLog();
			$log->logSave(Yii::$app->user->identity->id, 'Добавлен новый клиент '.$model->name.' (ID :'.$model->id.')');
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$status = $model->status;
		$model->scenario = 'update';

		if ($model->load(Yii::$app->request->post())) {
			if ($status != $model->status) {
				$model->auth_key = '';
			}
			if ($model->save()) {
				$log = new UsersLog();
				$log->logSave(Yii::$app->user->identity->id, 'Изменён клиент '.$model->name.' (ID :'.$model->id.')');
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				return $this->render('update', ['model' => $model]);
			}
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$log = new UsersLog();
		$log->logSave(Yii::$app->user->identity->id, 'Удалён клиент '.$model->name.' (ID :'.$model->id.')');
		$model->delete();
		return $this->redirect(['index']);
	}
	
	public function actionHosting($action, $client_id, $hosting_id = null)
	{
		switch ($action)
		{
			case 'add':
				$model = new HostingUsers();
				return $this->render('hosting', [
					'model' => $model,
					'client' => $this->findModel($client_id),
				]);
				break;
			case 'save':
				$model = new HostingUsers();
				if ($model->load(Yii::$app->request->post()) && $model->save()) {
					Yii::$app->getSession()->setFlash('clients_alert', 'Хостинг успешно добавлен.');
					$log = new UsersLog();
					$log->logSave(Yii::$app->user->identity->id, 'Для клиента '.$this->findModel($client_id)->name.' (ID: '.$client_id.') добавлен хостинг '.$this->findModel($client_id)->getHosting()->one()->domain.' (ID: '.$model->information_id.')');
					return $this->redirect(['view', 'id' => $client_id]);
				} else {
					return $this->render('hosting', [
						'model' => $model,
						'client' => $this->findModel($client_id),
					]);
				}
				break;
			case 'delete':
				if ($this->findModel($client_id)->getHostingUsers()->where('information_id = '.intval($hosting_id))->one()->delete() !== false) {
					Yii::$app->getSession()->setFlash('clients_alert', 'Хостинг успешно удалён.');
					$log = new UsersLog();
					$log->logSave(Yii::$app->user->identity->id, 'У клиента '.$this->findModel($client_id)->name.' (ID: '.$client_id.') удален хостинг '.Hosting::findOne($hosting_id)->domain.' (ID: '.$hosting_id.')');
				} else {
					Yii::$app->getSession()->setFlash('clients_alert', 'Не удалось удалить хостинг.');
				}
				return $this->redirect(['view', 'id' => $client_id]);
				break;
		}
	}

	protected function findModel($id)
	{
		if (($model = Users::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('Ничего не найдено.');
		}
	}
}
