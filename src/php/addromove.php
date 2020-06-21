<?php
require_once('config1.php');
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $sql1 = 'select UID from travelimagefavor where UID=:uid and ImageID=:id';
        $statement = $pdo->prepare($sql1);
        $statement->bindValue(':uid', $_GET['id']);
        $statement->bindValue(':id', $_GET['ImageID']);
        $statement->execute();
        if ($statement->fetch()) {
            $sql2 = 'delete from travelimagefavor where UID=:uid and ImageID=:id';
            $statement1 = $pdo->prepare($sql2);
            $statement1->bindValue(':uid', $_GET['id']);
            $statement1->bindValue(':id', $_GET['ImageID']);
            $statement1->execute();
            echo '<script>alert(\'Photograph has been removed from the collection！\'); window.history.go(-1);</script>';
        } else {
            $sql3 = "INSERT INTO travelimagefavor VALUES(null,:uid,:id,0)";
            $statement2 = $pdo->prepare($sql3);
            $statement2->bindValue(':uid', $_GET['id']);
            $statement2->bindValue(':id', $_GET['ImageID']);
            $statement2->execute();
            echo '<script> alert(\'Photograph is collected successfully!\'); window.history.go(-1);</script>';
        }
        $pdo = null;
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

