<!DOCTYPE html>
<html lang="en">
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.10/angular-ui-router.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
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
		
		<form ng-submit"addFood()"class="form-inline">
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
			<div" id="theSpot">
				
				
			</div>
			
			<div id = "nameSpot">
				
			</div>
		</div>
		
		<div class = "row">
			<div class= "col-md-2 col-sm-offset-6">
				<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#recipeReader">
  Launch Recipe Reader
</button>


<div class="modal fade" id="recipeReader" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Recipe Reader</h4>
        
      </div>
      <div class="modal-body">
      <textarea id = "userRecipe" rows="8" cols="50">
Paste a recipe here. Ingredients will be added to list for you.
</textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onClick= "submitRecipe()" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
			</div>
		</div>
	</div>
		
</div>	
	




<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src = "../components/descOnly.js"></script>
<script src = "../components/descList.js"></script>
<script src = "../core.js"></script>


<script>




$(document).ready(function() {
	//autocomplete code... it's  a pretty bad API, honestly'
       $( "#searchSpot" ).autocomplete({
      source: tags,
      minLength: 4
    });
    
    
});


	//new asynchronous function. #vanilla javascript, baby
	var processJSON = function (json){
		var displayDiv = document.getElementById("theSpot");
		var result = JSON.parse(json);
		
		result.collection.forEach(function(nutrient) {
			var div = document.createElement("food");
				div.innerHTML = result.report.food.nbdno;
				
				displayDiv.appendChild(div);
		});
	}
	
	var displayError = function(error) {
		displayDiv.innerHTML = error;
	}
	
	
	//setting up HTTP Request
	function addFood() {
	var url = "http://api.nal.usda.gov/usda/ndb/reports/?ndbno=";
	var query = document.getElementById('searchSpot').value;
	var row = searchArray(query, nbdList);
	url += row.nbd_no;
	url += "&type=b&format=json&api_key=kTLwZATUYZgBzVIj0bAHakZ4tFqohSN9STf1KWzo";
	console.log(url);
	
	
	var req = new XMLHttpRequest();
	req.open('GET',url,true);
	
	
	//defining callbacks for request to call
	req.onload = function() {
		if (req.status == 200) {
			processJSON(req.response);
		}
	}
	
	//always check for errors
	req.onerror = function() {
		displayError("JSON LOAD FAILED");
	}
	
	
	
	req.send(); //send that  bad boy
	
}
	
	
		

	 function searchArray(key,arr){
	 	for (var i = 0; i < arr.length; i++){
	 		if(arr[i].desc === key) {
	 			return arr[i];
	 		}
	 	}
	 }
	 
	 
	 //OOP apporach TODO - organize this awful mess
	 var Food = function(num,  measure,  name) {
	 	this.num = num;
	 	this.measure = measure;
	 	this.name = name;
	 	id = null;
	 };
	 
	 
	 var lineArray = [];
	 
	 var twoWords = false; 
	 
	 //modal functions: action to take after recipe has been submitted
	 var measures = new Array("cup","tbsp","tablespoon", "oz","ml", "ounce","fl oz", "fluid ounce", "tsp", "teaspoon","pint","pound","lb","quart", "large");
	 function submitRecipe() {
	 	var recipe = document.getElementById("userRecipe").value;
	 	var lines = recipe.split("\n");
	 	
	 	
	 	
	 	console.log(recipe);
	 	
	 
	 	
	 	for (var i = 0; i < lines.length; i++) {
	 		var words = lines[i].split(" "); //split line by each word
	 		
	 			//step ONE - aquire number
	 			
	 			//case 1: numbers and letters in first word
	 			//this typically means the number and the measuring type are one word i.e - 300mL
	 		 if (!isNaN(words[0].charAt(0)) && isNaN(words[0].charAt(words[0].length - 1))) {
	 			words = splitWords(words);
	 			lineArray[i] = new Food(eval(words[0]),null,null);
	 		}
	 	
	 		//case 2:  whole first word is a number, yay!
	 		
	 		
	 			else if(!isNaN(words[0].charAt(0)) && !isNaN(words[0].charAt(words[0].length - 1)) ) {
	 			lineArray[i] = new Food(eval(words[0]),null,null);
	 			
	 			console.log("Current num @ line " + i + " =  " + lineArray[i].num);
	 		
	 		}
	 		
	 		
	 		//base case: no numbers, assume it wants 1 TODO - caution users here
	 		else {
	 			lineArray[i] = new Food(1,null,null);
	 			console.log("Word is not a number");
	 		}
	 		
	 		
	 		//TWO - get the measuring type
	 		//as request in "ideal layout", word number 2 (and possibly 3) will be our measurement amount
	 		
	 		var success = findMeasuringType(words,i);
	 		if (!success) {
	 			alert("WARNING: MEASURING TYPE NOT FOUND on index " + i);
	 		}
	 		
	 		
	 		//step THREE - query the remain words for a food match
	 		//for now, i'm simply going to return anything that matches a keyword
	 		if (twoWords) //indicates that words[1] and words[2] were used for measuring type
	 		{
	 			doQuery(words.splice(3,words.length));
	 		}
	 		else if (!twoWords && success) {
	 			console.log('Trying');
	 			doQuery(words.splice(2,words.length));
	 		}
	 		
	 		else {
	 			doQuery(words.splice(1,words.length));
	 		}
	 		
	 		
	 		
	 	
	 		
	 		twoWords = false;
	 		
	 	}
	 	$('#recipeReader').modal('hide');
	 	console.log("recipe submitted");
	 }
	 
	 //this function will turn 750mL -> 750 mL, returns the array with ideal indexes.
	 
	 function splitWords(wordArray) {
	 	//start this loop at one, if we use this function, we already know the first char is a number
	 	
	 	var targetWord = wordArray[0];
	 	for (var i = 1; i < targetWord.length;i++) {
	 		
	 		if(isNaN(targetWord.charAt(i))) {
	 			
	 			wordArray[0] = targetWord.substring(i);
	 			console.log(targetWord.substring(0,i));
	 			wordArray.unshift(targetWord.substring(0,i));	
	 			return wordArray;	
	 		}
	 	}
	 	
	 	
	 }
	 
	 
	 /*input - one line of recipe words
	   assigns Food object a measuring type
	   returns T if sucessful, returns F if not.
	 
	 */
	 function findMeasuringType(words,index) {
	 	console.log("measure = " + words[1]);
	 	for (var j = 0; j < measures.length; j++) {
	 			//single word instance
	 			if(words[1].toLowerCase() === measures[j] 
	 				|| words[1].toLowerCase() === measures[j] + "s")   {
	 					
	 				alert("Match found " + measures[j]);
	 				lineArray[index].measure = measures[j];
	 				return true;
	 			}
	 			
	 			//check plural form TODO - make this less lazy
	 			
	 			
	 			else if((words[1].toLowerCase() + " " + words[2].toLowerCase()) === measures[j]
	 				|| (words[1].toLowerCase() + " " + words[2].toLowerCase()) === measures[j] + "s") {
	 					
	 					twoWords = true;
	 					console.log('TWO WORDS HERE');
	 				alert("Match found " + measures[j] + "s");
	 				lineArray[index].measure = measures[j] + "s";
	 				return true;
	 			}
	 	}
	 return false;
	 }
	 
	 //TODO - less things on nbdlist, this algorithm is going to return the whole list if I didn't limit the matches...
	 function doQuery(query) {
	
	 	console.log("querying " + query[0]);
	 	var matches = [];
	 	var currFood = [];
	 	
	 	for (var i = 0; i < nbdList.length && matches.length < 50; i++) {
	 			var temp = nbdList[i].desc.split(',');
	 			//console.log("Step one - " + currFood.toString());
	 			
	 			//console.log("Step Two - " + currFood.toString());
	 		if (query[0].toUpperCase() === temp[0]) {
	 			alert("Food found" + temp);
	 			console.log(currFood);
	 			matches.push(temp.toString());
	 			
	 		}
	 		
	 		else {
	 			
	 		
	 			for (var j = 1; j < temp.length; j++) {
	 				for (var p = 0; p < query.length; p++) {
	 				if (query[p] === temp[j]) {
	 					console.log("Found - " + query[p] + " = " + temp[j]);
	 					alert("Secondary match " + temp);
	 					matches.push(currFood.toString());
	 				}
	 			}
	 		
	 		}
	 		}
	 	
	 	
	 	
	 }
	 display(matches);
	 }
	 
	 function display(arr) {
		for(var i = 0; i < arr.length; i++) {
			console.log(arr[i]);
		}	 	
	 }
	
	



	
	
	
	</script>
	</html>
