<!-- 
fixes_regist.php 
作成者：OriginPeastar
作成日：2025/07/19
-->

<?php
session_start();

if (isset($_POST["point_x"]) && isset($_POST["point_y"])) {
    try {
        $pdo = new PDO(
            "mysql:host=localhost;dbname=valofix;",
            "root",
            "",
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );

        if ($_POST["register_type"] === "fix") {

            $sql = "INSERT INTO agent_fixes 
            (user_id, map_id, agent_id, point_x, point_y, comment, url)
            VALUES 
            (:user_id, :map_id, :agent_id, :point_x, :point_y, :comment, :url)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id', $_POST['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':map_id', $_POST['map_id'], PDO::PARAM_INT);
            $stmt->bindValue(':agent_id', $_POST['agent_id'], PDO::PARAM_INT);
            $stmt->bindValue(':point_x', $_POST['point_x']);
            $stmt->bindValue(':point_y', $_POST['point_y']);
            $stmt->bindValue(':comment', $_POST['comment'] ?? '', PDO::PARAM_STR);
            $stmt->bindValue(':url', $_POST['url'] ?? '', PDO::PARAM_STR);
            $stmt->execute();
            header("Location: main.php");
        } else if ($_POST["register_type"] === "macro") {

            $sql = "INSERT INTO common_macros 
            (user_id, map_id, point_x, point_y, comment, url)
            VALUES 
            (:user_id, :map_id, :point_x, :point_y, :comment, :url)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':map_id', $_POST['map_id'], PDO::PARAM_INT);
            $stmt->bindValue(':point_x', $_POST['point_x'], PDO::PARAM_STR);
            $stmt->bindValue(':point_y', $_POST['point_y'], PDO::PARAM_STR);
            $stmt->bindValue(':comment', $_POST['comment'] ?? '', PDO::PARAM_STR);
            $stmt->bindValue(':url', $_POST['url'] ?? '', PDO::PARAM_STR);
            $stmt->execute();
            header("Location: main.php");
        }
    } catch (Exception $e) {
        echo "エラー: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "位置が指定されていません。";
}
?>