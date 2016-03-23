<div style="margin-right: 10px; height: 28px;line-height: 28px">
    Здравствуйте, <?php echo $this->controller->session->getUserInfo("name"); ?></div>
<button class="action" onclick="location.href = '/login/logout'">Выйти</button>
<div class="userpic_message"></div>