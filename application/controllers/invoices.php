<?php

class Invoices extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->verifyUserPermission("/" . strtolower(__CLASS__))) {
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $this->view->append_view("access_denied_view");
                $this->view->render();
            } else {
                $out = array("success" => false, "error_message" => "access denied");
                echo json_encode($out);
            }
            exit();
        }
        $this->view->add_css(__CLASS__);
        $this->view->add_js(__CLASS__);
        $this->model = new Invoice($this);
    }

    /**
     * Обязательно иметь стандартный метод
     * @return void
     */
    public function index()
    {
        $this->view->append_view("invoices_view");
        $this->view->render();
    }

    public function allcontractors()
    {
        $response = array("success" => false);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $response["success"] = true;
            $response["contractors"] = $this->model->getALLContractors();
        } else {
            $response["error_message"] = "only post request";
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function invoicesformonth()
    {
        $response = array("success" => false);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!isset($_POST['month']) | !isset($_POST['year']) | !isset($_POST['contractor'])) {
                $response["error_message"] = "неверные параметры запроса";
            } else {
                $response["success"] = true;
                $date = new DateTime($_POST['year'] . "-" . $_POST['month'] . "-01", new DateTimeZone('Asia/Novosibirsk'));
                $response["invoices"] = $this->model->getMonthInvoices($date, $_POST['contractor']);
                $total_sum = 0;
                $total_sum_VAT = 0;
                foreach ($response["invoices"] as $key => $invoice) {
                    $response["invoices"][$key]['payed'] = boolval($response["invoices"][$key]['payed']);
                    $total_sum += $invoice["sum_of_day"];
                    $total_sum_VAT += $invoice["sum_VAT_of_day"];
                }
                $response["total_sum"] = $total_sum;
                $response["total_sum_VAT"] = $total_sum_VAT;
            }
        } else {
            $response["error_message"] = "only post request";
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function invoicesforday()
    {
        $response = array("success" => false);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!isset($_POST['date'])) {
                $response["error_message"] = "неверные параметры запроса";
            } else {
                $date = new DateTime($_POST['date'], new DateTimeZone('Asia/Novosibirsk'));
                $response["invoices"] = $this->model->getDayInvoices($date);
            }
        } else {
            $response["error_message"] = "only post request";
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}