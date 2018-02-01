<?php
$taskData = file_get_contents('Task_Data.txt');
$html = '<a id="newSearch" onClick="searchHash()" class="list-group-item" >
                    <h4 class="list-group-item-heading">No Tweets Saved</h4>
                    <p class="list-group-item-text">Click here to Search For One</p>
                </a>';
if (strlen($taskData) < 1) {
    die($html);
}
$taskArray = json_decode($taskData);
if (sizeof($taskArray) > 0) {
    $html = '';
    foreach ($taskArray as $task) {
        $html .= '<a id="'.$task->TaskId.'" href="viewTweet" class="list-group-item" data-toggle="modal" data-target="#myModal">
                    <h4 class="list-group-item-heading">'.$task->TaskName.'</h4>
                    <p class="list-group-item-text">'.$task->TaskDescription.'</p>
                </a>';
    }
}
die($html);
?>