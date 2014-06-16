
<form action="listdb.php" method="post">
<?php 

	$host = "localhost";
	$userDB = "root";
	$pass = "";
	$db = "scrumy";


	mysql_connect($host, $userDB, $pass);
	mysql_select_db($db);
	$sql = "SHOW TABLES FROM $db ";
	$result = mysql_query($sql);
	while($table = mysql_fetch_array($result)) { // go through each row that was returned in $result
    echo '<input type="checkbox" name="clearDB['.$table[0].'] "/>'. $table[0] . "<BR>" ;    // print the table that was returned on that row.



}

?>


<input type="submit"  value="clear" name="clear" />
</form>

<?php 
	
	var_dump($_POST);
	foreach ($_POST['clearDB'] as $key => $value) {
		mysql_query(" SET FOREIGN_KEY_CHECKS=0 DELETE FROM `$key` SET FOREIGN_KEY_CHECKS=1 ");
		var_dump(mysql_error());
		//echo $key . " DELETE FROM  `$key` " . ' DELETED - TRUNCATE TABLE '.$key.';</br>';
	}

?>
