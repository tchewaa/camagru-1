<?php

use Core\Helper;
use Core\Database;

include_once ('./Core/Helper.php');

setupDatabase();

function setupDatabase() {
     try {
        $conn = new PDO('mysql:host='.DB_HOST.';',DB_USER, DB_PASSWORD);

        $conn->beginTransaction();

        $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
        $conn->exec($sql);

        $sql = "use " . DB_NAME;
        $conn->exec($sql);

        //Create table for users
        $sql = "
            CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL,
            `email` varchar(150) NOT NULL,
            `password` varchar(150) NOT NULL,
            `notification` tinyint(1) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
        $conn->exec($sql);

        //create table for user_sessions
        $sql = "
            CREATE TABLE IF NOT EXISTS `user_sessions` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `session` varchar(255) NOT NULL,
            `user_agent` varchar(255) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES users(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
        $conn->exec($sql);

        //create table for verification
        $sql = "
            CREATE TABLE IF NOT EXISTS `verification` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `token` varchar(150) NOT NULL,
            `confirmed` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES users(id) ON DELETE CASCADE 
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
         $conn->exec($sql);

        //create table for images
        $sql = "
            CREATE TABLE IF NOT EXISTS `images` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `image_name` varchar(255) NOT NULL,
            `image_data` longblob NOT NULL,
            `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
        $conn->exec($sql);

        //create table for comments
        $sql = "
            CREATE TABLE IF NOT EXISTS `comments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `image_id` int(11) NOT NULL,
            `content` varchar(255) NOT NULL,
            `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (`image_id`) REFERENCES images(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
        $conn->exec($sql);

        //create table for likes
        $sql = "
            CREATE TABLE IF NOT EXISTS `likes` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `image_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (`image_id`) REFERENCES images(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
        $conn->exec($sql);

         //check if database is seeded
         $sql = 'SELECT * FROM users';
         $stmt = $conn->prepare($sql);
         $stmt->execute();

         if ($stmt->rowCount() == 0) {
             //default user
             $username = "admin";
             $email = "1281martian@gmail.com";
             $password = password_hash("password", PASSWORD_DEFAULT);
             $token = md5($username . $email . Helper::generateRandomString());

             //save default user
             $sql = 'INSERT INTO `users` (username, email, password) VALUES (?, ?, ?)';
             $stmt = $conn->prepare($sql);
             $stmt->execute([$username, $email, $password]);

             //get generated default user id
             $userId = $conn->lastInsertId();

             //save verification data
             $sql = 'INSERT INTO `verification` (user_id, token, confirmed) VALUES (?, ?, ?)';
             $stmt = $conn->prepare($sql);
             $stmt->execute([$userId, $token, 1]);

             //save images
             foreach (Helper::getImages() as $image) {
                 $image_query = 'INSERT INTO `images` (user_id, image_name, image_data) VALUES (?, ?, ?)';
                 $stmt = $conn->prepare($image_query);
                 $stmt->execute([$userId, 'test', $image]);
             }

             //persist data
             $conn->commit();
         }
    } catch (PDOException $e) {
        die($e->getMessage());
    }

}

function seedDatabase($conn) {
//    $db = Database::getInstance();
    $username = "admin";
    $email = "1281martian@gmail.com";
    $password = password_hash("password", PASSWORD_DEFAULT);
    $token = md5($username . $email . Helper::generateRandomString());

//    $db->PDO()->beginTransaction();

    //Query 1 insert user
    $user_query = 'INSERT INTO `users` (username, email, password) VALUES (?, ?, ?)';
    $stmt = $db->PDO()->prepare($user_query);
    $stmt->execute([$username, $email, $password]);

    //Get generated user id
    $userId = $db->PDO()->lastInsertId();

    //Query 2 insert verification
    $verification_query = 'INSERT INTO `verification` (user_id, token, confirmed) VALUES (?, ?, ?)';
    $stmt = $db->PDO()->prepare($verification_query);
    $stmt->execute([$userId, $token, 1]);

    //Query 3 insert images
    foreach (Helper::getRandomImage() as $image) {
        $image_query = 'INSERT INTO `images` (user_id, image_name, image_data) VALUES (?, ?, ?)';
        $stmt = $db->PDO()->prepare($image_query);
        $stmt->execute([$userId, 'test', $image]);
    }

    //persist data
    $db->PDO()->commit();

}