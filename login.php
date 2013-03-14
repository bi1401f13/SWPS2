<?php 
// load database login data
require_once 'dbconnect.php';

// connect to mysql database
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// define username and password as variables
$username=$_POST['emp_username'];
$password=$_POST['emp_password']; 

// mysql security protection (injection cleaner)
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

// check login information from login window to database for verification
$sql="SELECT * FROM $tbl_name WHERE username='$username' and password='$password'";
$result=mysqli_query($sql);

// counts number of rows in the result to ensure that the inputdata is only one row
$count=mysqli_stmt_num_rows($result);
if($count==1){

// redirect if login is successfull

session_register("username");
session_register("password");
header("location:login_success.php");
}

// post error message if the login data is wrong
else {
echo "Wrong Username or Password";
}
?>