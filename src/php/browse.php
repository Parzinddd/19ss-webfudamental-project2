<?php
require_once('config1.php');
session_start();

function checksearch(){
    if(isset($_POST['title'])){
        searchByTitle();
    }
    else if (isset($_GET['theme'])){
        searchByContent();
    }
    else if(isset($_GET['country'])){
        searchByCountry();
    }
    else if(isset($_GET['city'])){
         searchByCity();
    }
    else if(isset($_POST['theme'])){
        searchByMore();
    }
    else if(isset($_GET['title1'])){
        searchByTitleagain();
    }
    else if(isset($_GET['theme1'])){
        searchByContentagain();
    }
    else if(isset($_GET['country1'])){
        searchByCountryagain();
    }
    else if(isset($_GET['city1'])){
        searchByCityagain();
    }
    else if(isset($_GET['country2'])){
        searchByMoreagain();
    }
    else{
        echo '<h3>No result!</h3>';
    }
}

$GLOBALS['search']='';
if (isset($_GET['page'])) {
    $_SESSION['page'] = $_GET['page'];
}
else{
    $_SESSION['page']=0;
    $_SESSION['number']=0;
}

function searchByTitle(){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'select Path,ImageID  from  travelimage where Title LIKE "%'.$_POST['title'].'%"';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>16){
        outputlimitimage($statement);
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='title1='.$_POST['title'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByTitleagain(){
    $num=$_SESSION['page']*16;
    $GLOBALS['search']='title1='.$_GET['title1'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $like='%'.$_GET['title1'].'%';

    $sql = "select Path,ImageID  from  travelimage where Title LIKE :like LIMIT $num,16";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':like',$like);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}

function searchByContent(){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'select Path,ImageID  from  travelimage where Content=:theme';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':theme',$_GET['theme']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>16){
        outputlimitimage($statement);
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='theme1='.$_GET['theme'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByContentagain(){
    $num=$_SESSION['page']*16;
    $GLOBALS['search']='theme1='.$_GET['theme1'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = "select Path,ImageID  from  travelimage where Content=:theme LIMIT $num,16";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':theme',$_GET['theme1']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByCountry(){

    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'SELECT ImageID,Path  FROM travelimage JOIN geocountries ON travelimage.CountryCodeISO=geocountries.ISO WHERE CountryName=:countryname  ';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':countryname',$_GET['country']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>16){
        outputlimitimage($statement);
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='country1='.$_GET['country'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByCountryagain(){
    $num=$_SESSION['page']*16;
    $GLOBALS['search']='country1='.$_GET['country1'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = "SELECT ImageID,Path  FROM travelimage JOIN geocountries ON travelimage.CountryCodeISO=geocountries.ISO WHERE CountryName=:countryname LIMIT $num,16 ";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':countryname',$_GET['country1']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByCity(){

    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'SELECT ImageID,Path FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE AsciiName LIKE :cityname  ';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':cityname',$_GET['city']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>16){
        outputlimitimage($statement);
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='city1='.$_GET['city1'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByCityagain(){
    $num=$_SESSION['page']*16;
    $GLOBALS['search']='city1='.$_GET['city1'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = "SELECT ImageID,Path FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE AsciiName LIKE :cityname LIMIT $num,16 ";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':cityname',$_GET['city1']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByMore(){

    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $sql ='SELECT ISO FROM geocountries WHERE CountryName=:countryname';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':countryname',$_POST['country']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        $row =$statement->fetch();
        $countrycode= $row['ISO'];
        $sql1 = 'SELECT ImageID,Path FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE AsciiName LIKE :cityname and Content=:content and travelimage.CountryCodeISO=:country';
        $statement1 = $pdo->prepare($sql1);
        $statement1->bindValue(':cityname', $_POST['city']);
        $statement1->bindValue(':content', $_POST['theme']);
        $statement1->bindValue(':country',$countrycode );
        $statement1->execute();
        if ($statement1->rowCount() == 0) {
            echo '<h3>Search no result!</h3>';
        }
        else if($statement->rowCount()>16){
            outputlimitimage($statement);
            $_SESSION['page']=0;
            $_SESSION['number']=$statement->rowCount();
            $GLOBALS['search']='country2='.$_POST['country'].'&cityname2='.$_POST['city'].'&content2='. $_POST['theme'].'';
        }
        else {
            while ($row1 = $statement1->fetch()) {
                outputImage($row1);
            }
        }
    }
    $pdo=null;
}
function searchByMoreagain(){
    $num=$_SESSION['page']*16;
    $GLOBALS['search']='country2='.$_GET['country2'].'&cityname2='.$_GET['city2'].'&content2='. $_GET['content2'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $sql ='SELECT ISO FROM geocountries WHERE CountryName=:countryname';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':countryname',$_GET['country2']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        $row =$statement->fetch();
        $countrycode= $row['ISO'];
        $sql1 = "SELECT ImageID,Path FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE AsciiName LIKE :cityname and Content=:content and travelimage.CountryCodeISO=:country LIMIT $num,16";
        $statement1 = $pdo->prepare($sql1);
        $statement1->bindValue(':cityname', $_GET['city2']);
        $statement1->bindValue(':content', $_GET['content2']);
        $statement1->bindValue(':country',$countrycode );
        $statement1->execute();
        if ($statement1->rowCount() == 0) {
            echo '<h3>Search no result!</h3>';
        }
        else {
            while ($row1 = $statement1->fetch()) {
                outputImage($row1);
            }
        }
    }
    $pdo=null;
}
function outputImage($row){
    echo '<div><a href="img.php?id=' . $row['ImageID'] . '" >';
    echo '<img src="../../travel-images/large/'.$row['Path'].'"></a></div>';
}
function outputlimitimage($result){
    $i=0;
    while (($row = $result->fetch())&&$i<16){
        echo '<div><a href="img.php?id=' . $row['ImageID'] . '" >';
        echo '<img src="../../travel-images/large/'.$row['Path'].'"></a></div>';
        $i++;
    }
}
function creatnumber(){
    $total = floor(($_SESSION['number'] / 16) + 1);
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
    }
    else if ($total > 5) {
        if ($_SESSION['page'] > 0) {
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
    $url='browse.php?'.$GLOBALS['search'].'&page='.$page.'';
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
    <title>Browse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="../css/browse.css">
</head>
<body>
  <!--导航栏-->
  <div class="menu">
   <ul>
    <li><a href="../../index.php">Home</a></li>
    <li id="browse"><a href="browse.php">Browse</a></li>
    <li><a href="search.php">Search</a></li>
    <?php checklog(); ?>
   </ul>
  </div>
  <!--主体内容-->
  <div class="content">
    <!--搜索部分-->
    <div>
       <div class="serach">
        <div>
          <h2>Search by Title</h2>
           <form method="post" action="browse.php">
          <input type="text" name="title">
          &nbsp;
             <input type="submit" id="submit" value="Filter">
           </form>
          <br><br><hr>
        </div>
        <div>
          <h2>Hot Content</h2>
          <a href="browse.php?theme=scenery" >1.Scenery</a><br>
          <a href="browse.php?theme=city" >2.City</a><br>
          <a href="browse.php?theme=people" >3.People</a><br>
          <a href="browse.php?theme=animal" >4.Animal</a><br>
          <a href="browse.php?theme=building" >5.Building</a><br>
          <a href="browse.php?theme=wonder" >6.Wonder</a>
            <br><br><hr>
        </div>
        <div>
            <h2>Hot Country</h2>
            <a href="browse.php?country=China" >China</a><br>
            <a href="browse.php?country=Italy" >Italy</a><br>
            <a href="browse.php?country=Japan" >Japan</a><br>
            <a href="browse.php?country=American" >American</a><br>
            <a href="browse.php?country=Sweden" >Sweden</a>
            <br><br><hr>
        </div>
        <div>
               <h2>Hot City</h2>
               <a href="browse.php?city=beijing" >Beijing</a><br>
               <a href="browse.php?city=paris" >Paris</a><br>
               <a href="browse.php?city=london" >London</a><br>
               <a href="browse.php?city=newyork" >New York</a><br>
               <a href="browse.php?city=shanghai" >Shanghai</a>
               <br><br>
        </div>
    </div>
    </div>
    <!--结果部分-->
    <div class="resault">
        <h2>Filter</h2>
        <form action="browse.php" method="post">
        <select name="theme">
            <option selected>concent</option>
            <option>animal</option>
            <option>scenery</option>
            <option>building</option>
        </select>
        <select id="country" name="country" onchange="addOption()">
            <option selected>country</option>
            <option >China</option>
            <option >Japan</option>
            <option >Italy</option>
            <option >American</option>
        </select>
        <select id="city" name="city">
            <option selected>city</option>
        </select>
        <input value="Filter" type="submit" id="submit">
        </form>
        <br><br><hr>
        <div class="picture">
            <?php checksearch(); ?>
        </div>
        <!--页码-->
        <div class="page">
            <?php
            if (isset($_SESSION['page'])){
                creatnumber();
            }
            ?>
        </div>
    </div>
  </div>
  <!--页脚-->
  <div class="bottom">@19302010060@fudan.edu.cn</div>
  <script src="../../JS/CC.js" type="text/javascript"></script>
</body>
</html>