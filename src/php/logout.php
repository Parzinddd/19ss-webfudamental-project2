<?php
session_start();
unset($_SESSION['admin']);
echo "<script type='text/javascript'>alert('注销成功！');location.href='log.php';</script>";
?>
