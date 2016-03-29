//-----------------------------------------------------------------------------------------------------------------------//
function triads(dig, sep, dot, frac) {
    sep = sep || String.fromCharCode(160);
    dot = dot || ',';
    if (typeof frac == 'undefined') frac = 2;

    var num = parseInt(dig).toString();

    var reg = /(-?\d+)(\d{3})/;

    while (reg.test(num))
        num = num.replace(reg, '$1' + sep + '$2');

    if (!frac)
        return num;

    var a = dig.toString();
    if (a.indexOf('.') >= 0) {
        a = a.toString().substr(a.indexOf('.') + 1, frac);
        a += new Array(frac - a.length + 1).join('0');
    }
    else
        a = new Array(frac + 1).join('0');

    return num + dot + a;
};
//-----------------------------------------------------------------------------------------------------------------------//
function getLastDay(month, year) {
    month++;
    var date = new Date(year, month++, 0);
    return date.getDate();
}
//-----------------------------------------------------------------------------------------------------------------------//
function getFirstWeekDay(month, year) {
    var firstDay = new Date(year, month, 1);
    var day = firstDay.getDay();
    return (day == 0) ? 7 : day;
}
//-----------------------------------------------------------------------------------------------------------------------//
function getWeekDay(month) {
    var day = (new Date()).getDay();
    if ((new Date()).getMonth() === Number(month)) {
        return (day == 0) ? 7 : day;
    } else {
        return 0;
    }
}
//-----------------------------------------------------------------------------------------------------------------------//
var week_day = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];

$(document).ready(function () {
    $("#month").find("[value='" + new Date().getMonth() + "']").attr("selected", "selected");
    $("#year").attr("value", new Date().getFullYear());
    $.ajax({
        type: 'POST',
        url: 'invoices/allcontractors',
        // data: {data: {func: "step_one", arg: login}},
        dataType: "json",
        success: updateContractors,
        error: updateError
    });
    updateTable();
});


function updateContractors(json_data) {
    if (json_data.success) {
        $('#contractors').prop({disabled: false});
        if (json_data.contractors.length > 0) {
            json_data.contractors.forEach(function (item) {
                $('#contractors').append($('<option>').text(item.name).val(item.id));
            });
        }
    }
}
function updateError(httpR, type_error) {
    //TODO Написать обработчик ошибок запроса счетов
    alert('Error');
}

