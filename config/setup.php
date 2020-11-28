<?php

use Core\Helper;
use Core\Database;

include_once ('./Core/Helper.php');
include_once ('./Core/Database.php');


setupDatabase();

function setupDatabase() {
    echo "setting up database, please wait...";
    try {
        $db = new PDO('mysql:host='.DB_HOST.';',DB_USER, DB_PASSWORD);
        $DB_NAME = 'testdb';
        $sql = "CREATE DATABASE IF NOT EXISTS " . $DB_NAME;
        $db->exec($sql);

        $sql = "use " . $DB_NAME;
        $db->exec($sql);

        //Create table for users
        $sql = "
            CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL,
            `email` varchar(150) NOT NULL,
            `password` varchar(150) NOT NULL,
            `notification` tinyint(1) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
        $db->exec($sql);

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
        $db->exec($sql);

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
         $db->exec($sql);

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
        $db->exec($sql);

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
        $db->exec($sql);

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
        $db->exec($sql);

        echo 'database "testing created..."';
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}