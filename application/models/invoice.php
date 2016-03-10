<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 11.01.2015
 * Time: 21:07
 */
class Invoice extends Model {

    public function getAllInvoices() {
        $sql = "SELECT * FROM invoices INNER JOIN contractors on contractors.id = invoices.contractors";
        $query = $this->db->prepare($sql);
        // fetchAll() is the PDO method that gets all result rows
        $query->execute();
        return $query->fetchAll();
    }
    public function getDayInvoices(DateTime $date) {
        $sql = "SELECT invoices.contractors, contractors.name, SUM(sum) as total_sum,SUM(sum_VAT) as total_sum_VAT
                FROM invoices INNER JOIN contractors on contractors.id = invoices.contractors
                WHERE date_pay = :date_pay
                GROUP BY contractors.id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':date_pay' => $date->format('Y-m-d')));
        $result = $query->fetchAll();
        $res = array();
        foreach ($result as $row) {
            $sql = "SELECT *
                    FROM invoices, contractors
                    WHERE invoices.contractors = contractors.id AND contractors = :contractor AND date_pay = :date_pay";
            $query = $this->db->prepare($sql);
            $query->execute(array(':contractor' => $row->contractors,':date_pay' => $date->format('Y-m-d')));
            $result = $query->fetchAll();
            array_push($res,array('rows' => $result, 'total' => $row));
        }
        return $res;
    }
}