function updateTable() {
    var month = Number($('#month').find(':selected').val()) + 1;
    var year = $('#year').val();
    var contractor = $('#contractors').find(':selected').val();
    $('#main_table').empty();
    var days = 1;
    for (var i = 1; i <= 7; i++) {
        var tr = $('<tr>');
        for (var j = 1; j <= 7; j++) {
            var f = false;
            var td = $('<td>');
            var cell = $('<div>').addClass('cell');

            if (i > 1) cell.attr('id', 'day_' + days);
            if (i === 1) cell.addClass('cell_head');
            if (j > 5) cell.addClass('cell_dayoff');
            if (((days === new Date().getDate() && Number(month) === new Date().getMonth()) || (j === getWeekDay(month) && i === 1)) && (Number(year) === new Date().getFullYear())) cell.addClass('cell_now');

            if (i === 1) {
                cell.text(week_day[j - 1]);
                td.append(cell);
            }

            if ((i === 2 & j >= getFirstWeekDay(month, year)) || (i > 2 && days <= getLastDay(month, year))) {
                cell.append($('<h3>').text(days++));
                td.append(cell);
            }
            tr.append(td);
        }
        $('#main_table').append(tr);
    }
    $.ajax({
        type: 'POST',
        url: 'invoices/invoicesformonth',
        data: {month: month, year: year, contractor: contractor},
        dataType: "json",
        success: fillTable,
        error: updateError
    });
}
function checkDay() {
    var checkbox = $(this).children('input');
    checkbox.prop("checked", !checkbox.prop("checked"));
    $('#pay_bt').prop({disabled: $('#main_table input:checkbox:checked').length <= 0});

    var sums = checkbox.val().split(',');

    var currentSum = Number($('#MonthSum').text().replace(" ", "").replace(",", "."));
    var currentNDS = Number($('#MonthSumNDS').text().replace(" ", "").replace(",", "."));

    var sign = 0;
    if (checkbox.prop("checked")) {
        sign = 1;
    } else {
        sign = -1;
    }

    $('#MonthSum').text(triads(currentSum + sign * Number(sums[0]), ' ', ',', 2));
    $('#MonthSumNDS').text(triads(currentNDS + sign * Number(sums[1]), ' ', ',', 2));
}
function fillTable(json_data) {
    if (json_data.success) {
        $('#pay_bt').remove();
        if ($('#contractors :selected').text() !== 'Все') {
            $('#MonthSum').text(triads(0, ' ', ',', 2));
            $('#MonthSumNDS').text(triads(0, ' ', ',', 2));
            var payButtone = $('<button>')
                .addClass('action')
                .click(function () {
                    //TODO Вызов обработки оплаты
                    this.blur();
                })
                .prop({
                    id: "pay_bt",
                    disabled: true
                })
                .text('Оплатить')
                .css('margin', '5px 0px');
            $('#main_table').before(payButtone)
        } else {
            $('#MonthSum').text(triads(json_data.total_sum, ' ', ',', 2));
            $('#MonthSumNDS').text(triads(json_data.total_sum_VAT, ' ', ',', 2));
        }
        json_data.invoices.forEach(function (invoice) {

            var sum = $('<p>').text(triads(invoice.sum_of_day, ' ', ',', 2) + ' руб.').addClass('sum');
            var sumNDS = $('<p>').text(triads(invoice.sum_VAT_of_day, ' ', ',', 2) + ' руб.').addClass('sum');
            //var num_rows = $('<span>').addClass('num_rows').text(invoice.row).css('display','none');

            if ($('#contractors :selected').text() !== 'Все') {
                $('#day_' + invoice.day).append(sum).click(checkDay);
            } else {
                $('#day_' + invoice.day).append(sum).click(function () {
                    var day = Number($(this).find('h3').text());
                    popUpWindow('Загрузка . . .');

                    var cur_date = $("#year").val() + "-" + ($("#month :selected").val() + 1) + "-" + day;
                    $.ajax({
                        type: 'POST',
                        url: 'invoices/invoicesforday',
                        data: {date: cur_date},
                        dataType: "json",
                        success: function (json) {
                            $('#popup_window').empty().text(JSON.stringify(json));
                        },
                        error: updateError
                    });
                });
            }

            if ($('#contractors :selected').text() !== 'Все') {
                $('#day_' + invoice.day)
                    .prepend($('<input>')
                        .attr({
                            'type': 'checkbox',
                            'class': 'chbsn',
                            'value': invoice.sum_of_day + ',' + invoice.sum_VAT_of_day
                        })
                        .click(function (event) {
                            $(this).prop("checked", !$(this).prop("checked"));
                        })
                        .css('float', 'right'));
                $('#day_' + invoice.day).append(sumNDS);
            }
            if (invoice.payed) {
                sum.addClass('sum_paed');
                sumNDS.addClass('sum_paed');
                $('#day_' + invoice.day + ' input:checkbox').remove();
            }
        });
        $('#popup_window_background').remove();
    }
}

function popUpWindow(text) {
    var popUpWindow = $("<div>")
        .click(function (event) {
            event.stopPropagation();
        })
        .attr('id', 'popup_window')
        .append($('<h1>').text(text).css({'margin': '10pt auto'}));

    $("<div>")
        .attr('id', 'popup_window_background')
        //.click(function(){$('#popup_window_background').remove();})
        .append(popUpWindow)
        .appendTo("body");
    return $(popUpWindow);
}