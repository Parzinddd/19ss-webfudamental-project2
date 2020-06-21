<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <script src="../../JS/jq/jquery-3.4.1/jquery-3.4.1.min.js"></script>
    <title>注册界面</title>
   <link rel="stylesheet" type="text/css" href="../css/sign%20up.css">
</head>
<body>
<script type="text/javascript"
        color="122 103 238" opacity='0.7' zIndex="-2" count="200" src="//cdn.bootcss.com/canvas-nest.js/1.0.0/canvas-nest.min.js">
</script>
 <form method="POST">
    <div class="login"><!--边框-->
        <div class="logo"></div><!--头像-->
        <div class="form"><!--输入框-->
            <small id="name1">请输入用户名</small>
            <input id="username" type="text" name="username" autocomplete="off" placeholder="用户名" required onblur="account();check()" onkeyup="account();check()">
        </div>
        <div class="form"><!--输入框-->
            <small id="mail1">请输入邮箱</small>
            <input id="useremail" type="text" name="useremail" autocomplete="off" placeholder="邮箱"  required onblur="email();check()" onkeyup="email();check()">
        </div>
        <div class="form"><!--输入框-->
            <small id="psw1">请输入密码</small>
            <input id="password" type="password" name="password" autocomplete="off" placeholder="密码"  required onblur="psw();check()" onkeyup="psw();check()">
        </div>
        <div class="form"><!--输入框-->
            <small id="psw2">请再次输入密码</small>
            <input id="password1" type="password"  name="password1" autocomplete="off" placeholder="密码"  required onblur="psw1();check()" onkeyup="psw1();check()">
        </div>
        <div class="form"><input type="submit" value="注 册" id="submit" disabled="disabled"><!--注册按钮--></div>
    </div>
   </form>
    <div class="bottom">@19302010060@fudan.edu.cn</div><!--页脚-->
</body>
</html>
<script>
    var flags = [false,false,false,false];
    /*邮箱正则*/
    var RegEmail = /[\w]+(.[\w]+)*@[\w]+(.[\w])+/;
    /*用户名正则*/
    var Tname =/^[0-9a-zA-Z_]{1,}$/
    /*用户名检验*/
    function account(){

        var account = $("#username").val();
        var option = document.getElementById("name1");
        option.innerHTML="";
        var textNode = document.createTextNode("用户名格式错误！");
        var textNode1 = document.createTextNode("用户名格式正确！");
        var textNode2 = document.createTextNode("请输入用户名");
        if(account==""){
            option.appendChild(textNode2);
            flags[0] = false;
        }
        else if(!Tname.test(account)) {
            option.appendChild(textNode);
            flags[0] = false;
            }
        else{
            option.appendChild(textNode1);
            flags[0] = true;
        }

    }
    /*邮箱检验*/
    function email(){

        var email = $("#useremail").val();
        var option = document.getElementById("mail1");
        option.innerHTML="";
        var textNode = document.createTextNode("邮箱格式错误！");
        var textNode1 = document.createTextNode("邮箱格式正确！");
        var textNode2 = document.createTextNode("请输入邮箱");
        if(email==""){
            option.appendChild(textNode2);
            flags[1] = false;
        }
        else if(!RegEmail.test(email)) {
            option.appendChild(textNode);
            flags[1] = false;
        }
        else{
            option.appendChild(textNode1);
            flags[1] = true;
        }

    }
    /*密码检验*/
    function psw(){

        var psw1 = $("#password").val();
        var option = document.getElementById("psw1");
        option.innerHTML="";
        var textNode = document.createTextNode("密码过于简单！");
        var textNode1 = document.createTextNode("密码格式正确！");
        var textNode2 = document.createTextNode("请输入密码");
        if(psw1==""){
             option.appendChild(textNode2);
            flags[2] = false;
        }
        else if(psw1.length<6) {
            option.appendChild(textNode);
            flags[2] = false;
        }
        else{
            option.appendChild(textNode1);
            flags[2] = true;
        }

    }
    /*再次输入密码检验*/
    function psw1() {

        var psw2=$("#password1").val();
        var option = document.getElementById("psw2");
        option.innerHTML="";
        var textNode = document.createTextNode("密码不一致！");
        var textNode1 = document.createTextNode("密码格式正确！");
        var textNode2 = document.createTextNode("请再次输入密码");
        if(psw2==""){
            option.appendChild(textNode2);
            flags[3] = false;
        }
        else if(psw2!=$("#password").val()){
            option.appendChild(textNode);
            flags[3] = false;
        }
        else {
            flags[3] = true;
            option.appendChild(textNode1);
        }

    }
    function check() {
       for (var i=0;i<4;i++) {
           if (!flags[i]) {
               $("#submit").attr("disabled", "disabled");
               break;
           }
           else {
               $("#submit").removeAttr("disabled");
           }
       }

    }
</script>
<?php
 require_once('config1.php');

 function checkmail(){
 try {
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $sql = 'select Username from traveluser WHERE Username=:user';

         $statement = $pdo->prepare($sql);
         $statement->bindValue(':user', $_POST['username']);
         $statement->execute();

         $sql1 = 'INSERT INTO traveluser VALUES(null,:email,:user,:psw,null ,null,null)';
         $statement1 = $pdo->prepare($sql1);


         $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
         $statement1->bindValue(':email',$_POST['useremail']);
         $statement1->bindValue(':psw',$password);
         $statement1->bindValue(':user', $_POST['username']);

         if ($statement->rowCount() > 0) {

             echo "<script type='text/javascript'>alert('用户名已存在！');</script>";
         }
         else{

             $statement1->execute();
             echo "<script type='text/javascript'>alert('注册成功！');location.href='log.php';</script>";
         }
         $pdo = null;
     }
 }
 catch (PDOException $e){
       die( $e->getMessage() );
    }
 }
 checkmail();


?>