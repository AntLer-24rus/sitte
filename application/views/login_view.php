<form id="userpass" onsubmit="return false" xmlns="http://www.w3.org/1999/html">
    <input name="login" id="login" placeholder="Логин" type="text" class="edit_fild" <?php
    if (isset($_POST['login'])) {
        echo 'value = "' . $_POST['login'] . '""';
    }
    ?>/>
    <input name="pass" id="pass" placeholder="Пароль" type="password" class="edit_fild"/>
    <button type="submit" class="action" title="">Войти</button>
</form>
<div class="userpic_message">
    <?php
    if (isset($data)) {
        echo $data;
    }
    ?>
</div>
</div>