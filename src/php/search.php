<?php
require_once('config1.php');
session_start();

$GLOBALS['search']='';
if (isset($_GET['page'])) {
    $_SESSION['page'] = $_GET['page'];
}
else{
    $_SESSION['page']=0;
    $_SESSION['number']=0;
}


function checkSearch(){
    if (isset($_POST['search'])){
        if ($_POST['search']=='title'){
            searchBytitle();
        }
        else {
            searchBydes();
        }

    }
    else if(isset($_GET['title1'])){
        searchBytitleagain();
    }
    else if(isset($_GET['des'])){
        searchBydesagain();
    }
    else{
        echo '<h3>No result!</h3>';
    }
}
function searchBytitle(){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'select Path,ImageID,Title,Description  from  travelimage where Title LIKE "%'.$_POST['title'].'%"';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>4){
        $i=0;
        while (($row = $statement->fetch())&&$i<4) {
            outPutImage($row);
            $i++;
        }
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='title1='.$_POST['title'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outPutImage($row);
        }
    }
    $pdo=null;
}
function searchBytitleagain(){
    $num=$_SESSION['page']*4;
    $GLOBALS['search']='title1='.$_GET['title1'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = "select Path,ImageID,Title,Description  from  travelimage where Title LIKE '%".$_GET['title1']."%'";
    $sql = $sql . "LIMIT $num,4";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        $i=0;
        while (($row = $statement->fetch())&&$i<4) {
            outPutImage($row);
            $i++;
        }
    }
    $pdo=null;
}
function searchBydes(){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'select Path,ImageID,Title,Description  from  travelimage where Description LIKE "%'.$_POST['description'].'%"';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>4){
        $i=0;
        while (($row = $statement->fetch())&&$i<4) {
            outPutImage($row);
            $i++;
        }
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='des='.$_POST['description'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outPutImage($row);
        }
    }
    $pdo=null;
}
function searchBydesagain(){
    $num=$_SESSION['page']*4;
    $GLOBALS['search']='des='.$_GET['des'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'select Path,ImageID,Title,Description  from  travelimage where Description LIKE "%'.$_GET['des'].'%"';
    $sql = $sql . "LIMIT $num,4";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        while ($row = $statement->fetch()) {
            outPutImage($row);
        }
    }
    $pdo=null;
}
function outPutImage($row){
   echo '<div><a href="img.php?id=' . $row['ImageID'] . '"><img src="../../travel-images/large/'.$row['Path'].'"></a> </div>';
   echo '<div><h2>'.$row['Title'].'</h2>';
   echo '<p>'.$row['Description'].'</p><hr></div>';
}


function creatnumber(){
    $total = floor(($_SESSION['number'] / 4) + 1);
    if ($total > 1 && $total < 6) {
        if ($_SESSION['page'] > 0) {
            echo '<a href="' . Page(0) . '">首页</a>
                <a href="' . Page($_SESSION['page'] - 1) . '"><</a>';
        }
        for ($i = 0; $i < $total; $i++) {
            echo '<a href="' . Page($i) . '" id="' . Active($i) . '">' . ($i + 1) . '</a>';
        }
        if ($_SESSION['page'] < $total - 1) {
            echo '<a href="' . Page($_SESSION['page'] + 1) . '"> > </a>';
            echo '<a href="' . Page($total - 1) . ' ">尾页</a>';
        }
    } elseif ($total > 5) {
        if ($_SESSION['page'] >0) {
            echo '<a href="' . Page(0) . '">首页</a>
                <a href="' . Page($_SESSION['page'] - 1) . '"> < </a>';
        }

            for ($i = 0; $i < 5; $i++) {
                echo '<a href="' . Page($i) . '" id="' . Active($i) . '">' . ($i + 1) . '</a>';
            }

        if ($_SESSION['page'] < 4) {
            echo '<a href="' . Page($_SESSION['page'] + 1) . '"> > </a>';
            echo '<a href="' . Page(4) . ' ">尾页</a>';
        }
    }
}
function Active($num){
    if ($num == $_SESSION['page']) {
        return "active";
    } else {
        return "";
    }
}
function Page($page){
    $url='search.php?'.$GLOBALS['search'].'&page='.$page.'';
    return $url;
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
    <title>Serach</title>
    <link rel="stylesheet" type="text/css" href="../css/serach.css">
</head>
<body>
  <!--导航栏-->
  <div class="menu">
    <ul name="top">
     <li ><a href="../../index.php">Home</a></li>
     <li><a href="browse.php">Browse</a></li>
     <li id="serach"><a href="search.php">Search</a></li>
     <?php checklog(); ?>
    </ul>
  </div>
  <!--搜索部分-->
  <div class="serach">
         <h2>Serach</h2>
         <form method="post" action="search.php">
         <input type="radio" name="search" checked="checked" value="title">Search by title <br><br>
         <input type="text"  name="title"><br><br>
         <input type="radio" name="search" value="description">Search by description <br><br>
         <input type="text" name="description" id="des"><br><br>
         <input type="submit" value="Filter" id="submit">
         </form>
  </div>
  <!--结果部分-->
  <div class="resault">
         <h2>Resault</h2>
         <div class="content">
            <?php checkSearch(); ?>
         </div>
      <div class="page">
      <?php
      if (isset($_SESSION['page'])){
          creatnumber();
      }
      ?>
      </div>
   </div>
  <!--页脚-->
  <div class="bottom">@19302010060@fudan.edu.cn</div>
  <!--回到顶部-->
  <div class="button">
     <a href="#top"><img src="../../img/top.png" ></a>
  </div>
</body>
</html>