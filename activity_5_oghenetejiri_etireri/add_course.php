<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_user.php");
    exit();
}

$conn = getDBConnection();
$faculty_id = $_SESSION['user_id'];
$faculty_name = $_SESSION['user_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name'] ?? '');

    if (!empty($course_name)) {
        $stmt = $conn->prepare("INSERT INTO courses (courseName, FacultyID) VALUES (?, ?)");
        echo $faculty_id;
        $stmt->bind_param("si", $course_name, $faculty_id);

        if ($stmt->execute()) {
            header("Location: facultydashboard.php");
            exit();
        } else {
            $error = "Error adding course. Please try again.";
        }

        $stmt->close();
    } else {
        $error = "Course name cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course</title>
    <style>
        body {
            background: #f0f8ff; 
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #003366; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #003366;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            margin-bottom: 5px;
        }

        input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"], button {
            margin-top: 20px;
            padding: 10px;
            background-color: #003366; 
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #0059b3; 
        }

        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Course</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="add_course.php">
            <label for="course_name">Course Name:</label>
            <input type="text" id="course_name" name="course_name" required>

            <button type="submit">Add Course</button>
        </form>
    </div>
</body>
</html>
