<?php

require_once('src/php/config1.php');


function outputimg(){
     try {
         $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $sql = 'select ImageID, Description, Path ,Title from travelimage ORDER BY  RAND() LIMIT 6';
         $result = $pdo->query($sql);

         $i=0;
         while ($i<6) {
             $row = $result->fetch();
             outputSingleimg($row);
             $i++;
         }
         $pdo = null;
     }
     catch (PDOException $e){
         die( $e->getMessage() );
     }
 }
 function outputsingleimg($row){
     echo '<div >';
     echo constructdetaillink($row['ImageID']);
     echo '<img src="travel-images/large/'.$row['Path'].'"></a>';
     echo '<h3>'.$row['Title'].'</h3>'  ;
     echo ' <p>'.$row['Description'].'</p>' ;
     echo '</div>';
 }
 function constructdetaillink($id){
     return '<a href="src/php/img.php?id=' . $id . '">';
 }

 session_start();

 function checklog()
 {
     if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
         echo "<div class=\"dropdown\">
            <a href=\"\" class=\"dropbtn\">My Account</a>
            <div class=\"dropdown-content\">
                <a href=\"src/php/up.html\"><img src=\"img/16.png\"> upload</a>
                <a href=\"src/php/myphoto.php\" id=\"myphoto\"><img src=\"img/4.png\"> my photo</a>
                <a href=\"src/php/favourite.php\"><img src=\"img/3.png\"> my favourite</a>
                <a href=\"src/php/logout.php\"><img src=\"img/2.png\"> log out</a>
            </div>
        </div>";
     }
     else{
         $_SESSION["admin"] = false;
         echo "<li><a href='src/php/log.php'>Login</a></li>";
     }
 }


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="src/css/home.css">
</head>
<body>
<!--导航栏-->
<div class="menu" id="top">
    <ul>
        <li id="home"><a href="index.php">Home</a></li>
        <li><a href="src/php/browse.php">Browse</a></li>
        <li><a href="src/php/search.php">Search</a></li>
        <?php checklog(); ?>
    </ul>
</div>
<!--两张头图-->
<div>
    <img src="travel-images/large/8711623884.jpg" class="bigpicture">
    <img src="travel-images/large/6114867983.jpg" class="bigpicture">
</div>
<!--主体内容，采用grid布局-->
<div class="content">
    <?php outputimg()
    ?>
</div>
<!--页脚-->
<div class="bottom">
    <img src="img/two.jpg">
</div>
<!--回到顶部，刷新按钮-->
<div class="button">
    <a href=""><img src="img/refresh.png" onclick="alert('Picture Updated!')"></a>
    <a href="#top"><img src="img/top.png" ></a>
</div>
</body>
</html>