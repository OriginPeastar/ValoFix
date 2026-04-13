<!--
logout.php
作成者：OriginPeastar
作成日：2025/07/19
-->

<?php
session_start();
$_SESSION = []; //全部削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy();
header("Location: index.php");
exit;
?>