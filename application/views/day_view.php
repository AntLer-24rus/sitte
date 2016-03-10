
<script type="text/javascript">
    $(document).ready(function() {  // 1 строка
        $("tr").mouseover(function (){  // 2 строка
            $(this).css("background-color","#e6e6e8"); //3 строка
        }).mouseout(function (){
            $(this).css("background-color","transparent");
        }).mousedown(function (){
            if($(this).get(0).childElementCount == 1) {
                $(this).css("background-color","red");
            }
        });
    });
</script>
<?php
if ($data) {?>
    <table class="day_invoices">
        <tr>
            <th id="num">Номер входящий</th>
            <th id="num">Номер внутренний</th>
            <th id="contractor">Поставщик</th>
            <th id="sum">Сумма</th>
            <th id="sum">Сумма НДС</th>
            <th id="date">Дата</th>
            <th id="date">Дата платежа</th>
            <th id="date_create">Дата создания</th>
            <th id="address">Адрес</th>
        </tr>
        <?php
        foreach($data as $item) {
            foreach ($item['rows'] as $row) {
                echo '<tr>';
                echo    '<td>' . $row->num_in . '</td>';
                echo    '<td>' . $row->num_out . '</td>';
                echo    '<td>' . $row->name . '</td>';
                echo    '<td style="text-align: right">' . number_format($row->sum,2,',',' ') . '</td>';
                echo    '<td style="text-align: right">' . number_format($row->sum_VAT,2,',',' ') . '</td>';
                echo    '<td style="text-align: right">' . date_format(date_create($row->date), 'd.m.y') . '</td>';
                echo    '<td style="text-align: right">' . date_format(date_create($row->date_pay), 'd.m.y') . '</td>';
                echo    '<td style="text-align: right">' . date_format(date_create($row->date_create), 'd.m.y - H:m:s') . '</td>';
                echo    '<td>' . $row->address . '</td>';
                echo '</tr>';
            }
            echo '<tr>';
            echo    '<td colspan="9" id="total_contractor"><h1>' . $item['total']->name . '</h1><h1>Итого сумма: ' . number_format($item['total']->total_sum,2,',',' ') . ' руб. НДС: ' . number_format($item['total']->total_sum_VAT,2,',',' ') . ' руб.</h1></td>';
            echo '</tr>';
        }
        ?>
    </table>
<?php
} else {
    echo '<h3>Счетов на ' . (new DateTime('now'))->format('d.m.y') . ' нет!</h3>';
}