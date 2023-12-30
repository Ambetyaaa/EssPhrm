<?php
session_start();
include 'conndb.php';

// Default total leave allowance
$defaultTotalLeave = 15;

// Check if the employee ID is set in the session (assuming it's set during login)
if (isset($_SESSION["employeeId"])) {
    $employeeId = $_SESSION["employeeId"];

    // Fetch leave requests for the employee
    $sqlLeave = "SELECT * FROM employees_record WHERE idemployees = ?";
    $stmtLeave = $conn->prepare($sqlLeave);
    $stmtLeave->bind_param("i", $employeeId);
    $stmtLeave->execute();
    $resultLeave = $stmtLeave->get_result();

    $leaveRequests = array();
    while ($rowLeave = $resultLeave->fetch_assoc()) {
        $leaveRequests[] = array(
            'idemployees' => $employeeId,
            'reason' => $rowLeave["reason_of_leave"],
            'date' => $rowLeave["date_of_leave"]
        );
    }

    $stmtLeave->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Self-Service Portal</title>
    <link rel="stylesheet" href="styleHP.css">
</head>

<body>
    <h1>Employee Self-Service Portal</h1>
    <div> <button id="logout" class="button rightalign" onclick=logout()>LOG OUT</button></div>

    <table>
        <tr>
            <th>Idemployees</th>
            <th>Reason</th>
            <th>Date</th>
        </tr>
        <?php
        foreach ($leaveRequests as $request) {
            echo "<tr>";
            echo "<td>{$request['idemployees']}</td>";
            echo "<td>{$request['reason']}</td>";
            echo "<td>{$request['date']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <p>Total Leave:
        <?php echo $defaultTotalLeave; ?>
    </p>
    <p>Available Leave:
        <?php echo $defaultTotalLeave - count($leaveRequests); ?>
    </p>
    <button class="button" type="button" id="addLeaveButton" <?php echo (count($leaveRequests) >= $defaultTotalLeave) ? 'disabled' : ''; ?> onclick="addLeave()">Add Leave</button>

    <script>
        function addLeave() {
            window.location.href = 'addleave.php';
        }
        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>

</html>