<?php
require_once('config1.php');
session_start();
    function select2(){
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
            $UID=$_SESSION['id'];
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

            $sql = 'select Image, Description,Title,type,UID,ImageID  from  traveluserimage where UID=:id';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':id', $UID);
            $statement->execute();
            if($statement->rowCount() == 0){
                echo '<h2>have no photo!</h2>';
            }
            else if($statement->rowCount()>4){
                $i=0;
                while (($row = $statement->fetch())&&$i<4) {
                    outputSingleimg($row);
                    $i++;
                }
                $_SESSION['page']=0;
                $_SESSION['number']=$statement->rowCount();
            }
            else {
                while ($row = $statement->fetch()) {
                    outputSingleimg($row);
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
            $UID=$_SESSION['id'];
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

            $sql = "select Image, Description,Title,type,UID,ImageID  from  traveluserimage where UID=:id LIMIT $num,4 ";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':id', $UID);
            $statement->execute();
            if($statement->rowCount() == 0){
                echo '<h2>have no photo!</h2>';
            }
            else {
                while ($row = $statement->fetch()) {
                    outputSingleimg($row);
                }
            }

            $pdo = null;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function outputsingleimg($row){
        echo '<div>';
        echo constructdetaillink($row['UID'], $row['ImageID']);
    //  echo '<img src="imageView.php?type='.$row['type'].';image='.$row['Image'].'"></a></div>';
    //  echo '<img src="data:'.$row['type'].';base64,'.base64_encode($row['Image']).'"></a></div>';
        echo '<img src="data:image/png;base64,'.base64_encode(stripslashes($row['Image'])).'"></a></div>';
        echo '<div><h2>'.$row['Title'].'</h2>'  ;
        echo ' <p>'.$row['Description'].'</p>' ;
        echo '<a href="Modigy.php?id='.$row['ImageID'].'"><button>Modify</button></a>';
        echo '<a href="dmyphoto.php?id='.$row['ImageID'].'"><button onclick="alert(\'Be sure to delete your photo!\')">Delete</button></a>';
        echo '<hr></div>';
    }

    function constructdetaillink($id,$ImageID){
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
        $url='myphoto.php?page='.$page.'';
        return $url;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>我的照片</title>
    <link rel="stylesheet" type="text/css" href="../css/my%20photo.css">
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
                <a href="myphoto.php" id="myphoto"><img src="../../img/4.png"> my photo</a>
                <a href="favourite.php"><img src="../../img/3.png"> my favourite</a>
                <a href="logout.php"><img src="../../img/2.png"> log out</a>
            </div>
        </div>
     </ul>
   </div>
   <!--标题-->
   <h1>My Photograph</h1>
   <!--主体内容，grid布局-->
   <div class="content">
       <!--图片-->
       <?php select2(); ?>
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
   <!--回到顶部-->
   <div class="button">
       <a href="#top"><img src="../../img/top.png" ></a>
   </div>
</body>
</html>