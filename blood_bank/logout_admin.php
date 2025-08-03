<?php
session_start();
session_destroy();
header("Location: admin_login_simple.php");
exit();
