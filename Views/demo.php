<!DOCTYPE html>

<html lang="en">
	<head>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.10/angular-ui-router.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<link rel = "stylesheet" href="../components/main.css">

</head>
<body>
	<div ng-app="foodAdvise" ng-controller="foodController">
<div class = "container">
<div class = "row">
	<div class = "col md-9 col-md-offset-3" >
		<img src = "..\logo.png">
	</div>
	
	
</div>
<div>
<div>
<div>
	<div>
</div>
	<div class = "row">
	<div class = "col-md-9 col-md-offset-3">
		
		<form class="form-inline">
  <div class="form-group">
    <div class="ui-widget">
  <label for="tags">Food Name: </label>
  <input ng-model="query" id="searchSpot" style= "width: 355px">
  <button onclick="addFood()" type="button" style = "margin-left: 20px" class="btn btn-primary active" id= "searchFood">Add</button>
</div>

<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary active">
    <input ng-model = "servings" type="radio" name="options" id="option1/2" autocomplete="off" checked> 1/2 Serving
  </label>
  <label class="btn btn-primary">
    <input ng-model = "servings" type="radio" name="options" id="option1" autocomplete="off"> 1 Serving
  </label>
  <label class="btn btn-primary">
    <input ng-model = "servings" type="radio" name="options" id="option2" autocomplete="off"> 2 Servings
  </label>
    <label class="btn btn-primary">
    <input ng-model = "servings" type="radio" name="options" id="option3" autocomplete="off"> 3 Servings
  </label>

  <label class="btn btn-primary">
    <input ng-model = "servings"  type="radio" name="options" id="option4" autocomplete="off"> 4 Servings
  </label>

  <label class="btn btn-primary">
    <input ng-model = "servings" type="radio" name="options" id="option5" autocomplete="off"> 5 Servings
  </label>

</div>
 
</form>
	</div>
	
	
	</div>
	
	 
	
	<div class = "row">
		<div class = "col-md-6 col-md-offset-3">
			
			<div id="theSpot">
				
				
			
			<ul data-role="listview" id = "nameSpot">
				 <li><a href="#"><strong>Toronto</strong>2004</a></li>
				
			</ul>
			
			</div>
		</div>
	</div>
		
</div>	
	
</body>



<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src = "../components/descOnly.js"></script>
<script src = "../components/descList.js"></script>


<script>



$(document).ready(function() {
	//autocomplete code... it's  a pretty bad API, honestly'
       $( "#searchSpot" ).autocomplete({
      source: tags,
      minLength: 4
    });
    
    
});


	//new asynchronous function. #vanilla javascript, baby
function ajax_get(url,callback) {
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//console.log('responseText:' + xmlhttp.responseText);
				try {
					var data = JSON.parse(xmlhttp.responseText);
					nutList.push(data);
				}
				catch (err){
					console.log(err.message);
					return;
				}
				callback(data); //callback was our passed function, and we are calling it now
			} //end xmlcall
	};
	
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
	
}

	var nutList = []; //blank array
	
	//setting up HTTP Request
	function addFood() {
		
		
	var url = "http://api.nal.usda.gov/usda/ndb/reports/?ndbno=";
	var query = document.getElementById('searchSpot').value;
	var row = searchArray(query, nbdList);
	url += row.nbd_no;
	url += "&type=b&format=json&api_key=kTLwZATUYZgBzVIj0bAHakZ4tFqohSN9STf1KWzo";
	console.log(url);
	
	ajax_get(url, function(data) {
		
		
			 var str = '<li>' + data.report.food.name + '</li>';
		
		
		
		 
		$('#nameSpot').append(str).listview('refresh');
		//console.log(str);
	});
	
	
	
	
	

	
}
	
	
		

	 function searchArray(key,arr){
	 	for (var i = 0; i < arr.length; i++){
	 		if(arr[i].desc === key) {
	 			return arr[i];
	 		}
	 	}
	 }
	



	
	
	
	</script>
	</html>
