function authorization_error(httpR, type_error) {
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

function authorization(json_data) {

    if (json_data.success) {
        var rawData = atob(json_data.hash);

        var iv = CryptoJS.enc.Hex.parse(rawData.split(":")[0]);
        var rnd_key_encoded = rawData.split(":")[1];
        var key = CryptoJS.SHA256($('#login').val() + ":" + $('#pass').val());

        var rnd_key = CryptoJS.AES.decrypt(rnd_key_encoded, key, {iv: iv}).toString(CryptoJS.enc.Utf8);

        if (rnd_key == "") {
            $('#pass').val("");
            $('.userpic_message').text("Неверный логин или пароль").show();
        } else {
            var crypt_pwd = CryptoJS.AES.encrypt($('#pass').val(), CryptoJS.enc.Hex.parse(rnd_key), {iv: CryptoJS.lib.WordArray.random(128 / 8)});

            var verification = CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(crypt_pwd.iv.toString() + ':' + crypt_pwd.toString()));

            $.ajax({
                type: 'POST',
                url: 'login/login',
                data: {data: {func: "step_two", arg: verification, cur_uri: location.pathname}},
                dataType: "json",
                success: authorization_success
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
}

function authorization_success(json_data) {
    if ("userpic_view" in json_data)  $('.userpic').empty().append(json_data.userpic_view);
    if ("tabs_from_menu" in json_data) $('.menu').empty().append(json_data.tabs_from_menu);
}

function login() {
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
            success: authorization,
            error: authorization_error
        });
    }
}




