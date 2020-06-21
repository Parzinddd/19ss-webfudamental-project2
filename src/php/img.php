<?php
require_once('config1.php');
session_start();
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);

    $sql = 'select * from  travelimage where ImageID=:id';
    $id =  $_GET['id'];
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    $sql1 = 'select CountryName from geocountries where ISO=:iso';
    $statement1 = $pdo->prepare($sql1);
    $statement1->bindValue(':iso', $row['CountryCodeISO']);
    $statement1->execute();
    $row1 = $statement1->fetch();

    $sql2 = 'select AsciiName from geocities where GeoNameID=:nameid';
    $statement2 = $pdo->prepare($sql2);
    $statement2->bindValue(':nameid', $row['CityCode']);
    $statement2->execute();
    $row2 = $statement2->fetch();

    $pdo = null;
}
catch (PDOException $e) {
    die( $e->getMessage() );
}

function checklog()
{
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        echo "<div class=\"dropdown\">
            <a href=\"\" class=\"dropbtn\">My Account</a>
            <div class=\"dropdown-content\">
                <a href=\"up.html\"><img src=\"../../img/16.png\"> upload</a>
                <a href=\"myphoto.php\" id=\"myphoto\"><img src=\"../../img/4.png\"> my photo</a>
                <a href=\"favourite.php\"><img src=\"../../img/3.png\"> my favourite</a>
                <a href=\"logout.php\"><img src=\"../../img/2.png\"> log out</a>
            </div>
        </div>";
    }
    else{
        $_SESSION["admin"] = false;
        echo "<li><a href='log.php'>Login</a></li>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>图片</title>
    <link rel="stylesheet" type="text/css" href="../css/detail.css">
</head>
<body>
<!--导航栏-->
<div class="menu">
    <ul name="top">
        <li ><a href="../../index.php">Home</a></li>
        <li><a href="browse.php">Browse</a></li>
        <li ><a href="search.php">Search</a></li>
        <?php  checklog(); ?>
    </ul>
</div>
<!--标题-->
<h1>Detail</h1>
<!--主体内容-->
<div class="content">
    <div class="big"><img src="../../travel-images/large/<?php echo $row['PATH']; ?>"></div>
    <div class="detail">
        <h2>
            <?php echo $row['Title']?>
            <small style="font-size: 15px"> by NiuJiayang</small></h2>
        <p>
            Content：<?php echo $row['Content']; ?><br><br>
            Country: <?php echo $row1['CountryName']; ?><br><br>
            City: <?php echo $row2['AsciiName']; ?><br><br>
        </p>
        <?php
        if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        echo '<a href="addromove.php?id=' . $_SESSION['id'] . '&ImageID='.$_GET['id'].'">';
        }
        ?>
        <button>like</button></a>
    </div>
    <div class="article">
        <h2>Description</h2>
        <?php echo $row['Description']; ?>
    </div>
</div>
<!--页脚-->
<div class="bottom">@19302010060@fudan.edu.cn</div>
<!--收藏图标-->
<div class="button"><img src="../../img/heart.png"></div>
</body>
</html>


