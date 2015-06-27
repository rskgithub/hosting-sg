<?php

namespace app\controllers;

use Yii;
use app\components\AuthControl;
use app\models\Hosting;
use app\models\UsersLog;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class HostingController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index', 'view', 'update', 'extension', 'notification'],
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
			$log = new UsersLog();
			$log->logSave(Yii::$app->user->identity->id, 'Изменён хостинг '.$model->domain.' (ID :'.$model->id.')');
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
			if (!Yii::$app->user->can('hostingExtensionYear'))
				throw new ForbiddenHttpException('Вам не разрешено производить данное действие.');
			
			$model = $this->findModel($id);
			$paid_till = intval($model->paid_till) + (60 * 60 * 24 * $day);
			$args = [
				'paid_till' => $paid_till,
				'hosting_state' => 1,
				'hosting_freeze' => 0,
				'notification_user' => 0,
				'notification_admin' => 0,
			];
			$model->updateAttributes($args);
			$model->sendNotification('year', 'client');
			Yii::$app->getSession()->setFlash('hosting_alert', 'Хостинг продлён на '.$day.' дней.');
			$log = new UsersLog();
			$log->logSave(Yii::$app->user->identity->id, 'Хостинг '.$model->domain.' (ID :'.$model->id.') продлён на '.$day.' дней');
		}
		if ($day == 5) {
			$model = $this->findModel($id);
			$model->updateAttributes(['hosting_freeze' => 1]);
			Yii::$app->getSession()->setFlash('hosting_alert', 'Хостинг будет заморожен на '.$day.' дней по истечению срока оплаты.');
			$log = new UsersLog();
			$log->logSave(Yii::$app->user->identity->id, 'Для хостинга '.$model->domain.' (ID :'.$model->id.') включена заморозка на '.$day.' дней');
		}
		return $this->redirect(['view', 'id' => $id]);
	}
	
	public function actionNotification($id)
	{
		$model = $this->findModel($id);
		if ($model->sendNotification('manual', 'client')) {
			Yii::$app->getSession()->setFlash('hosting_alert', 'Уведомление успешно отправлено!');
			$log = new UsersLog();
			$log->logSave(Yii::$app->user->identity->id, 'Для хостинга '.$model->domain.' (ID :'.$model->id.') отправлено ручное уведомление');
		} else {
			Yii::$app->getSession()->setFlash('hosting_alert', 'К сожалению, отправка уведомления не удалась.');
			Yii::$app->getSession()->setFlash('hosting_alert_status', 'warning');
		}
		return $this->redirect(['view', 'id' => $id]);
	}
	
	public function actionControl()
	{
		Yii::info('Запуск Hosting Control System.', 'hosting');
		
		$arHostings = Yii::$app->db->createCommand('SELECT * FROM `information` WHERE hosting_state = 1 AND paid_till > 0 AND paid_till <= '.(time() + 1209600).' ORDER BY paid_till')->queryAll();
		foreach ($arHostings as $hosting)
		{
			$model = $this->findModel($hosting['id']);
			
			switch ($hosting['notification_user'])
			{
				case 0:
					// Отправляем уведомление *2 недели* (notification_user = 1)				
					if ($model->sendNotification('2w', 'client')) {
						$model->updateAttributes(['notification_user' => 1]);
						Yii::info('Отправка первого (2 weeks) уведомления для хостинга '.$model->domain, 'hosting');
					} else {
						Yii::info('Отправка первого (2 weeks) уведомления для хостинга '.$model->domain.' не удалась.', 'hosting');
					}
					break;
				case 1:
					// Если до срока оплаты осталось 2 дня, то отправляем уведомление *2 дня* (notification_user = 2)
					if ($hosting['paid_till'] <= time() + 172800) {
						if ($model->sendNotification('2d', 'client')) {
							$model->updateAttributes(['notification_user' => 2]);
							Yii::info('Отправка второго (2 days) уведомления для хостинга '.$model->domain, 'hosting');
						} else {
							Yii::info('Отправка второго (2 days) уведомления для хостинга '.$model->domain.' не удалась.', 'hosting');
						}
					}
					break;
				case 2:
					// Если пора выключать хостинг и "заморозка" есть, то отправляем уведомление "заморозка* клиенту и админу (notification_user = 3, notification_admin = 1)
					// Если пора выключать хостинг и нет "заморозки", то отправляем уведомление "выключение* админу (hosting_state = 0, notification_admin = 2)
					if ($hosting['paid_till'] <= time()) {
						if ($hosting['hosting_freeze'] == 1) {
							if ($model->sendNotification('user_freeze_s', 'client')) {
								$model->updateAttributes(['notification_user' => 3]);
								Yii::info('Отправка уведомления об активации заморозки для хостинга '.$model->domain, 'hosting');
							} else {
								Yii::info('Отправка уведомления об активации заморозки для хостинга '.$model->domain.' не удалась.', 'hosting');
							}
							if ($model->sendNotification('adm_freeze_s', 'admin')) {
								$model->updateAttributes(['notification_admin' => 1]);
								Yii::info('Отправка уведомления администратору об активации заморозки для хостинга '.$model->domain, 'hosting');
							} else {
								Yii::info('Отправка уведомления администратору об активации заморозки для хостинга '.$model->domain.' не удалась.', 'hosting');
							}
						} else {
							if ($model->sendNotification('off', 'admin')) {
								$model->updateAttributes(['hosting_state' => 0, 'notification_admin' => 2]);
								Yii::info('Хостинг '.$model->domain.' помечен для отключения. Уведомление администратору отправлено.', 'hosting');
							} else {
								Yii::info('Не удалось пометить хостинг '.$model->domain.' на отключение.', 'hosting');
							}
						}
					}
					break;
				case 3:
					// Если время заморозки вышло, то отправляем уведомление *заморозка окончена* клиенту (hosting_freeze = 0, notification_user = 4) и уведомление *выключение* админу (hosting_state = 0, notification_admin = 2)
					if ($hosting['paid_till'] <= time() - 3600 * 24 * 5) {
						if ($model->sendNotification('user_freeze_f', 'client')) {
							$model->updateAttributes(['hosting_freeze' => 0, 'notification_user' => 4]);
							Yii::info('Отправка уведомления об окончании заморозки хостинга '.$model->domain, 'hosting');
						} else {
							Yii::info('Отправка уведомления об окончании заморозки хостинга '.$model->domain.' не удалась.', 'hosting');
						}
						if ($model->sendNotification('off', 'admin')) {
							$model->updateAttributes(['hosting_state' => 0, 'notification_admin' => 2]);
							Yii::info('Хостинг '.$model->domain.' помечен для отключения. Уведомление администратору отправлено.', 'hosting');
						} else {
							Yii::info('Не удалось пометить хостинг '.$model->domain.' на отключение.', 'hosting');
						}
					}
					break;
				case 4:
					// Этого условия у нас быть не должно, подстраховка
					Yii::info('Случилось невероятное для хостинга '.$model->domain.'!', 'hosting');
					break;
			}
		}
		
		Yii::info('Остановка Hosting Control System.', 'hosting');
	}

	protected function findModel($id)
	{
		if (($model = Hosting::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('Ничего не найдено.');
		}
	}
}
