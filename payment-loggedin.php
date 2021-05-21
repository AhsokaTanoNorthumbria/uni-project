<?php
require_once 'general_functions.php';

		try{
			//make connection with database
			$dbConn = getConnection();
			//sql statement with placeholders ready to be prepared
			$querySQL = "SELECT * from courses WHERE course_id =:courseID";
			//prepares the SQL statement and stores it in a new variable
			$statement = $dbConn->prepare($querySQL);
			//executes the SQL statement, replacing the course placeholder with the actual course selected by the user
			$statement->execute(array(':courseID'=> $courseID));
			
			//store the results of the SQL query in an object
			$course = $statement->fetchObject();
		}
		catch (Exception $e) {
            $m = "Failed to get course details";
            exceptionHandler($e, $m);
		}
	
?>


<h3 class="text-start mt-5"><b>Order Summary</b></h3>
				<br>
				<!--Create table showing the course chosen and its price-->
				<table class="table table-condensed">
				  <thead>
					<tr>
					  <th>Quantity</th>
					  <th>Name</th>
					  <th>Price (GBP)</th>
					</tr>
				  </thead>
				  <tbody>
					<tr>
					  <td>1</td>
					  <!--Get values from database related to the course-->
					  <td>'<?php echo $course->course_title ?>' course</td>
					  <td>£<?php echo $course->course_price ?></td>
				   </tr>
				 </tbody>
				</table>
		  
		  <!--Paypal button -->
		  <div id="smart-button-container">
			  <div style="text-align: center;">
				<div id="paypal-button-container"></div>
			  </div>
			</div>
		  <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=GBP" data-sdk-integration-source="button-factory"></script>
		  <script>
		  //collect PHP data in javascript for use with the Paypal button
		  var courseID = "<?php echo $course->course_id ?>";
		  var courseName = "<?php echo $course->course_title ?>";
		  var coursePrice = "<?php echo $course->course_price ?>";
		  var userHash = "<?php echo $_COOKIE['hash'] ?>";
		  
			function initPayPalButton() {
			  paypal.Buttons({
				style: {
				  shape: 'rect',
				  color: 'gold',
				  layout: 'vertical',
				  label: 'pay',

				},

				createOrder: function(data, actions) {
				  return actions.order.create({
					purchase_units: [{"description":courseName,"amount":{"currency_code":"GBP","value":coursePrice}}]
				  });
				},

				onApprove: function(data, actions) {
					//payment accepted
					alert("Processing order...");
				  return actions.order.capture().then(function(details) {
					alert("The course '"+ courseName + "' has been successfully purchased.");
					
					
					/* pass in Javascript courseID variable to web url and the user hash in encoded format*/
					
					courseID = encodeURIComponent(courseID);
					userHash = encodeURIComponent(userHash);
					
					/* now payment is accepted, user is redirected to paidCourse.php to add the course to their account*/
					var URL_string = "paidCourse.php?courseID=" + courseID + "&payment=" + userHash; 
					window.location = URL_string;
				  });
				},

				onError: function(err) {
				  console.log(err);
				}
			  }).render('#paypal-button-container');
			}
			initPayPalButton();
		  </script>