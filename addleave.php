<?php
session_start();
include 'conndb.php';


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitLeave"])) {
    // Validate and sanitize the user input (you may add more validation)
    $reason = mysqli_real_escape_string($conn, $_POST["reason"]);
    $date = $_POST["date"]; // Assuming you have a date input in your form

    // Insert the leave record into the database
    $sqlInsertLeave = "INSERT INTO employees_record (idemployees, reason_of_leave, date_of_leave) VALUES (?, ?, ?)";
    $stmtInsertLeave = $conn->prepare($sqlInsertLeave);
    $stmtInsertLeave->bind_param("iss", $_SESSION["employeeId"], $reason, $date);

    if ($stmtInsertLeave->execute()) {
        echo "Leave added successfully!";
        // Redirect back to the page where users view their leave records
        header("Location: Homepage.php");
        exit();
    } else {
        echo "Error adding leave: " . $stmtInsertLeave->error;
    }

    $stmtInsertLeave->close();
}

$conn->close();
?>
<!-- Your HTML form for adding leave -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Leave</title>
    <link rel="stylesheet" href="addleave.css">
</head>

<body>
    <h1>Add Leave</h1>
    <form method="post" action="">
        <label for="reason">Reason for Leave:</label>
        <input type="text" id="reason" name="reason" required>

        <label for="date">Date of Leave:</label>
        <!-- Change the date format to yyyy-mm-dd -->
        <input type="date" id="date" name="date" pattern="\d{4}-\d{2}-\d{2}" required>

        <button type="submit" name="submitLeave">Submit Leave</button>
    </form>
</body>

</html>