<?php

namespace application\core;

use application\core\View;

class Router {

    protected $routes = [];
    protected $params = [];
	
	// Подключаем маршруты и пеебеираем их в цикле 
    public function __construct() {
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

	// Преобразовываем мышшруты в регулярные выражения
    public function add($route, $params) {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^'.$route.'$#';
		$this->routes[$route] = $params;	
    }

	// Проверка совпадений маршрута
    public function match() {
		$url = trim($_SERVER['REQUEST_URI'], '/');          // Получаем строку браузера удаляя первый символ
        foreach ($this->routes as $route => $params) {      // Запускаем цикл перебора маршрутов
			if (preg_match($route, $url, $matches)) {       // Ищем совпадения
				foreach ($matches as $key => $match) {      // Перебираем $matches
					if (is_string($key)) {                  // если КЛЮЧ объекта строка, то в парамс добавим новое значение $params[$key] = $match;
						if (is_numeric($match)) {           // если ЗНАЧЕНИЕ объекта является числом или строкой преобразуем $match в число
							$match = (int) $match;
						}
						$params[$key] = $match;
					}
				}
				$this->params = $params;
				return true;
			}
		}
		return false;
	}

	// Запуск Роутера
    public function run(){
        if ($this->match()) {                                                                            // Если match вернул тру, создаем путь к контроллеру
            $path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'].'Action';                                               // Создаем название метода в контроллере
                if (method_exists($path, $action)) {                                                      // Проверяем его наличи в контроллере
					$controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

}