<!-- 
login.php
作成者：OriginPeastar
作成日：2025/07/19
-->
<?php
session_start();

$login_error = ""; // エラーメッセージ用

// POST処理
if (!empty($_POST["mailAddress"]) && !empty($_POST["pwd"])) {
  try {
    //データベースへの接続を行う
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

    //POSTされたデータをもとにSQL文を生成する
    //まず、IDが指定した項目であるユーザを取得する
    $sql = "SELECT * FROM users WHERE mailAddress=:mailAddress;";

    //SQL文の実行準備と実行（stmt = statement）
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('mailAddress', $_POST["mailAddress"], PDO::PARAM_STR);
    $stmt->execute();
    //SQLの結果をすべて取得する
    $result = $stmt->fetchAll();

    //取得件数が0以上であれば、nameに一致したユーザが存在している
    if (count($result) != 0) {
      $login_flag = false;
      foreach ($result as $item) {
        //ハッシュ化したパスワードの比較を実施する
        //第1引数:通常の文字列
        //第2引数:ハッシュ化した文字列
        if (password_verify($_POST["pwd"], $item["pwd"])) {

          //セッションにログイン情報を保存
          session_regenerate_id(true);
          $_SESSION["user_id"] = $item["user_id"];
          $_SESSION["userName"] = $item["userName"];
          header("Location: main.php"); //ログイン後ページ遷移
          $login_flag = true;
          exit;
        }
      }
      if ($login_flag == false) {
        print("<br><br>ログインに失敗しました<br>");
      }
    } else {
      print("<br><br>ログインに失敗しました<br>");
    }
  } catch (Exception $e) {
    print($e->getMessage() . "<br>");
  }
}
?>

<!DOCTYPE html>
<html lang="ja" data-bs-theme="auto">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VALOFIX_login</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    html,
    body {
      height: 100%;
    }

    .form-signin {
      max-width: 330px;
      padding: 1rem;
      margin: auto;
    }
  </style>
</head>

<body class="d-flex align-items-center bg-body-tertiary">

  <main class="form-signin w-100">
    <form method="POST">
      <h1 class="h3 mb-3 fw-normal text-center">ログインしてください</h1>

      <?php if ($login_error): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($login_error) ?></div>
      <?php endif; ?>

      <div class="form-floating mb-2">
        <input type="email" class="form-control" id="floatingInput" name="mailAddress" placeholder="name@example.com" required>
        <label for="floatingInput">メールアドレス</label>
      </div>
      <div class="form-floating mb-2">
        <input type="password" class="form-control" id="floatingPassword" name="pwd" placeholder="Password" required>
        <label for="floatingPassword">パスワード</label>
      </div>

      <button class="btn btn-primary w-100 py-2" type="submit">ログイン</button>
      <p class="mt-3 mb-3 text-muted text-center">&copy; 2025</p>
    </form>
  </main>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>