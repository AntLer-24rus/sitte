<div style="display: inline-block;text-align: left">
    <label for="month" style="display: block; text-align: center">Месяц: </label>
    <select id="month" style="display: block">
        <option value=0>Январь</option>
        <option value=1>Февраль</option>
        <option value=2>Март</option>
        <option value=3>Апрель</option>
        <option value=4>Май</option>
        <option value=5>Июнь</option>
        <option value=6>Июль</option>
        <option value=7>Август</option>
        <option value=8>Сентябрь</option>
        <option value=9>Октябрь</option>
        <option value=10>Ноябрь</option>
        <option value=11>Декабрь</option>
    </select>
</div>
<div style="display: inline-block;text-align: left">
    <label for="year" style="display: block; text-align: center">Год: </label>
    <input name="year" id="year" type="edit" value="2015" class="edit_fild">
</div>
<div style="display: inline-block;text-align: left">
    <label for="contractors" style="display: block; text-align: center">Поставщик: </label>
    <select id="contractors" style="display: block" disabled>
        <option value=0>Все</option>
    </select>
</div>
<div style="display: inline-block;text-align: left">
    <button id="upadate_bt" class="action" onclick="updateTable();popUpWindow('Загрузка . . . ');this.blur();">
        Получить
    </button>
</div>

<h2>Итого: <span id="MonthSum" value="33">0</span> руб. <br>
    в том числе НДС: <span id="MonthSumNDS" value="33">0</span> руб.</h2>

<table id="main_table" style="width: 100%">
    <?php
    for ($i = 1; $i <= 7; $i++) {
        echo "<tr>";
        for ($j = 1; $j <= 7; $j++) {
            echo "<td>";
            echo '<div class="cell ' . ($i == 1 ? 'cell_head' : '') . '""></div>';
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>

<div id="popup_window_background">
    <div id="popup_window">
        <h1 style="margin: 10pt auto">Загрузка . . .</h1>
    </div>
</div>