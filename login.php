<?php 

session_start();
// load database login data
require_once 'dbconnect.php';

//Test basic sql connection

$db_server = mysql_connect($db_host, $db_username, $db_password);
if (!$db_server) {
die("Kan ikke forbinde til MySQL: " . mysql_error());
} 


// connect to mysql database
mysql_connect("$db_host", "$db_username", "$db_password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");




// define username and password as variables
$username=$_POST['empUsername'];
$password=$_POST['empPassword']; 



// mysql security protection (injection cleaner)
$username = stripslashes($username);
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

// check login information from login window to database for verification
$sql="SELECT * FROM $tbl_name WHERE username='$username' and password='$password'";
$result=mysql_query($sql);

// counts number of rows in the result to ensure that the inputdata is only one row
$count=mysql_num_rows($result);
if($count==1){

// redirect if login is successfull
$_SESSION['username'];
$_SESSION['password'];

header("location:login_success.php");
}

// post error message if the login data is wrong
else {
echo "Wrong Username or Password";
}



?>







