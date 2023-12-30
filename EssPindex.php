<?php
session_start();
include 'conndb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the employee id from the form
  $employeeId = $_POST["idemployees"];

  // Validate and sanitize the input to prevent SQL injection
  $employeeId = mysqli_real_escape_string($conn, $employeeId);

  // Construct the SQL query
  $sql = "SELECT * FROM employees WHERE idemployees = '$employeeId'";

  // Execute the query
  $result = $conn->query($sql);

  // Check if the query was successful
  if ($result) {
    // Check if any rows were returned
    if ($result->num_rows > 0) {
      // Employee found, you can fetch data here if needed
      // For example, you can store the employee ID in the session for later use
      $_SESSION["employeeId"] = $employeeId;

      // Redirect to the homepage or wherever you want to go after successful login
      header("Location: Homepage.php");
      exit();
    } else {
      // No matching employee found, handle accordingly (e.g., show an error message)
      echo "Employee not found. Please check your ID.";
    }
  } else {
    // Query execution failed, handle accordingly
    echo "Error: " . $conn->error;
  }

  // Close the database connection
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EssP_Login</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <form method="post">
    <div class="container">
      <div class="left">
        <div class="EssPLogo">
          <div class="logo-text">Employee Self-Service Portal</div>
          <div class="logo-shape">ES-SP</div>
        </div>
        <img src="EssPLogo.png" alt="EssPLogo" class="EssPLogo">
      </div>
      <div class="right">
        <div class="greeting">Welcome Back!</div>
        <label for="idemployees" class="input-label">idemployees</label>
        <input type="number" id="idemployees" name="idemployees" class="input" placeholder="Enter your idemployees"
          required>
        <button type="submit" name="submit" class="button">Login</button>
      </div>
    </div>
  </form>
</body>

</html>