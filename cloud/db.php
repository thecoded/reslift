<?php

$database = "swank";

// databaseQuery function- simple function to run a predefined SQL query and return nothing
function dbQuery($query){
	global $database;
	$link = mysqli_connect("localhost", 'swank', 'swank123', $database);
	mysqli_query($link, $query);
	mysqli_close($link);
}

// databaseQueryData function - take a predefined query, execute it and return the result
function dbQueryData($query){
	global $database;
	$ret = NULL;
	
	$link = mysqli_connect("localhost", 'swank', 'swank123', $database);
	
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	/* Select queries return a resultset */
	if ($result = mysqli_query($link, $query)){
		$mem = mysqli_fetch_array($result);
	
		if (count($mem) >= 1)
			$ret = $mem;
			
		unset($mem);	
		/* free result set */
		mysqli_free_result($result);
	}
	
	mysqli_close($link);
	return $ret;
}

// databaseQueryMassData function - take a predefined query, execute it and return the result
function dbMassData($query){
	global $database;
	$ret = NULL;
	
	$link = mysqli_connect("localhost", 'swank', 'swank123', $database);
	
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	/* Select queries return a resultset */
	if ($result = mysqli_query($link, $query)){

		while ($row = mysqli_fetch_assoc($result)){
				$ret[] = $row;
		} 
	
		mysqli_free_result($result);
	}
	
	mysqli_close($link);
	return $ret;
}

?>



	
