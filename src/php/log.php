<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="../css/log.css">
</head>
<body>
<script type="text/javascript"
        color="122 103 238" opacity='0.7' zIndex="-2" count="200" src="//cdn.bootcss.com/canvas-nest.js/1.0.0/canvas-nest.min.js">
</script>
  <form method="post" >
  <div class="login"><!--边框-->
    <div class="logo"></div><!--头像-->
    <div class="form"><!--输入框-->
        <input id="username" name="username" type="text" autocomplete="off" placeholder="邮箱">
    </div>
    <div class="form"><!--输入框-->
        <input id="password" name="psw" type="password" autocomplete="off" placeholder="登录密码">
    </div>
     <a href="../../index.php"><div class="form" ><button>登 录</button></div></a><!--登录按钮-->
    <div class="log"><!--两个下角链接-->
     <a class="reg" href="signup.php">立即注册</a>
     <a class="forget" href="">忘记密码</a>
    </div>
  </div>
  </form>
      <!--页脚-->
  <div class="bottom">@19302010060@fudan.edu.cn</div>
</body>
</html>
<?php
   require_once("config1.php");

function checkLogin(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);

    $sql = "SELECT UID,Pass FROM traveluser WHERE Email=:useremail ";
    //$password=password_hash($_POST['psw'],PASSWORD_DEFAULT);
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':useremail',$_POST['username']);
    //$statement->bindValue(':pass',$password);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if($statement->rowCount()>0){
        if(password_verify($_POST['psw'],$row['Pass'])) {
            session_start();
            $_SESSION["id"] = $row['UID'];
            return true;
        }
        else{
            return false;
        }
    }
    return false;
}

   if ($_SERVER["REQUEST_METHOD"] == "POST"){
       if(checkLogin()){


           $_SESSION["admin"] = true;
           echo "<script type='text/javascript'>alert('登录成功！');location.href='../../index.php';</script>";
       }
       else{
           echo "<script type='text/javascript'>alert('用户名或密码错误！');</script>";

       }
   }




















?>