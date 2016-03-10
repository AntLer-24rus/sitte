<table>
    <tr>
        <th>Номер входящий</th>
        <th>Номер внутренний</th>
        <th>Поставщик</th>
        <th>Сумма</th>
        <th>Сумма НДС</th>
        <th>Дата</th>
        <th>Дата платежа</th>
        <th>Дата создания</th>
        <th>Адрес</th>
    </tr>
    <?php
        if ($data) {
            foreach($data as $row) {
                echo '<tr>';
                echo    '<td id="num">' . $row->num_in . '</td>';
                echo    '<td id="num">' . $row->num_out . '</td>';
                echo    '<td id="contractor">' . $row->name . '</td>';
                echo    '<td id="sum">' . number_format($row->sum,2,',',' ') . '</td>';
                echo    '<td id="sum">' . number_format($row->sum_VAT,2,',',' ') . '</td>';
                echo    '<td id="date">' . date_format(date_create($row->date), 'd.m.y') . '</td>';
                echo    '<td id="date">' . date_format(date_create($row->date_pay), 'd.m.y') . '</td>';
                echo    '<td id="date_create">' . date_format(date_create($row->date_create), 'd.m.y - H:m:s') . '</td>';
                echo    '<td id="address">' . $row->address . '</td>';
                echo '</tr>';
            }
        } else {
            echo 'No notes yet. Create some !';
        }
    ?>
</table>