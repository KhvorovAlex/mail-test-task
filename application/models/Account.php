<?php

namespace application\models;

use application\core\Model;

class Account extends Model {
	
	// Валидация формы
	public function validate($input, $post) {	
		$rules = [	
			'login' => [
				'pattern' => '#^[a-zA-Z0-9]{3,15}$#',
				'message' => 'Логин указан неверно (разрешены только латинские буквы и цифры от 3 до 15 символов'
			],
			'password' => [
				'pattern' => '#^[a-z0-9]{10,30}$#',
				'message' => 'Пароль указан неверно (разрешены только латинские буквы и цифры от 10 до 30 символов'
			]
		];
		// Проверка $rules
		foreach ($input as $val) {
			if (!isset($post[$val]) or !preg_match($rules[$val]['pattern'], $post[$val])) {
				$this->error = $rules[$val]['message'];
				return false;
			}
		}
		// Сравнение паролей
		if (isset($post['second-password'])) {
			if ($post['password'] !== $post['second-password']) {
				$this->error = 'Введенные пароли не совпадают';
				return false;
			}
		}
		return true;
	}

	// Проверка на совпадение логинов
	public function checkLoginExists($login) {
		$params = [
			'login' => $login,
		];
		if ($this->db->column('SELECT id FROM accounts WHERE login = :login', $params)) {
			$this->error = 'Этот логин уже используется';
			return false;
		}
		return true;
	}

	// Регистрация пользователя в БД
	public function register($post) {
		$params = [
			'id' => '',
			'login' => $post['login'],
			'password' => password_hash($post['password'], PASSWORD_BCRYPT)
		];
		$this->db->query('INSERT INTO accounts VALUES (:id, :login, :password)', $params);
	}

	// Проверка пароля от акаунта
	public function checkData($login, $password) {
		$params = [
			'login' => $login,
		];
		$hash = $this->db->column('SELECT password FROM accounts WHERE login = :login', $params);
		if (!$hash or !password_verify($password, $hash)) {
			return false;
		}		
		return true;
	}

	// Проверка сообщений
	public function checkMessage($message) {
		if (!$message) {
			$this->error = 'Нет новых сообщений';
			return false;
		}
		return true;
	}

	// Проверка нового сообщения
	public function chekNewMessage($uid) {
		$params = [
			'uid' => $uid,
		];	
		$data = $this->db->row('SELECT count(CASE
													WHEN user_message.message_status>0 THEN 1
													ELSE NULL
											END) as new_message 
								FROM
									user_message
								WHERE 
									uid = :uid', $params);
		$_SESSION['account']['new_message'] = $data[0]['new_message'];
	}

	// Получаем данные пользователя
	public function login($login) {
		$params = [
			'login' => $login,
		];	
		$data = $this->db->row('SELECT  
										accounts.id, 
										accounts.login, 
										count(user_message.message_body) as message,
										count(CASE
													WHEN user_message.message_status>0 THEN 1
													ELSE NULL
											   END) as new_message
								FROM
										accounts
								LEFT JOIN 
										user_message 
								ON 
										accounts.id = user_message.uid 
								WHERE 
									login = :login', $params);
		$_SESSION['account'] = $data[0];
	}

	// Получаем сообщения пользователя
	public function getMessage($login) {
		$params = [
			'login' => $login,
		];
		return $this->db->row('SELECT * FROM user_message JOIN accounts ON user_message.uid = accounts.id WHERE login = :login', $params);
	}

	// Получаем данные сообщения
	public function messageData($uid, $message_number) {
		$params = [
			'uid' => $uid,
			'message_number' => $message_number
		];
		return $this->db->row('SELECT * FROM user_message WHERE uid = :uid and message_number = :message_number' , $params)[0];
	}

	// Проверка существования сообщения
	public function isMessageExists($uid, $message_number) {
		$params = [
			'uid' => $uid,
			'message_number' => $message_number
		];
		return $this->db->column('SELECT id FROM user_message WHERE uid = :uid and message_number = :message_number', $params);
	}

	// Получаем данные сообщения
	public function readMessage($uid, $message_number) {
		$params = [
			'uid' => $uid,
			'message_number' => $message_number
		];
		$this->db->query('UPDATE user_message SET message_status = 0 WHERE uid = :uid and message_number = :message_number', $params);
	}
}