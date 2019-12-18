<meta charset="UTF-8">
<title>テスト</title>
<?php
    try {
        # hostには「docker-compose.yml」で指定したコンテナ名を記載
        $dsn = "mysql:host=mysql;dbname=board_db;";
        $db = new PDO($dsn, 'board_user', 'board_pass');
        $sql = "SELECT * FROM board";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($result);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }