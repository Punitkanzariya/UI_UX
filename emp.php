<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $position = $_POST['position'];
        
        $sql = "INSERT INTO employees (name, email, phone, position) VALUES ('$name', '$email', '$phone', '$position')";
        $conn->query($sql);
    }
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM employees WHERE id=$id";
        $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Employee Registration</h2>
        <form id="employeeForm" method="POST" action="">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Position</label>
                <input type="text" name="position" class="form-control" required>
            </div>
            <button type="submit" name="create" class="btn btn-primary">Register</button>
        </form>
        
        <h3 class="mt-5">Employee List</h3>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Position</th>
                <th>Action</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM employees");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['position']}</td>
                        <td>
                            <form method='POST' action='' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                            </form>
                        </td>
                    </tr>";
            }
            ?>
        </table>
    </div>
    
    <script>
        $(document).ready(function () {
            $('#employeeForm').on('submit', function (e) {
                let isValid = true;
                $('input').each(function () {
                    if ($(this).val().trim() === '') {
                        isValid = false;
                        alert('All fields are required');
                        return false;
                    }
                });
                if (!isValid) e.preventDefault();
            });
        });
    </script>
</body>
</html>