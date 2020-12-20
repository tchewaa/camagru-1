<?php
include_once ('database.php');
include_once ('config.php');

setupDatabase();

function setupDatabase() {
    $conn = null;
    try {
        $conn = new PDO('mysql:host='.DB_HOST.';',DB_USER, DB_PASSWORD);
        $queries = setupQueries();

        $conn->exec($queries['create-db-sql']);
        echo '.<br/>';

        $conn->exec($queries['select-db']);
        echo 'Database \'camagru\' created...<br/>';

        $conn->exec($queries['create-user-sql']);
        echo 'Table \'user\' created...<br/>';

        $conn->exec($queries['create-session-sql']);
        echo 'Table \'session\' created...<br/>';

        $conn->exec($queries['create-images-sql']);
        echo 'Table \'images\' created...<br/>';

        $conn->exec($queries['create-comments-sql']);
        echo 'Table \'comments\' created...<br/>';

        $conn->exec($queries['create-likes-sql']);
        echo 'Table \'likes\' created...';

        $conn->beginTransaction();
        //check if database is seeded
        $sql = 'SELECT * FROM `user`';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $defaultUserExist = $stmt->rowCount();

        if ($defaultUserExist == 0) {
             //default user
            $username = "admin";
            $email = "1281martian@gmail.com";
            $password = password_hash("password", PASSWORD_DEFAULT);
            $token = md5($username . $email . '4493ygWdMWfARTc1BtbS3CUKLl0MDl');


            //save default user
            $sql = 'INSERT INTO `user` (username, email, password, token, confirmed) VALUES (?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $email, $password, $token, 1]);
             //get generated default user id
            $userId = $conn->lastInsertId();

            //TODO refactor
            //retrieve images
            $images = glob('../app/assets/dummy/' . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            $randomImages = [];
            for ($i = 0; $i < count($images); $i++) {
                $temp = file_get_contents($images[$i]);
                $imageData = imagecreatefromstring($temp);
                ob_start();
                imagejpeg($imageData);
                $imageData = ob_get_clean();
                $imageData = base64_encode($imageData);
                $base64Image = 'data:image/' . 'jpeg' . ';base64,' . $imageData;
                $randomImages[$i] = $base64Image;
            }

            //TODO refactor
            //save images
            foreach ($randomImages as $image) {
                $image_query = 'INSERT INTO `images` (user_id, image_name, image_data) VALUES (?, ?, ?)';
                $stmt = $conn->prepare($image_query);
                $stmt->execute([$userId, 'admin', $image]);
             }

            //persist data
            $conn->commit();
            echo '<br/>Default user \'admin\' created <br/>';
            echo 'Default password \'password\'';
         }
    } catch (PDOException | Exception $e) {
        $conn->rollBack();
        die($e->getMessage());
    }
}

function setupQueries() {
    return [
        'create-db-sql' => "CREATE DATABASE IF NOT EXISTS " . DB_NAME,
        'select-db' => "USE " . DB_NAME,
        'create-user-sql' => "
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
        'create-session-sql' => "
            CREATE TABLE IF NOT EXISTS `session` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NULL,
            `session` varchar(255) NULL,
            `user_agent` varchar(255) NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES user(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1",
        'create-images-sql' => "
            CREATE TABLE IF NOT EXISTS `images` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `image_name` varchar(255) NOT NULL,
            `image_data` longblob NOT NULL,
            `date` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES user(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1",
        'create-comments-sql' => "
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
        'create-likes-sql' => "
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