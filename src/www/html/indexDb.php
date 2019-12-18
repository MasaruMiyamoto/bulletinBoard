<?php 
$db_host = 'mysql';
$db_name = 'board_db';
$db_user = 'board_user';
$db_pass = 'board_pass';

// PHPのエラーを表示するように設定
error_reporting(E_ALL & ~E_NOTICE);

//データベースへ接続する
//PDOを用いてDB操作を行う
try {

    $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
    $option = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
    //DB接続
    $pdo = new PDO($dsn, $db_user, $db_pass, $option);

    //書き込みがある場合、boardテーブルに書き込み内容を追加
    if (isset($_POST['send']) == true) {
        $name = $_POST['name'];
        $comment = $_POST['comment'];

        if ($name !== '' && $comment !== ''){
            $sql = "INSERT INTO board ("
                ."name, comment"
                .") VALUES ("
                .":name, :comment"
                .")";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':comment', $comment);
            $result = $stmt->execute();
            
            $msg = '書き込みに成功しました。';

        } else {
            $err_msg = '名前とコメントを入力してください。';
        }
    }

    $sql = "SELECT * FROM board";
    //SQLパラメータ
    //クエリパラメータもここで指定
    $stmt = $pdo->prepare($sql);
    //SQL実行
    $stmt->execute();
    //結果を取得する。
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //ソート
    arsort($result);

} catch (PDOException $e){
    $err_msg = '書き込みに失敗しました。';
    echo $e->getMessage();
}

// Webブラウザにこれから表示するものがUTF-8で書かれたHTMLであることを伝える
// (これか <meta charset="utf-8"> の最低限どちらか1つがあればいい． 両方あっても良い．)
header('Content-Type: text/html; charset=utf-8');
?>

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <form method="post" action="">
            名前<input type="text" name="name" value="" />
            コメント<textarea name="comment" rows="4" cols="20"></textarea>
           <input type="submit" name="send" value="書き込む" />
        </form>
        <!-- ここに、書き込まれたデータを表示する -->
<?php
    if ( $msg     !== '' ) echo '<p>' . $msg . '</p>';
    if ( $err_msg !== '' ) echo '<p style="color:#f00;">' . $err_msg . '</p>';
    foreach( $result as $key => $val ){
        echo $val['name'] . ' ' . $val['comment'] . '<br>';
    }
?>
    </body>
</html>