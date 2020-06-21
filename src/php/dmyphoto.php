<?php
    require_once('config1.php');
    session_start();
    try {
        $UID=$_SESSION['id'];
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);

        $sql = 'DELETE FROM traveluserimage where ImageID=:id and UID=:UID';
        $id =  $_GET['id'];
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':UID', $UID);
        $statement->execute();

        $pdo = null;
        if ($statement){
            echo "<script type='text/javascript'>location.href='myphoto.php';</script>";
        }
        else{
            echo "<script type='text/javascript'>alert('删除失败！');location.href='myphoto.php';</script>";
        }

    }
    catch (PDOException $e) {
        die( $e->getMessage() );
    }

?>