<?php

require_once __DIR__ . '/functions/user.php';

session_start();

$errorMessages = [];
// メール入力した値が消えないようにする
$email = '';

if (isset($_POST['submit-button'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isRememberMe = isset($_POST['remember-me']);

    if (empty($email)) {
        $errorMessages['email'] = 'メールアドレスを入力してください';
    }
    if (empty($password) || strlen($password) < 8) {
        $errorMessages['password'] = 'パスワードは8文字以上で入力してください';
    }

    if (empty($errorMessages)) {
    $user = login($email, $password);

    if (!is_null($user)) {
        // セッションにIDを保存
        $_SESSION['id'] = $user['id'];


        // チェックボックスがチェックされていたらcookieにIDを保存
        if ($isRememberMe) {
            setcookie('id', $user['id'], time() + 60 * 60, '/');
        }


        header('Location: ./my-page.php');
        exit();
    }

    $errorMessages['result'] = '一致するユーザーが見つかりませんでした';
    }
}

?>
<html>
    <head>
        <link rel="stylesheet" href="css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Mincho&display=swap" rel="stylesheet">

        <style>
            .error {
                color: red;
            }
        </style>
    </head>
    <body>
        <h1>Login</h1>
        <?php if (isset($errorMessages['result'])): ?>
            <p class="error"><?php echo $errorMessages['result'] ?></p>
        <?php endif ?>
        <form action="./login.php" method="post">
            <div>
                <h2>メールアドレス</h2>
                <input type="email" name="email" value="<?php echo $email ?>">
                <?php if (isset($errorMessages['email'])): ?>
                    <p class="error"><?php echo $errorMessages['email'] ?></p>
                <?php endif ?>
            </div>
            <div>
                <h2>パスワード</h2>
                <input type="password" name="password">
                <?php if (isset($errorMessages['password'])): ?>
                    <p class="error"><?php echo $errorMessages['password'] ?></p>
                <?php endif ?>
            </div>

            <div class="text">
                <label>
                    <input type="checkbox" name="remember-me">
                    ログイン状態を保存する
                </label>
            </div>

            <div class="button">
                <input type="submit" value="ログイン" name="submit-button" class="push">
            </div>
        </form>
    </body>
</html>
