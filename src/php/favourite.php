<?php
require_once('config1.php');

session_start();

function select1(){
    if (isset( $_GET['page'])){
        imageagain();
    }
    else{
        image();
    }
}
if (isset($_GET['page'])) {
    $_SESSION['page'] = $_GET['page'];
}
else{
    $_SESSION['page']=0;
    $_SESSION['number']=0;
}
function image()
{
    try {
        $ID=$_SESSION['id'];
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'select ImageID, UOL from travelimagefavor where UID=:id ';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $ID);
        $statement->execute();
        if($statement->rowCount() == 0){
            echo '<h2>have no photo!</h2>';
        }
        else if($statement->rowCount()>4){
            $i=0;
            while (($row = $statement->fetch(PDO::FETCH_ASSOC))&&$i<4) {
                if($row['UOL']==0) {
                    outputSingleimg($row);
                }
                else{
                    outuserimage($row);
                }
                $i++;
            }
            $_SESSION['page']=0;
            $_SESSION['number']=$statement->rowCount();
        }
        else {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                if($row['UOL']==0) {
                    outputSingleimg($row);
                }
                else{
                    outuserimage($row);
                }
            }
        }

        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
function imageagain()
{
    try {
        $num=$_SESSION['page'];
        $ID=$_SESSION['id'];
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "select ImageID, UOL from travelimagefavor where UID=:id limit $num,4 ";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $ID);
        $statement->execute();
        if($statement->rowCount() == 0){
            echo '<h2>have no photo!</h2>';
        }
        else {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                if($row['UOL']==0) {
                    outputSingleimg($row);
                }
                else{
                    outuserimage($row);
                }
            }
        }

        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
function outputsingleimg($row){
    $id=$row['ImageID'];
    $pdo2 = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql2 = 'select Path,ImageID,Title,Description from  travelimage where ImageID=:imageid';
    $statement2 = $pdo2->prepare($sql2);
    $statement2->bindValue(':imageid', $id);
    $statement2->execute();
    $row2 = $statement2->fetch();
    echo '<div >';
    echo constructdetaillink($row2['ImageID']);
    echo '<img src="../../travel-images/large/'.$row2['Path'].'"></a></div>';
    echo '<div><h2>'.$row2['Title'].'</h2>'  ;
    echo ' <p>'.$row2['Description'].'</p>' ;
    echo '<a href="dcollection.php?id=' . $row2['ImageID'] . '"><button onclick="">Delete</button></a>';
    echo '<hr></div>';
}
function constructdetaillink($id){
     return '<a href="img.php?id=' . $id . '">';
 }
function outuserimage($row){
    $imageid=$row['ImageID'];
    $pdo1 = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql1 = 'select Image, type,Title,Description,ImageID from  traveluserimage where ImageID=:imageid';
    $statement1 = $pdo1->prepare($sql1);
    $statement1->bindValue(':imageid', $imageid);
    $statement1->execute();
    $row1 = $statement1->fetch();
    echo '<div >';
    echo  detaillink($_SESSION['id'],$row1['ImageID']);
    echo '<img src="data:image/png;base64,'.base64_encode(stripslashes($row1['Image'])).'"></a></div>';
    echo '<div><h2>'.$row1['Title'].'</h2>'  ;
    echo ' <p>'.$row1['Description'].'</p>' ;
    echo '<a href="dcollection.php?id=' . $row1['ImageID'] . '"><button onclick="">Delete</button></a>';
    echo '<hr></div>';

}
function detaillink($id,$ImageID){
    return '<a href="img1.php?id=' . $id . '&ImageID='.$ImageID.'">';
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
    $url='favourite.php?page='.$page.'';
    return $url;
}
?>
<script>

</script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>我的收藏</title>
    <link rel="stylesheet" type="text/css" href="../css/my%20favourite.css">
</head>
<body>
    <!--导航栏-->
    <div class="menu">
      <ul name="top">
        <li ><a href="../../index.php">Home</a></li>
        <li><a href="browse.php">Browse</a></li>
        <li ><a href="search.php">Search</a></li>
        <div class="dropdown">
            <a href="" class="dropbtn">My Account</a>
            <div class="dropdown-content">
                <a href="up.html"><img src="../../img/16.png"> upload</a>
                <a href="myphoto.php"><img src="../../img/4.png"> my photo</a>
                <a href="favourite.php" id="myfavourite"><img src="../../img/3.png"> my favourite</a>
                <a href="logout.php"><img src="../../img/2.png"> log out</a>
            </div>
        </div>
      </ul>
    </div>
    <!--标题-->
    <h1>My Favourite</h1>
    <!--主体内容，采用grid布局-->
    <div class="content">
      <!--<div><a href="图片.html"><img src="../../img/travel-images/square/square-medium/6114867983.jpg"></a></div>
      <div>
        <h2>Title</h2>
        <p>During your trip Down Under, you can experience everything from curious quokkas to welcoming country pubs. Follow your sense of adventure as you drive along the Great Ocean Road, embark on a journey around Tasmania or hop from one waterhole to the next in the Northern Territory. From short city breaks and coastal drives to luxury itineraries and epic trips across the outback, here are some suggestions to get you started on your Australian adventure.</p>
        <a href=""><button onclick="alert('Be sure to cancel your photo collection !')">Delete</button></a>
        <hr>
      </div>
      <div><a href="图片.html"><img src="../../img/travel-images/normal/medium/5855213165.jpg"></a></div>
      <div>
        <h2>Title</h2>
        <p>During your trip Down Under, you can experience everything from curious quokkas to welcoming country pubs. Follow your sense of adventure as you drive along the Great Ocean Road, embark on a journey around Tasmania or hop from one waterhole to the next in the Northern Territory.</p>
        <a href=""><button onclick="alert('Be sure to cancel your photo collection !')">Delete</button></a>
        <hr>
      </div>
      <div><a href="图片.html"><img src="../../img/travel-images/normal/medium/9496560520.jpg"></a></div>
      <div>
        <h2>Title</h2>
        <p>During your trip Down Under, you can experience everything from curious quokkas to welcoming country pubs. Follow your sense of adventure as you drive along the Great Ocean Road, embark on a journey around Tasmania or hop from one waterhole to the next in the Northern Territory. From short city breaks and coastal drives to luxury itineraries and epic trips across the outback, here are some suggestions to get you started on your Australian adventure.</p>
        <a href=""><button onclick="alert('Be sure to cancel your photo collection !')">Delete</button></a>
        <hr>
      </div>
      <div><a href="图片.html"><img src="../../img/travel-images/normal/medium/9504448540.jpg"></a></div>
      <div>
        <h2>Title</h2>
        <p>During your trip Down Under, you can experience everything from curious quokkas to welcoming country pubs. Follow your sense of adventure as you drive along the Great Ocean Road, embark on a journey around Tasmania or hop from one waterhole to the next in the Northern Territory. From short city breaks and coastal drives to luxury itineraries and epic trips across the outback, here are some suggestions to get you started on your Australian adventure.</p>
        <a href=""><button onclick="alert('Be sure to cancel your photo collection !')">Delete</button></a>
        <hr>-->
        <?php select1();?>
      <!--页码-->
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
    <!--返回顶部-->
    <div class="button">
         <a href="#top"><img src="../../img/top.png" ></a>
    </div>
</body>
</html>