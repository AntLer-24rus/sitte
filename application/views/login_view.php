<input id="login" placeholder="Логин" type="text"
       class="edit_fild" <?php isset($_POST['login']) ? 'value = "' . $_POST['login'] . '""' : '""'; ?>/>
<input id="pass" placeholder="Пароль" type="password" class="edit_fild"/>
<button id="login_bt" class="action" onclick="login()">Войти</button>
<div class="userpic_message"><?php echo isset($data) ? $data : "" ?></div>
