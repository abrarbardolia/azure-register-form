 <html>
 <head>
 <Title>Covid Portal</Title>
 <style type="text/css">
 	body { background-color: #fff; border-top: solid 10px #000;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	table { margin-top: 0.75em; }
 	th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
 	td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
 </style>
 </head>
 <body>
 <h1>Register Covid Report!</h1>
 <p>Fill in below details & then click <strong>Submit</strong> to register.</p>
 <form method="post" action="index.php" enctype="multipart/form-data" >
       Name      <input type="text" name="name" id="name"/></br>
       Email     <input type="text" name="email" id="email"/></br>
       Mobile    <input type="text" name="mobile" id="mobile"/></br>
       Covid Positive <select name="covid_status">
       <option value="">Select...</option>
       <option value="No">No</option>
       <option value="Yes">Yes</option>
       </select></br>
       
       <input type="submit" name="submit" value="Submit" />
 </form>
 <?php
 // DB connection info
 $host = "abrar-database-server.database.windows.net";
 $user = "abrar";
 $pwd = "password@12#";
 $db = "abrar-spq-database";    //abrar-spq-database ... registration
 // Connect to database.
 try {
 	$conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
 	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
 }
 catch(Exception $e){
 	die(var_dump($e));
 }
 if(!empty($_POST)) {
 try {
 	$name = $_POST['name'];
 	$email = $_POST['email'];
  $mobile = $_POST['mobile'];
  $covidstatus = $_POST['covid_status'];
 	$date = date("Y-m-d");
 	// Insert data
 	$sql_insert = "INSERT INTO registration_tbl (name, email, mobile , covid_status, date) 
 				   VALUES (?,?,?,?,?)";
 	$stmt = $conn->prepare($sql_insert);
 	$stmt->bindValue(1, $name);
 	$stmt->bindValue(2, $email);
  $stmt->bindValue(3, $mobile);
  $stmt->bindValue(4, $covidstatus); 
 	$stmt->bindValue(5, $date);
 	$stmt->execute();
 }
 catch(Exception $e) {
 	die(var_dump($e));
 }
 echo "<h3>Report Added!</h3>";
 }
 $sql_select = "SELECT * FROM registration_tbl";
 $stmt = $conn->query($sql_select);
 $registrants = $stmt->fetchAll(); 
  if(count($registrants) > 0) {
 	echo "<h2>Covid Report:</h2>";
 	echo "<table>";
 	echo "<tr><th>Name</th>";
 	echo "<th>Email</th>";
  echo "<th>Mobile</th>";
  echo "<th>Covid Positive</th>";
 	echo "<th>Date of Testing</th></tr>";
   
 	foreach($registrants as $registrant) {
 		echo "<tr><td>".$registrant['name']."</td>";
 		echo "<td>".$registrant['email']."</td>";
   echo "<td>".$registrant['mobile']."</td>";
   echo "<td>".$registrant['covid_status']."</td>";
 		echo "<td>".$registrant['date']."</td></tr>";
     }
  	echo "</table>";
 } else {
 	echo "<h3>No Report added.</h3>";
 }

 ?>
 </body>
 </html>
