<?php 
ini_set('display_errors', true);
if( $_REQUEST["TaskName"] || $_REQUEST["TaskId"] || $_REQUEST["TaskDescription"] || $_REQUEST["actionStatus"])
{
	$TaskDataSource = file_get_contents('Task_Data.txt');
	$taskArray = json_decode($TaskDataSource);
	if($_REQUEST["actionStatus"]=="Save")
	{
		$input->TaskId=$_REQUEST["TaskId"];//add;
		$input->TaskName=$_REQUEST["TaskName"];
		$input->TaskDescription=$_REQUEST["TaskDescription"];
		array_push($taskArray,$input);
			
	}
	else if($_REQUEST["actionStatus"]=="Delete")//Delete
		{$x=0;
			foreach ($taskArray as $task) {
				if($task->TaskId == $_REQUEST["TaskId"])
				{
					array_splice($taskArray, $x, 1);//Remove from array
				}	$x=$x+1;
			}
			$taskArray = array_values($taskArray);
		}
		$json = json_encode($taskArray);//Save
		file_put_contents('Task_Data.txt', $json);
}
?>