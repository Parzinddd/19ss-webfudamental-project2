<?php
require_once('config1.php');
session_start();

    $UID = $_SESSION['id'];
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'select * from  traveluserimage where UID=:id and ImageID=:imageid';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $UID);
    $statement->bindValue(':imageid', $_GET['id']);
    $statement->execute();
    $row = $statement->fetch();

       function image(){
           try {

               $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

               $sql = 'select Image, Description,Title,type,UID,ImageID  from  traveluserimage where UID=:id and ImageID=:imageid';
               $statement = $pdo->prepare($sql);
               $statement->bindValue(':id', $_SESSION['id']);
               $statement->bindValue(':imageid', $_GET['id']);
               $statement->execute();
               $row = $statement->fetch();
               echo '<img src="data:image/png;base64,'.base64_encode(stripslashes($row['Image'])).'">';

           } catch (PDOException $e) {
               die($e->getMessage());
           }
       }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>上传</title>
    <link rel="stylesheet" type="text/css" href="../css/upload.css">
</head>
<body>

<!--导航栏-->
<div class="menu">
    <ul name="top">
        <li ><a href="../../index.php">Home</a></li>
        <li><a href="browse.php">Browse</a></li>
        <li id="serach"><a href="search.php">Search</a></li>
        <div class="dropdown">
            <a href="" class="dropbtn">My Account</a>
            <div class="dropdown-content">
                <a href="up.html" id="upload"><img src="../../img/16.png"> upload</a>
                <a href="myphoto.php"><img src="../../img/4.png"> my photo</a>
                <a href="favourite.php"><img src="../../img/3.png"> my favourite</a>
                <a href="logout.php"><img src="../../img/2.png"> log out</a>
            </div>
        </div>
    </ul>
</div>
<!--标题-->
<h2>UPLOAD YOUR NEW PHOTOGRAPH</h2>
<!--主体，采用grid布局-->
<form method="post" action="modifyupload.php?<?php echo 'id='.$_GET['id'].''?>" enctype="multipart/form-data">
    <div class="content">
        <div class="picture" id="imgPreview">
            <?php image(); ?>
        </div>
        <div>
            <h3>Title :</h3>
            <input type="text" name="title" value=<?php echo $row['Title']?> >
        </div>
        <div>
            <h3>Theme :</h3>
            <input type="text" name="theme" value=<?php echo $row['Theme']?>>
        </div>
        <div>
            <h3>Countary :</h3>
            <input type="text" name="country" value=<?php echo $row['Country']?>>
        </div>
        <div>
            <h3>City :</h3>
            <input type="text" name="city" value=<?php echo $row['City']?>>
        </div>
    </div>
    <!--描述输入框-->
    <div class="des">
        <h3>Description :</h3>
        <input type="text" name="description" <?php echo 'value="'.$row['Description'].'"'?>>
    </div>
    <!--两个按钮-->
    <div class="put">
        <div><a id="button">choose <input type="file" onchange='PreviewImage(this)' id="file1" name="file1" ></a></div>
        <div>
            <input type="submit" value="modify" id="submit" name="submit">
        </div>
    </div>
</form>
<!--页脚-->
<div class="bottom">@19302010060@fudan.edu.cn</div>
<script>
    /*实现图片预览*/
    function PreviewImage(imgFile) {
        /*允许下列文件格式*/
        var pattern = /(\.*.jpg$)|(\.*.png$)|(\.*.jpeg$)|(\.*.gif$)/;
        if (!pattern.test(imgFile.value)) {
            alert("系统仅支持jpg/jpeg/png/gif格式的照片！");
        }
        else
        {
            var path;
            path = URL.createObjectURL(imgFile.files[0]);
            document.getElementById("imgPreview").innerHTML = "<img src='"+path+"'/>";
        }
    }
</script>
</body>
</html>