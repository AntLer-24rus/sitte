<form id="userpass" onsubmit="return false">
    <input name="login" id="login" placeholder="Логин" type="text" class="edit_fild" <?php
    if (isset($_POST['login'])) {
        echo 'value = "' . $_POST['login'] . '""';
    }
    ?>/>
    <input name="pass" id="pass" placeholder="Пароль" type="password" class="edit_fild"/>
    <input type="submit" style="display: none"/>
</form>
<button id="login_bt" class="action">Войти</button>
<div class="userpic_message">
    <?php
    if (isset($data)) {
        echo $data;
    }
    ?>
</div>