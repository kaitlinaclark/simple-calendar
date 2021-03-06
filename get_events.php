<?php
echo "hi";
session_start();
require 'connect.php';
//prepare query
$query_events = $connect->prepare("select assoc_date, 
                            			title, 
                            			event_id from events 
                                			where user_id=?");
//check query prep and return error
if(!$query_events){
	echo json_encode(array("success" => false, "message" => "Query Prep Failed"));
}
else{
	//bind parameters
	$query_events->bind_param('i', $user_id);
		$user_id = $_SESSION['user_id'];

	//execute query and bind results
	$query_events->execute();
	$query_events->bind_result($date, $title, $event_id);
	//extract values from result
	while($query_events->fetch()){
		$date = split("-", $date, 3);
		//get day and month
		$day = (int) $date[2];
		$month = (int) $date[1];

		json_encode(array("success" => true, "data" => array("day" => $day, "month" => $month, "title" => $title, "event_id" => $event_id)));
	}
}
echo "bye";
?>
