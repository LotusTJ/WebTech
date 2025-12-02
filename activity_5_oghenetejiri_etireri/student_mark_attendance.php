<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_faculty.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['session_code']);
    
    $conn = getDBConnection();
    

    $stmt = $conn->prepare("
        SELECT s.session_id, s.course_id, c.courseName 
        FROM sessions s
        JOIN enrollment e ON s.course_id = e.course_id
        JOIN courses c ON s.course_id = c.courseID
        WHERE s.session_code = ? AND e.student_id = ?
    ");
    $stmt->bind_param("ii", $code, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $session = $result->fetch_assoc();
        $session_id = $session['session_id'];
        
      
        $insert_stmt = $conn->prepare("
            INSERT IGNORE INTO attendance (session_id, student_id, status) 
            VALUES (?, ?, 'Present')
        ");
        $insert_stmt->bind_param("ii", $session_id, $user_id);
        
        if ($insert_stmt->execute()) {
            if ($insert_stmt->affected_rows > 0) {
                $message = "Success! Attendance marked!";
            } else {
                $message = "Already marked!";
            }
        } else {
            $error = "Database error.";
        }
        $insert_stmt->close();
    } else {
        $error = "Invalid Session Code -You are may not be in this course.";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="student_dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <header><h1>Mark Attendance</h1></header>
        
        <?php if ($message): ?> <p style="color: green;"><?php echo $message; ?></p> <?php endif; ?>
        <?php if ($error): ?> <p style="color: red;"><?php echo $error; ?></p> <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="session_code">Enter Session Code:</label>
                <input type="number" name="session_code" id="session_code" required placeholder="e.g. 12345">
            </div>
            <button type="submit" class="btn">Submit Code</button>
        </form>
    </div>
</body>
</html>
