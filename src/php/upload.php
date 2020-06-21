<?php
require_once('config1.php');
session_start();
if (isset($_POST['submit'])) {
    $ID=$_SESSION['id'];
    $title=$_POST['title'];
    $theme=$_POST['theme'];
    $country=$_POST['country'];
    $city=$_POST['city'];
    $description=$_POST['description'];
    $type = $_FILES['file1']['type'];
    $data = addslashes(file_get_contents($_FILES['file1']['tmp_name']));


    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);

    $sql = 'INSERT INTO traveluserimage VALUES (:ID,:title,:description,:theme,:country,:city,:data,:type,null )';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':ID',$ID);
    $statement->bindValue(':title',$title);
    $statement->bindValue(':theme',$theme);
    $statement->bindValue(':country',$country);
    $statement->bindValue(':city',$city);
    $statement->bindValue(':description',$description);
    $statement->bindValue(':data',$data);
    $statement->bindValue(':type',$type);
    $statement->execute();
    if ($statement){
        echo "<script type='text/javascript'>alert('上传成功！');location.href='myphoto.php';</script>";
    }
    else{
        echo "<script type='text/javascript'>alert('上传失败！');location.href='up.html';</script>";
    }
}
?>