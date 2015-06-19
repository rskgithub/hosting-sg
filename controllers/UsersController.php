<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsersController extends Controller
{
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
}
