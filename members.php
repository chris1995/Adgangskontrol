<?php

/*** begin the session ***/
session_start();

if(!isset($_SESSION['user_id']))
{
    $message = 'You must be logged in to access this page';
}
else
{
    try
    {
        /*** connect to database ***/
        /*** mysql hostname ***/
        $mysql_hostname = 'localhost';

        /*** mysql username ***/
        $mysql_username = 'root';

        /*** mysql password ***/
        $mysql_password = '';

        /*** database name ***/
        $mysql_dbname = 'test';


        /*** select the users name from the database ***/
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
        /*** $message = a message saying we have connected ***/

        /*** set the error mode to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*** prepare the insert ***/
        $stmt = $dbh->prepare("SELECT phpro_username, brugertype FROM phpro_users 
        WHERE phpro_user_id = :phpro_user_id");

        /*** bind the parameters ***/
        $stmt->bindParam(':phpro_user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        /*** execute the prepared statement ***/
        $stmt->execute();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if($row['brugertype'] == 1){
                    	$message = $row['phpro_username'] . ' ' . 'Du kan redigere data';
                    }
                    if($row['brugertype'] == 2){
                    	$message = $row['phpro_username'] . ' ' . 'Du kan se data';
                    }
                }
		
        /*** check for a result ***/
        //$phpro_username = $stmt->fetchColumn();
		//$brugertype = $stmt->fetchColumn(1);
		
		///http://php.net/manual/en/pdostatement.fetchcolumn.php/
		
        /*** if we have no something is wrong ***/
        //if($phpro_username == false)
        {
           // $message = 'Access Error';
		}
        //else
        //{
         //if($brugertype == 1){
         //	$message = 'Welcome '.$phpro_username;
         //}
		//else {
			 //$message = $phpro_username;
			 //echo $brugertype;
		//}
        //}
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $message2 = '<td>' . $row['phpro_username'] . '</td>';
                }
    }
    catch (Exception $e)
    {
        /*** if we are here, something is wrong in the database ***/
        $message = 'We are unable to process your request. Please try again later"';
    }
}

?>

<html>
<head>
<title>Members Only Page</title>
</head>
<body>
<h2><?php echo $message; echo $message2; ?></h2>
<?php
if(isset($_SESSION['user_id'])) {
	echo "<p>Click <a href=\"logout.php\">here</a> to log out.</p>";
} else {
	echo "<p>Click <a href=\"login.php\">here</a> to log in.</p>";
}
?>
</body>
</html>