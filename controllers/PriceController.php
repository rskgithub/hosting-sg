<?php

namespace app\controllers;

use Yii;
use app\components\AuthControl;
use app\models\Price;
use app\models\UsersLog;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PriceController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index', 'create', 'update', 'delete'],
				'rules' => [
					[
						'allow' => true,
						'actions' => ['create', 'update', 'delete'],
						'roles' => ['admin'],
					],
					[
						'allow' => true,
						'actions' => ['index'],
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
			'query' => Price::find()->orderBy('value'),
			'sort' => false,
			'pagination' => false,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionCreate()
	{
		$model = new Price();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$log = new UsersLog();
			$log->logSave(Yii::$app->user->identity->id, 'Добавлена новая цена c ID #'.$model->id.' и значением '.$model->value.' руб.');
			return $this->redirect(['index']);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$current_value = $model->value;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$log = new UsersLog();
			$log->logSave(Yii::$app->user->identity->id, 'Обновлена цена c ID #'.$model->id.': с '.$current_value.' руб. на '.$model->value.' руб.');
			return $this->redirect(['index']);
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
		$log->logSave(Yii::$app->user->identity->id, 'Удалена цена c ID #'.$id.' и значением '.$model->value.' руб.');
		$model->delete();
		return $this->redirect(['index']);
	}

	protected function findModel($id)
	{
		if (($model = Price::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('Ничего не найдено.');
		}
	}
}
