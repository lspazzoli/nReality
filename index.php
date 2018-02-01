<!DOCTYPE html>
<html>
<head>
    <title>Basic Twitter HashTag Search</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body>

<!-- Modal Used To Display Full Tweet -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <form action="update_task.php" method="post">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 5px;;">
                            <input id="InputTaskName" type="text" placeholder="Task Name" class="form-control" readonly="readonly">
                        </div>
                        <div class="col-md-12">
                            <textarea id="InputTaskDescription" placeholder="Description" class="form-control" readonly="readonly"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="deleteTask" type="button" class="btn btn-danger">Delete Tweet</button>
                <button id="saveTask" type="button" class="btn btn-primary">Save Tweet</button>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <h2 class="page-header">Tweet HashTag View
				<button id="numDis" type="button" class="btn btn-primary btn-lg" style="width:45%;margin-bottom: 5px;float: right;" onClick="num()">
				Change Number of tweets to display</button>
			</h2>
            <!-- Button trigger modal -->
            <button id="Search" type="button" class="btn btn-primary btn-lg" style="width:100%;margin-bottom: 5px;" onClick="searchHash()">
                Search HashTag
            </button>
			<button id="view" type="button" class="btn btn-primary btn-lg" style="width:100%;margin-bottom: 5px;" onClick="viewSaved()">
                View Saved Tweets
            </button>
            <div id="TaskList" class="list-group">
                </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="assets/js/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var currentTaskId = -1;
	var prevSelectedTaskId = 0;
	var prevSelectedTaskName = "";
	var prevSelectedTaskDescription = "";
	
	
     $('#myModal').on('show.bs.modal', function (event){ //Information View
		var triggerElement = $(event.relatedTarget); // Element that triggered the modal
        var modal = $(this);
		if (triggerElement.attr("href") == 'viewTweet') 
		{ 
			$('#deleteTask').show();
			$('#saveTask').hide();
		}
		else 
		{
			$('#saveTask').show();
			$('#deleteTask').hide();
		}
		modal.find('.modal-title').text('Task details');
		currentTaskId = triggerElement.attr("id");
		console.log('Task ID: '+triggerElement.attr("id"));
		prevSelectedTaskId = triggerElement.attr("id");
		prevSelectedTaskName = triggerElement.find('.list-group-item-heading')[0].innerText;
		prevSelectedTaskDescription = triggerElement.find('.list-group-item-text')[0].innerText;
		modal.find('#InputTaskName').val(prevSelectedTaskName);
		modal.find('#InputTaskDescription').val(prevSelectedTaskDescription);
			
    });	
			
    $('#saveTask').click(function(event){
		 var textDetail = $('#InputTaskDescription').val();
		 var name = $('#InputTaskName').val();
		 //Post Task to Text File
		$.post("update_task.php",{TaskId: currentTaskId,TaskName: name,TaskDescription: textDetail,actionStatus: "Save"})
			.done(function(msg){ 
			//alert(msg+" Message"); 
			$('#myModal').modal('hide'); })
		.fail(function(xhr, status, error) {alert(error+" Error");});		
       
    });
	
	$('#deleteTask').click(function() {
        //alert('Delete... Id:'+currentTaskId);
		 var textDetail = $('#InputTaskDescription').val();
		 var name = $('#InputTaskName').val();
		 //Delete tweet from text file
		$.post("update_task.php",
		{TaskId:currentTaskId,TaskName: name,TaskDescription: textDetail,actionStatus:"Delete"}).done(function(msg){ 
			//alert(msg+" Message"); 
			$('#myModal').modal('hide');
			viewSaved(); })
		.fail(function(xhr, status, error) {alert(error+" Error");});	
    });
	
	function viewSaved() {//Get Saved Tweets
		  $.post("list_tasks.php", function( data ) {$( "#TaskList" ).html( data );});
		}
		
	function searchHash(){//Search For A hashtag and display first 15 entries
		var hash = prompt("Please Enter a HashTag to Search for", "");
		while (hash==""||hash==null)
		{
			hash = prompt("Noting Entered\nPlease Enter a HashTag to Search for", "");
		}
		document.cookie="hash="+hash; 
		$.post("TwitterView.php", function( data ) {$( "#TaskList" ).html( data );});
		}
		
	function num()
	{
		var num = prompt("Please Enter a Number Of tweets to display", "");
		while (num==""||num==null||isNaN(num))
		{
			num = prompt("Nothing Entered or Data Entered is not a number\nPlease Enter a Number Of tweets to display", "");
		}
		document.cookie="num="+num;
	}
	
	num();
	
	
</script>
</html>