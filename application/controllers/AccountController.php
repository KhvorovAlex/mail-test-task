<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller {

	// Регистрация
	public function registerAction() {
		if (!empty($_POST)) {
			if (!$this->model->validate(['login', 'password'], $_POST)) {
				$this->view->message('error', $this->model->error);
			}		
			elseif (!$this->model->checkLoginExists($_POST['login'])) {
				$this->view->message('error', $this->model->error);
			}
			$this->model->register($_POST);
			$this->view->message('success', 'Регистрация завершена успешно!');
		}
		$this->view->render('Регистрация');
	}

	// Вход
	public function loginAction() {
		if (!empty($_POST)) {
			if (!$this->model->validate(['login', 'password'], $_POST)) {
				$this->view->message('error', $this->model->error);
			}
			elseif (!$this->model->checkData($_POST['login'], $_POST['password'])) {
				$this->view->message('error', 'Логин или пароль указан неверно');
			}
			$this->model->login($_POST['login']);
			$this->view->location('account/profile');
		}
		$this->view->render('Вход');
	}

	// Профиль
	public function profileAction() {
		if (!empty($_POST)) {
			if (!$this->model->checkMessage($_POST['message'])){
				$this->view->message('error', $this->model->error);
			}
			$this->view->location('account/messages');
		}	
		$this->model->chekNewMessage($_SESSION['account']['id']);
		$this->view->render('Профиль');
	}

	// Выход из профиля
	public function logoutAction() {
		unset($_SESSION['account']);
		$this->view->redirect('account/login');
	}
	
	// Сообщения
	public function messagesAction(){
		$vars = [
			'data' => $this->model->getMessage($_SESSION['account']['login'])
		];
		$this->view->render('Все сообщения', $vars);
	}

	// Сообщение
	public function messageAction(){
		if (!$this->model->isMessageExists($_SESSION['account']['id'], $this->route['id'])){
			$this->view->errorCode(404);
		}
		$this->model->readMessage($_SESSION['account']['id'], $this->route['id']);
		$vars = [
			'data' => $this->model->messageData($_SESSION['account']['id'], $this->route['id'])
		];		
		$this->view->render('Сообщение', $vars);
	}
}