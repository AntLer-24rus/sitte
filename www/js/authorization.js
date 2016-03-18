/**
 * Created by Антон on 21.01.16.
 */

function base64_decode(data) {	// Decodes data encoded with MIME base64
    //
    // +   original by: Tyler Akins (http://rumkin.com)


    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0, enc = '';

    do {  // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));

        bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

        o1 = bits >> 16 & 0xff;
        o2 = bits >> 8 & 0xff;
        o3 = bits & 0xff;

        if (h3 == 64)      enc += String.fromCharCode(o1);
        else if (h4 == 64) enc += String.fromCharCode(o1, o2);
        else               enc += String.fromCharCode(o1, o2, o3);
    } while (i < data.length);

    return enc;
}

function hex2a(hex) {
    var str = '';
    for (var i = 0; i < hex.length; i += 2)
        str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
    return str;
}

$(document).ready(function () {

});

function errorAjax(httpR, type_error) {
    switch (type_error) {
        case "error":
        {
            var response = JSON.parse(httpR.responseText);
            switch (httpR.status) {
                case 400:
                {
                    $('.userpic_message').text("Ошибка 400 : " + response.error_message).show();
                    break;
                }
                case 401:
                {
                    $('.userpic_message').text("Ошибка 401 : " + response.error_message).show();
                    break;
                }
                default:
                {
                    $('.userpic_message').text("Неизвестная ошибка").show();
                }
            }
            break;
        }
        default:
        {
            $('.userpic_message').text("Неизвестная ошибка").show();
            break;
        }
    }

}

$('.userpic')
    .on('submit', function () {
        $('.userpic_message').hide();
        var login = $('#login').val();
        var pass = $('#pass').val();
        if (login == "" || pass == "") {
            $('.userpic_message').text("Пустой логин или пароль").show();
        } else {
            $.ajax({
                type: 'POST',
                url: 'login/login',
                data: {data: {func: "step_one", arg: login}},
                dataType: "json",
                success: function (json_data) {
                    if (json_data.success) {
                        var rawData = atob(json_data.hash);

                        var iv = CryptoJS.enc.Hex.parse(rawData.split(":")[0]);
                        var rnd_key_encoded = rawData.split(":")[1];
                        var key = CryptoJS.enc.Hex.parse(sha256(login + ":" + pass));

                        var rnd_key = CryptoJS.AES.decrypt(rnd_key_encoded, key, {iv: iv}).toString(CryptoJS.enc.Utf8);

                        if (rnd_key == "") {
                            $('#pass').val("");
                            $('.userpic_message').text("Неверный логин или пароль").show();
                        } else {
                            var crypt_pwd = CryptoJS.AES.encrypt(pass, CryptoJS.enc.Hex.parse(rnd_key), {iv: CryptoJS.lib.WordArray.random(128 / 8)});

                            var verification = CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(crypt_pwd.iv.toString() + ':' + crypt_pwd.toString()));

                            $.ajax({
                                type: 'POST',
                                url: 'login/login',
                                data: {data: {func: "step_two", arg: verification}},
                                dataType: "json",
                                success: function (json_data) {
                                    if ("userpic_view" in json_data) {
                                        $('.userpic').empty().append(json_data.userpic_view);
                                        $('.userpic_message').show();
                                    }
                                }
                            });
                        }

                    } else {
                        if ("userpic_view" in json_data) {
                            $('.userpic').empty().append(json_data.userpic_view);
                            $('.userpic_message').show();
                        } else {
                            $('.userpic_message').text("Неизвестная ошибка").show();
                        }
                    }
                },
                error: errorAjax
            });
        }
    })
    .on('click', '#logout_bt', function () {
        $.ajax({
            url: 'login/logout',
            dataType: "json",
            success: function (json_data) {
                if ("userpic_view" in json_data) {
                    $('.userpic').empty().append(json_data.userpic_view);
                    $('.userpic_message').show();
                } else {
                    $('.userpic_message').text("Неизвестная ошибка").show();
                }
            },
            error: errorAjax
        });
    });




