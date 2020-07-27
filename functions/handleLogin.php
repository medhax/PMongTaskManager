<?php
session_start();
			// Connection info. file
			include './main_functions.php';	
			
		
			// Check connection
			if (!$db) {
				die("Connection failed: " . mysqli_connect_error());
			}
			
			// data sent from form login.html 
			$email = $_POST['username']; 
			$password = $_POST['password'];
			
         // Query sent to database

         $result = mysqli_query($db, "SELECT * FROM users WHERE username = '$email' ");
			
			// Variable $row hold the result of the query
			$row = mysqli_fetch_assoc($result);
			
			// Variable $hash hold the password hash on database
			$hash = $row['password'];
         
         
         
			/* 
			password_Verify() function verify if the password entered by the user
			match the password hash on the database. If everything is OK the session
			is created for one minute. Change 1 on $_SESSION[start] to 5 for a 5 minutes session.
			*/
			if (password_verify($_POST['password'], $hash)) {	
				
				$_SESSION['loggedin'] = true;
            $_SESSION['name'] = $row['fullName'];
            $_SESSION['username'] = $row["username"];
				$_SESSION['start'] = time();
				$_SESSION['expire'] = $_SESSION['start'] + (1 * 60) ;						
            
            
            header('Location: ../index.php');	
			
			} else {
				echo "<div class='alert alert-danger mt-4' role='alert'>Email or Password are incorrects!
				<p><a href='../login.php'><strong>Please try again!</strong></a></p></div>";			
			}	
			?>