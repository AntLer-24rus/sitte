<?php

/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 11.01.2015
 * Time: 21:07
 */
class Invoice extends Model
{

    public function getAllInvoices()
    {
        $sql = "SELECT * FROM invoices INNER JOIN contractors on contractors.id = invoices.contractors";
        $query = $this->db->prepare($sql);
        // fetchAll() is the PDO method that gets all result rows
        $query->execute();
        return $query->fetchAll();
    }

    public function getALLContractors()
    {
        $sql = "SELECT * FROM contractors";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getDayInvoices(DateTime $date)
    {
        $sql = "SELECT group_concat(invoices.id) AS ids, name, SUM(sum) AS t_sum, SUM(sum_VAT) AS t_sum_VAT, payed
                FROM invoices JOIN contractors ON invoices.contractors = contractors.id
                WHERE date_pay = :date_pay GROUP BY contractors.id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':date_pay' => $date->format('Y-m-d')));
        $res = $query->fetchAll();
        return $res;
    }

    public function getMonthInvoices(DateTime $date, $contractor_id)
    {
        $sql = "SELECT SUM(sum) as sum_of_day,SUM(sum_VAT) as sum_VAT_of_day, DAY(date_pay) as day, payed
                FROM invoices INNER JOIN contractors on contractors.id = invoices.contractors
                WHERE MONTH(date_pay) = MONTH(:date_pay)
                  AND YEAR(date_pay) = YEAR(:date_pay)" .
            (!empty($contractor_id) ? " AND contractors.id = :contractor_id " : " ") .
            "GROUP BY date_pay";
        $query = $this->db->prepare($sql);
        $query->execute(array(
            ':date_pay' => $date->format('Y-m-d'),
            ':contractor_id' => $contractor_id
        ));
        $res = $query->fetchAll();
        return $res;

    }
}