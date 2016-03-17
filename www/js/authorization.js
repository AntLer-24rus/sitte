/**
 * Created by Антон on 21.01.16.
 */

function base64_decode( data ) {	// Decodes data encoded with MIME base64
    //
    // +   original by: Tyler Akins (http://rumkin.com)


    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i=0, enc='';

    do {  // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));

        bits = h1<<18 | h2<<12 | h3<<6 | h4;

        o1 = bits>>16 & 0xff;
        o2 = bits>>8 & 0xff;
        o3 = bits & 0xff;

        if (h3 == 64)	  enc += String.fromCharCode(o1);
        else if (h4 == 64) enc += String.fromCharCode(o1, o2);
        else			   enc += String.fromCharCode(o1, o2, o3);
    } while (i < data.length);

    return enc;
}

function hex2a(hex) {
    var str = '';
    for (var i = 0; i < hex.length; i += 2)
        str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
    return str;
}

$(document).ready(function(){

    var rawData = atob($('#crypt').text());

    var crypttext = btoa(rawData.substr(16));

    var iv = CryptoJS.enc.Hex.parse(md5('205317:AntLer'));
    var key = CryptoJS.enc.Hex.parse(sha256('AntLer:205317'));

    var encrypted = CryptoJS.AES.encrypt('Hello world', key,
        {
            iv: iv,
            mode: CryptoJS.mode.CBC,
            keySize: 256/32
        });

    var decrypted = CryptoJS.AES.decrypt($('#crypt').text(), key,
        {
            iv: iv,
            mode: CryptoJS.mode.CBC,
            //padding: CryptoJS.pad.NoPadding,
            keySize: 256/32
        });
    //var decrypted = CryptoJS.AES.decrypt($('#crypt').text(),key);
    console.log('encrypted');
    console.log('   ciphertext ' + encrypted.ciphertext.toString());
    console.log('   iv ' + encrypted.iv.toString());
    console.log('   key ' + encrypted.key.toString());
    console.log('   salt ' + encrypted.salt);
    console.log('decrypted');
    //console.log('   cleartext ' + decrypted.toString(CryptoJS.enc.Utf8));
    //$('#page')
    //    .append('AES JS:')
    //    .append($('<div>').attr('id','JSKey').text(encrypted))
    //    .append($('<div>').attr('id','aes').text('Res - ' + decrypted.toString(CryptoJS.enc.Utf8)));
        //.append($('<div>').text(GibberishAES.dec(cr, key)))
    //    .append($('<div>').text(GibberishAES.dec(crypt, key)));
});
$('.userpic')
    .on('submit', function () {
        $.ajax({
            type: 'POST',
            url: 'login/login',
            data: $('#userpass').serialize(),
            success: function (data) {
                $('.userpic').empty().append(data);
                $('ul.menu li a:contains("В диапазоне")').parent().remove();
                $('ul.menu').append($('<li>').append($('<a>').attr('href', '/range').text('В диапазоне')));
                if (location.pathname == '/range') {
                    $('ul.menu li a:contains("В диапазоне")').addClass('selected');
                    $('#page').text('test');
                }
                if (location.pathname == '/all') {
                    $('ul.menu li a:contains("Все")').addClass('selected');
                    $.ajax({
                        type: 'GET',
                        url: 'all/content',
                        success: function (data) {
                            $('#page').empty().append(data);
                        }
                    });
                }
            },
            error: function (httpR, stat, errT) {

                switch (httpR.status) {
                    case 400:
                    {
                        $('.userpic').empty().append(httpR.responseText);
                        break;
                    }
                    case 401:
                    {
                        $('.userpic').empty().append(httpR.responseText);
                        break;
                    }
                    default:
                    {
                        $('.userpic').empty().append(httpR.responseText);
                    }
                }
                $('.userpic_message').css('display', 'initial');
            }
        });
    })
    .on('click', '#logout_bt', function () {
        $.ajax({
            url: 'login/logout',
            success: function (data) {
                $('.userpic_message').css('display', 'none');
                $('.userpic').empty().append(data);
                if (location.pathname == '/range' || location.pathname == '/all') {
                    $('#page').empty();
                }
                if (location.pathname == '/all') {
                    $('ul.menu li a:contains("Все")').addClass('selected');
                    $.ajax({
                        type: 'GET',
                        url: 'all/content',
                        success: function (data) {
                            $('#page').empty().append(data);
                        }
                    });
                }
            },
            error: function (httpR, stat, errT) {
                $('.userpic_message').css('display', 'initial').text('Ошибка ' + stat + ' ' + errT);
            }
        });
    });




