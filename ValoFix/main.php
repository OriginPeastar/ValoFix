<!--
main.php
作成者：OriginPeastar
作成日：2025/07/19
-->

<?php

session_start();

if (!isset($_SESSION["user_id"])) {
  header("Location: index.php");
  exit;
}

//DB接続
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

//マップ一覧を取得
$stmt = $pdo->query("select * from maps ");
$mapList = $stmt->fetchAll();

//エージェント一覧を取得
$stmt = $pdo->query("select * from agents");
$agentList = $stmt->fetchAll();

//ユーザー、選択されたマップ、エージェント情報を取得
$user_id = $_SESSION["user_id"];
$map_id = $_SESSION["map_id"] ?? 1;
$agent_id = $_SESSION["agent_id"] ?? 1;

//マップ画像パス取得
$sql = "select image_path from maps where map_id = :map_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':map_id', $map_id, PDO::PARAM_INT);
$stmt->execute();
$map = $stmt->fetch();
$imagePath = $map['image_path'] ?? 'maps/notfound.png';

//agent_fixesのデータ取得
$sql = "select af.* from agent_fixes af join users u on af.user_id = u.user_id join maps m  on af.map_id = m.map_id join agents a on af.agent_id = a.agent_id where af.user_id = :user_id and af.map_id = :map_id and af.agent_id = :agent_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':map_id', $map_id, PDO::PARAM_INT);
$stmt->bindValue(':agent_id', $agent_id, PDO::PARAM_INT);
$stmt->execute();
$fixes = $stmt->fetchAll();

//common_macrosのデータ取得
$sql = "select cm.* from common_macros cm join users u on cm.user_id = u.user_id join maps m on cm.map_id = m.map_id where cm.user_id = :user_id and cm.map_id = :map_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':map_id', $map_id, PDO::PARAM_INT);
$stmt->execute();
$macros = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>valofix</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="main.css" rel="stylesheet">
</head>

<body>
  <article>
    <div class="side">
      <h2>Welcome, <?= htmlspecialchars($_SESSION["userName"]) ?> !</h2>
      <h3>user_id: <?= htmlspecialchars($_SESSION["user_id"]) ?></h3>
      <p>表示したいマップとエージェントを選択してください</p>
      <div>
        <form action="main.php" method="POST">
          マップ : <input list="mapList" type="text" id="mapInput" name="mapInput"><br>
          <datalist id="mapList">
            <?php foreach ($mapList as $maps) { ?>
              <option value="<?= htmlspecialchars($maps['map_name']) ?>"></option>
            <?php } ?>
          </datalist>
          エージェント : <input list="agentList" type="text" id="agentInput" name="agentInput"><br>
          <datalist id="agentList">
            <?php foreach ($agentList as $agents) { ?>
              <option value="<?= htmlspecialchars($agents['agent_name']) ?>"></option>
            <?php } ?>
          </datalist>
          <input type="submit" value="送信">
        </form><br>
      </div>
      <button type="button" class="btn btn-secondary" onclick="location.href='logout.php'">ログアウト</button>
    </div>
    <?php

    //POSTでデータが送られた場合のみ処理を実施
    if (!empty($_POST["mapInput"]) && !empty($_POST["agentInput"])) {
      try {

        //SQL文の実行準備と実行（stmt = statement)
        $sql = "select map_id from maps where map_name = :mapName;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':mapName', $_POST["mapInput"], PDO::PARAM_STR);
        $stmt->execute();
        $map = $stmt->fetch();


        $sql = "select agent_id from agents where agent_name = :agentName;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':agentName', $_POST["agentInput"], PDO::PARAM_STR);
        $stmt->execute();
        $agent = $stmt->fetch();

        if ($map && $agent) {
          session_regenerate_id(true);
          $_SESSION["map_id"] = $map["map_id"] ?? null;
          $_SESSION["agent_id"] = $agent["agent_id"] ?? null;
        } else {
          echo "指定されたマップまたはエージェントが見つかりません。";
          exit;
        }
        header("Location: main.php");
        exit;
      } catch (Exception $e) {
        print($e->getMessage() . "<br>");
      }
    }
    ?>

    <div class="content">
      <div class="map-container">
        <img src="<?= htmlspecialchars($imagePath) ?>" class="map-image" id="map">
        <?php foreach ($fixes as $fix) { ?>
          <div class="marker" style="left: <?= htmlspecialchars($fix['point_x']) ?>%; top: <?= htmlspecialchars($fix['point_y']) ?>%;"
            onmouseover="showInfo(event, '<?= htmlspecialchars($fix['comment']) ?>', '<?= htmlspecialchars($fix['url']) ?>', <?= htmlspecialchars($fix['point_x']) ?>, <?= htmlspecialchars($fix['point_y']) ?>)"
            onmouseout="hideInfo()">
          </div>
        <?php } ?>
        <?php foreach ($macros as $macro) { ?>
          <div class="marker" style="left: <?= htmlspecialchars($macro['point_x']) ?>%; top: <?= htmlspecialchars($macro['point_y']) ?>%;"
            onmouseover="showInfo(event, '<?= htmlspecialchars($macro['comment']) ?>', '<?= htmlspecialchars($macro['url']) ?>', <?= htmlspecialchars($macro['point_x']) ?>, <?= htmlspecialchars($macro['point_y']) ?>)"
            onmouseout="hideInfo()">
          </div>
        <?php } ?>
        <div class="info" id="info"
          onmouseover="cancelHideInfo()"
          onmouseout="hideInfo()"></div>
        <div class="prot"></div>
        <div class="form-popup" id="formPopup">
          <button type="button" class="close-btn" onclick="closePopup()">×</button>
          <form action="fixes_regist.php" method="POST" id="popupForm">
            <input type="hidden" name="point_x" id="popup_point_x">
            <input type="hidden" name="point_y" id="popup_point_y">
            <input type="hidden" name="map_id" value="<?= htmlspecialchars($map_id) ?>">
            <input type="hidden" name="agent_id" value="<?= htmlspecialchars($agent_id) ?>">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
            <label>
              <input type="radio" name="register_type" value="fix" checked>
              定点
            </label>
            <label>
              <input type="radio" name="register_type" value="macro">
              共通マクロ
            </label><br>
            コメント: <input type="text" name="comment"><br>
            URL: <input type="text" name="url"><br>
            <input type="submit" value="登録">

          </form>
        </div>
      </div>
    </div>
    </div>
  </article>

  <script src="main.js">
  </script>

</body>

</html>