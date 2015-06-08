<?php

namespace app\controllers;

use Yii;
use app\models\Hosting;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class HostingController extends Controller
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
			'query' => Hosting::find()->where('paid_till > 0')->orderBy('paid_till'),
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

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->getSession()->setFlash('hosting_alert', 'Данные хостинга успешно обновлены.');
			/* TODO: добавить запись в журнал событий */
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
	
	public function actionExtension($id)
	{
		$day = intval(Yii::$app->request->get('day'));
		if ($day == 365) {
			$model = $this->findModel($id);
			$paid_till = intval($model->paid_till) + (60 * 60 * 24 * $day);
			$args = [
				'paid_till' => $paid_till,
				'hosting_state' => 1,
				'hosting_notification_user' => 0,
				'hosting_notification_admin' => 0,
			];
			$model->updateAttributes($args);
			Yii::$app->getSession()->setFlash('hosting_alert', 'Хостинг продлён на '.$day.' дней.');
			/* TODO: добавить запись в журнал событий */
		}
		return $this->redirect(['view', 'id' => $id]);
	}

	protected function findModel($id)
	{
		if (($model = Hosting::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
