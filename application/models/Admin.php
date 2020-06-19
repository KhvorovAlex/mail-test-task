<?php

namespace application\models;

use application\core\Model;

class Admin extends Model {

	public function loginValidate($post) {
		$config = require 'application/config/admin.php';
		if ($config['login'] != $post['login'] or $config['password'] != $post['password']) {
			$this->error = 'Логин или пароль указан неверно';
			return false;
		}
		return true;
	}

	// Проверка длины сообщения
	public function messageValidate($message) {
		$textLen = iconv_strlen($message);
		if ($textLen < 10 or $textLen > 5000) {
			$this->error = 'Текст сообщения должнен содержать от 10 до 5000 символов';
			return false;
		}	
		return true;
	}

	// Отправка сообщения
	public function messageAdd($post) {
		$params = [
			'id' => '',
			'uid' => $post['user'],
			'message' => $post['message-text'],
			'message_status' => 1,
			'message_number' => $this->db->getLastMessageNumber('SELECT MAX(message_number) FROM user_message WHERE uid = '.$post['user'].'') + 1
		];		
		$this->db->query('INSERT INTO user_message VALUES (:id, :uid, :message, :message_status, :message_number)', $params);
	}

	// Провека есть ли пользователи в базе данных
	public function getUsersData() {
		return $this->db->row('SELECT login, id FROM accounts');
	}



}