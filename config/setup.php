<?php

use Core\Database;
use Core\Helper;

include_once ('./Core/Helper.php');

 setupDatabase();

function setupDatabase() {
    $conn = null;
    try {
        $conn = new PDO('mysql:host='.DB_HOST.';',DB_USER, DB_PASSWORD);
        $queries = setupQueries();

        $conn->exec($queries['db-sql']);
        $conn->exec($queries['select-db']);
        $conn->exec($queries['user-sql']);
        $conn->exec($queries['session-sql']);
        $conn->exec($queries['images-sql']);
        $conn->exec($queries['comments-sql']);
        $conn->exec($queries['likes-sql']);

        $conn->beginTransaction();
        //check if database is seeded
        $sql = 'SELECT * FROM `user`';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $defaultUserExist = $stmt->rowCount();
        $stmt->closeCursor();

        if ($defaultUserExist == 0) {
             //default user
            $username = "admin";
            $email = "1281martian@gmail.com";
            $password = password_hash("password", PASSWORD_DEFAULT);
            $token = md5($username . $email . Helper::generateRandomString());


            //save default user
            $sql = 'INSERT INTO `user` (username, email, password, token, confirmed) VALUES (?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $email, $password, $token, 1]);
             //get generated default user id
            $userId = $conn->lastInsertId();
            $stmt->closeCursor();

             //save images
            foreach (Helper::getImages() as $image) {
                $image_query = 'INSERT INTO `images` (user_id, image_name, image_data) VALUES (?, ?, ?)';
                $stmt = $conn->prepare($image_query);
                $stmt->execute([$userId, 'test', $image]);
             }

            //persist data
            $conn->commit();
         }
    } catch (PDOException | Exception $e) {
        $conn->rollBack();
        Helper::dnd($e->getMessage());
    }
}

function setupQueries() {
    return [
        'db-sql' => "CREATE DATABASE IF NOT EXISTS " . DB_NAME,
        'select-db' => "USE " . DB_NAME,
        'user-sql' => "
            CREATE TABLE IF NOT EXISTS `user` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL,
            `email` varchar(150) NOT NULL,
            `password` varchar(150) NOT NULL,
            `token` varchar(150) NOT NULL,
            `confirmed` tinyint(1) NOT NULL DEFAULT 0,
            `notification` tinyint(1) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1",
        'session-sql' => "
            CREATE TABLE IF NOT EXISTS `session` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NULL,
            `session` varchar(255) NULL,
            `user_agent` varchar(255) NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES user(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1",
        'images-sql' => "
            CREATE TABLE IF NOT EXISTS `images` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `image_name` varchar(255) NOT NULL,
            `image_data` longblob NOT NULL,
            `date` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES user(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1",
        'comments-sql' => "
            CREATE TABLE IF NOT EXISTS `comments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `image_id` int(11) NOT NULL,
            `content` varchar(255) NOT NULL,
            `date` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES user(id) ON DELETE CASCADE,
            FOREIGN KEY (`image_id`) REFERENCES images(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1",
        'likes-sql' => "
            CREATE TABLE IF NOT EXISTS `likes` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `image_id` int(11) NOT NULL,
            `content` varchar(255) NOT NULL,
            `date` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES user(id) ON DELETE CASCADE,
            FOREIGN KEY (`image_id`) REFERENCES images(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1"
    ];
}