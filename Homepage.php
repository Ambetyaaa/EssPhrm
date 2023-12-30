<?php
session_start();
include 'conndb.php';

// Check if the form is submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteEmployee"])) {
    $employeeIdToDelete = $_POST["employeeIdToDelete"];

    // Perform the deletion logic
    $sql = "DELETE FROM employees WHERE idemployees = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employeeIdToDelete);

    if ($stmt->execute()) {
        echo "Employee with ID $employeeIdToDelete deleted successfully!";
    } else {
        echo "Error deleting employee: " . $stmt->error;
    }

    $stmt->close();
}

// Check if the employee ID is set in the session (assuming it's set during login)
if (isset($_SESSION["employeeId"])) {
    $employeeId = $_SESSION["employeeId"];

    // Fetch employee data based on the employee ID
    $sql = "SELECT * FROM employees WHERE idemployees = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if data is retrieved successfully
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $leaveRequests = $row["leave_requests"];
        $leaveAvailable = $row["leave_available"];
        $currentYear = date("Y");
    } else {
        echo "Error fetching employee data.";
    }

    $stmt->close();
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

    <table>
        <tr>
            <th>Idemployees</th>
            <th>Request Leave</th>
            <th>Number of Leave Available</th>
            <th>Year</th>
            <th>Action</th>
        </tr>
        <tr>
            <td>
                <?php echo $employeeId; ?>
            </td>
            <td>
                <?php echo $leaveRequests ?? ''; ?>
            </td>
            <td>
                <?php echo $leaveAvailable ?? ''; ?>
            </td>
            <td>
                <?php echo $currentYear ?? ''; ?>
            </td>
            <td>
                <button class="button" type="button" id="editButton" onclick="editLeave()">Edit</button>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="employeeIdToDelete" value="<?php echo $employeeId; ?>">
                    <button class="button" type="submit" name="deleteEmployee">Delete</button>
                </form>
                <button class="button" type="button" id="addButton" onclick="addDb()">Add.db</button>
            </td>
        </tr>
    </table>

    <button class="button" type="button" id="addLeaveButton" onclick="addLeave()">Add Leave</button>

    <script>
        function editLeave() {
            console.log('Edit button clicked');
        }

        function addDb() {
            console.log('Add button clicked');
        }

        function addLeave() {
            console.log('Add Leave button clicked');
        }
    </script>

</body>

</html>