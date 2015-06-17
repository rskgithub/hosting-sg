<?php

namespace app\controllers;

use Yii;
use app\models\HostingUsers;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ClientsController extends Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
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

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			/* TODO: добавить запись в журнал событий */
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

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			/* TODO: добавить запись в журнал событий */
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		/* TODO: добавить запись в журнал событий */
		return $this->redirect(['index']);
	}
	
	public function actionHosting($action, $client_id = null, $hosting_id = null)
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
					/* TODO: добавить запись в журнал событий */
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
					/* TODO: добавить запись в журнал событий */
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
