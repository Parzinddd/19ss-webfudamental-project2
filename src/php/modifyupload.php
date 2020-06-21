<?php
require_once('config1.php');

if (isset($_POST['submit'])) {
    //$ID=$_SESSION['id'];
    $title=$_POST['title'];
    $theme=$_POST['theme'];
    $country=$_POST['country'];
    $city=$_POST['city'];
    $description=$_POST['description'];
    $type = $_FILES['file1']['type'];
    $ImageID = $_GET['id'];
    if ($type==null){

        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);

        $sql = "UPDATE traveluserimage SET Title=:title,Description=:description,Theme=:theme,Country=:country,City=:city WHERE ImageID=:imageid ";
        $statement = $pdo->prepare($sql);

        $statement->bindValue(':title',$title);
        $statement->bindValue(':theme',$theme);
        $statement->bindValue(':country',$country);
        $statement->bindValue(':city',$city);
        $statement->bindValue(':description',$description);
        $statement->bindValue(':imageid',$ImageID);
        if ($statement->execute()){
            echo "<script type='text/javascript'>alert('修改成功！');</script>";
        }
        else{
            echo "<script type='text/javascript'>alert('修改失败！');</script>";
        }
    }
    else {
        $data = addslashes(file_get_contents($_FILES['file1']['tmp_name']));
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $sql = "UPDATE traveluserimage SET Title=:title,Description=:description,Theme=:theme,Country=:country,City=:city,type=:type ,Image=:data WHERE ImageID=:imageid ";
        $statement1 = $pdo->prepare($sql);

        $statement1->bindValue(':title', $title);
        $statement1->bindValue(':theme', $theme);
        $statement1->bindValue(':country', $country);
        $statement1->bindValue(':city', $city);
        $statement1->bindValue(':description', $description);
        $statement1->bindValue(':data',$data);
        $statement1->bindValue(':type',$type);
        $statement1->bindValue(':imageid', $ImageID);
        if ($statement1->execute()) {
            echo "<script type='text/javascript'>alert('修改成功！');location.href='favourite.php'</script>";
        } else {
            echo "<script type='text/javascript'>alert('修改失败！');location.href='Modigy.php'</script>";
        }
    }
}



