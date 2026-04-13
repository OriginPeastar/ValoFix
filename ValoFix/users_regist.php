<!--
users.regist.php
作成者：OriginPeastar
作成日：2025/07/19
-->

<?php
session_start();

$register_success = false;
$register_error = "";

// フォームが送信されたときだけ処理
if (!empty($_POST["mailAddress"]) && !empty($_POST["pwd"]) && !empty($_POST["userName"])) {
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

    // 登録処理
    $sql = "INSERT INTO users(mailAddress, pwd, userName) VALUES(:mailAddress, :pwd, :userName);";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('mailAddress', $_POST["mailAddress"], PDO::PARAM_STR);
    $stmt->bindValue('pwd', password_hash($_POST["pwd"], PASSWORD_DEFAULT), PDO::PARAM_STR);
    $stmt->bindValue('userName', $_POST["userName"], PDO::PARAM_STR);

    if ($stmt->execute()) {
      $register_success = true;
    } else {
      $register_error = "登録に失敗しました。";
    }
  } catch (Exception $e) {
    $register_error = "エラー: " . htmlspecialchars($e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="ja" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <title>新規登録</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html,
    body {
      height: 100%;
    }

    .form-signin {
      max-width: 400px;
      padding: 1rem;
      margin: auto;
    }
  </style>
</head>

<body class="d-flex align-items-center bg-body-tertiary">

  <main class="form-signin w-100">
    <form method="POST">
      <h1 class="h3 mb-3 fw-normal text-center">新規ユーザー登録</h1>

      <?php if ($register_success): ?>
        <div class="alert alert-success" role="alert">
          登録が完了しました！<br>
          メールアドレス: <?= htmlspecialchars($_POST["mailAddress"]) ?><br>
          ユーザー名: <?= htmlspecialchars($_POST["userName"]) ?>
        </div>
      <?php elseif ($register_error): ?>
        <div class="alert alert-danger" role="alert"><?= $register_error ?></div>
      <?php endif; ?>

      <div class="form-floating mb-2">
        <input type="email" class="form-control" name="mailAddress" id="floatingEmail" placeholder="email@example.com" required>
        <label for="floatingEmail">メールアドレス</label>
      </div>

      <div class="form-floating mb-2">
        <input type="password" class="form-control" name="pwd" id="floatingPassword" placeholder="Password" required>
        <label for="floatingPassword">パスワード</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" class="form-control" name="userName" id="floatingUsername" placeholder="ユーザー名" required>
        <label for="floatingUsername">ユーザー名</label>
      </div>

      <button class="btn btn-success w-100 py-2" type="submit">登録</button>

      <p class="mt-3 text-center">
        すでに登録済み？ <a href="login.php">ログインはこちら</a>
      </p>
    </form>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>