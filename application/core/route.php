<?php

class Route
{

    /** @var Controller The controller part of the URL */
    private $url_controller;
    /** @var null The method part (of the above controller) of the URL */
    private $url_action;

    private $url_path = "";

    public function __construct()
    {
        $this->splitUrl();

        // проверка контроллера: url_controller НЕ пустой ?
        if ($this->url_controller) {
            try {
                $this->url_controller = new $this->url_controller();
            } catch (Exception $e) {
                $this->ErrorPage('500');
                $data = "Выброшено исключение:\n" . $e->getMessage();
                include VIEWS_PATH . 'test_view.php';
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
                    $this->ErrorPage('404');
                }
            } else {
                // вызов стандартного метода index()
                $this->url_controller->index();
            }
        } else {
            // пустой url_controller, перенаправляем на главную страницу
            //header('Location:'.URL.'main');
            (new Main())->index();
        }
    }

    /**
     * Получение и разделение URL
     */
    private function splitUrl()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            // split URL
            $url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
            $url = parse_url($url, PHP_URL_PATH);
            $url = ltrim($url, '/');
            $url = explode('/', $url);

            foreach ($url as $item) {
                if (is_dir(CONTROLLER_PATH . $this->url_path . $item)) {
                    $this->url_path .= $item . "/";
                } elseif (is_file(CONTROLLER_PATH . $this->url_path . $item . ".php") & empty($this->url_controller)) {
                    $this->url_controller = $item;
                } elseif (!empty($this->url_controller) & empty($this->url_action)) {
                    $this->url_action = $item;
                } else {
                    $this->ErrorPage('404');
                }
            }
        }
    }

    /**
     * Перенаправление на страничку ошибки
     * @param $errCode
     */
    private function ErrorPage($errCode)
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        (new ErrorPage())->generatePage($errCode);
        exit();
    }
} 