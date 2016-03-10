<?php

class Route {

    /** @var null The controller part of the URL */
    private $url_controller;
    /** @var null The method part (of the above controller) of the URL */
    private $url_action;

    public function __construct()
    {
        $this->splitUrl();

        // проверка контроллера: url_controller НЕ пустой ?
        if ($this->url_controller) {
            // проверка контроллера: наличие одноименного файла в папке CONTROLLER_PATH ?
            if (file_exists(CONTROLLER_PATH . $this->url_controller . '.php')) {
                // подключение файла и создание контроллера
                require CONTROLLER_PATH . $this->url_controller . '.php';
                try {
                    $this->url_controller = new $this->url_controller();
                } catch (Exception $e) {
                    $data = 'Выброшено исключение: '.  $e->getMessage(). "\n";
                    include VIEWS_PATH.'test_view.php';
                    return;
                }

                // проверка метода: url_action НЕ пустой ?
                if ($this->url_action) {
                    // проверка метода: наличие метода у класса url_controller ?
                    if (method_exists($this->url_controller, $this->url_action)) {
                        // вызов метода
                        $this->url_controller->{$this->url_action}();
                    } else {
                        // перенаправление пользователя на страницу с ошибкой
                        $this->ErrorPage404();
                    }
                } else {
                    // вызов стандартного метода index()
                    $this->url_controller->index();
                }
            } else {
                // перенаправление пользователя на страницу с ошибкой
                $this->ErrorPage404();
            }
        } else {
            // пустой url_controller, перенаправляем на страницу Now
//            require CONTROLLER_PATH . 'Now.php';
//            $controller = new Now();
//            $controller->index();
            header('Location:'.URL.'main');
        }
    }

    /**
     * Перенаправление на страничку NotFound
     */
    private function ErrorPage404()
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.URL.'NotFound');
    }

    /**
     * Получение и разделение URL
     */
    private function splitUrl()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            // split URL
            $url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
            $url = parse_url($url,PHP_URL_PATH);
            $url = ltrim($url, '/');
            $url = explode('/', $url);

            $this->url_controller = (isset($url[0]) ? $url[0] : null);
            $this->url_action = (isset($url[1]) ? $url[1] : null);
        }
    }
} 