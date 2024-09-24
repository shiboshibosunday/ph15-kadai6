<?php

// 他のPHPファイルを読み込む
require_once __DIR__ . '/functions/user.php';

// これを忘れない
session_start();

// フォームが送信されたかチェックする
if (isset($_POST['submit-button'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender  = $_POST['gender'];

    // 連想配列を作成
    $user = [
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'gender' => $gender,
    ];

    // 関数を呼び出す
    $user = saveUser($user);

    // セッションにIDを保存
    $_SESSION['id'] = $user['id'];

    // my-page に移動させる（リダイレクト）
    header('Location: ./my-page.php');
    exit();
}

?>
<html>
    <head>
        <link rel="stylesheet" href="css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Mincho&display=swap" rel="stylesheet">

    </head>
    <body>
        <h1>会員登録</h1>
        <!-- action: フォームの送信先 -->
        <!-- method: 送信方法（GET / POST） -->
        <form action="./register.php" method="post">
            <div>
                <h2>お名前</h2>
                <input type="text" name="name">
            </div>
            <div>
                <h2>メールアドレス</h2>
                <input type="email" name="email" required>
            </div>
            <div>
                <h2>パスワード</h2>
                <input type="password" name="password">
            </div>
            <div>
                <h2>性別</h2>
                <input type="radio" name="gender" value="男性"> 男性
                <input type="radio" name="gender" value="女性"> 女性
            </div>
            <div class="button">
                <!-- <button type="submit">登録</button> -->
                <input type="submit" value="登録" name="submit-button" class="push">
            </div>
        </form>
        <?php include __DIR__ . '/includes/footer.php' ?>
    </body>
</html>
