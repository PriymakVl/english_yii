<?php

namespace app\controllers;

use Yii;

class BaseController extends \yii\web\Controller
{
	public $session;
	public $request;

	public function init()
	{
		$this->request = Yii::$app->request;
		$this->session = Yii::$app->session;
        $this->session->open();
	} 

	public function setMessage($text, $type = 'success')
	{
		Yii::$app->session->setFlash($type, $text);
		return $this;
	} 

	public function back()
	{
		return $this->redirect($this->request->referrer);
	}

	public function registerMetaTags($object) 
	{
		$this->view->title = $object->meta_title ? $object->meta_title : $object->name;
		$this->view->registerMetaTag(['name' => 'description', 'content' => $object->meta_description]);
		$this->view->registerMetaTag(['name' => 'keywords', 'content' => $object->meta_description]);
	}
}
