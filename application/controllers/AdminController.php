<?php

namespace application\controllers;

use application\core\Controller;

class AdminController extends Controller {

	public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'admin';
	}

	// Вход
	public function loginAction() {
		if (isset($_SESSION['admin'])) {
			$this->view->redirect('admin/add');
		}
		if (!empty($_POST)) {
			if (!$this->model->loginValidate($_POST)) {
				$this->view->message('error', $this->model->error);
			}
			$_SESSION['admin'] = true;
			$this->view->location('admin/add');
		}
		$this->view->render('Вход');
	}

	// Отправка сообщения пользователю
	public function addAction() {
		if (!empty($_POST)) {	
			if (!$this->model->messageValidate($_POST['message-text'])) {
				$this->view->message('error', $this->model->error);
			}
			$this->model->messageAdd($_POST);		
			$this->view->message('success', 'Сообщение отправлено');
		}
		$vars = [
			'data' => $this->model->getUsersData()
		];	
		$this->view->render('Отправить сообщение', $vars);
		
	}

	// Выход из профиля
	public function logoutAction() {
		unset($_SESSION['admin']);
		$this->view->redirect('admin/login');
	}

}