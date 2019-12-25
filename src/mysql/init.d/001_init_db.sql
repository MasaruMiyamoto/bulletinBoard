CREATE DATABASE board_db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

-- DB操作ユーザーの作成
-- phpMyAdminから確認したいため、ホストはワイルドカード指定
GRANT ALL PRIVILEGES ON board_db.* TO board_user@'%' IDENTIFIED BY 'board_pass' WITH GRANT OPTION;