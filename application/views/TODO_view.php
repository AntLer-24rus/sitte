<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 29.02.16
 * Time: 12:45
 */
if (isset($data)) {
    echo "<div>TODO: " . $data . "</div>" ;
} else {
    echo "<div>TODO</div>";
}
require_once CORE_PATH . 'gibberish-aes.php';
$key = hash('sha256', 'AntLer:205317');
$data = 'Hello world';
$iv = hash('md5', '205317:AntLer');
echo ' PHP Key:<div id="PHPKey">' . $key . '</div>';
echo ' PHP iv:<div id="PHPiv">' . $iv . '</div>';
echo ' AES PHP:<div id="crypt">' . openssl_encrypt($data,'AES-256-CBC',hex2bin($key), false, hex2bin($iv)) . '</div>';

echo exec('openssl enc -aes-256-cbc -in infile -out outfile -pass pass:"Secret Passphrase" -e -base64');

$key = '59b6ab46d379b89d794c87b74a511fbd59b6ab46d379b89d794c87b74a511fbd';
$iv = '0aaff094b6dc29742cc98a4bac8bc8f9';