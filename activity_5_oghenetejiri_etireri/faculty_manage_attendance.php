<?php
require_once 'config.php';
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_faculty.php");
    exit();
}

$conn = getDBConnection();
$session_id = $_GET['session_id'] ?? null;
$message = '';

if (!$session_id) die("Session ID not provided.");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendance_data = $_POST['attendance'] ?? [];
    
    $stmt = $conn->prepare("
        INSERT INTO attendance (session_id, student_id, status) 
        VALUES (?, ?, ?) 
        ON DUPLICATE KEY UPDATE status = VALUES(status)
    ");
    
    foreach ($attendance_data as $student_id => $status) {
        $stmt->bind_param("iis", $session_id, $student_id, $status);
        $stmt->execute();
    }
    $message = "Attendance records updated successfully.";
    $stmt->close();
}


$stmt = $conn->prepare("
    SELECT s.session_date, s.session_code, c.courseName, c.course_ID
 
    FROM sessions s 
    JOIN courses c ON s.course_id = c.course_ID
 
    WHERE s.session_id = ?
");
$stmt->bind_param("i", $session_id);
$stmt->execute();
$session_info = $stmt->get_result()->fetch_assoc();
$stmt->close();


$query = "
    SELECT s.student_id, s.student_name, a.status 
    FROM enrollment e
    JOIN students s ON e.student_id = s.student_id
    LEFT JOIN attendance a ON e.student_id = a.student_id AND a.session_id = ?
    WHERE e.course_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $session_id, $session_info['course_id']);
$stmt->execute();
$students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Attendance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="faculty_sessions.php">Back to Sessions</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <header>
            <h1>Manage Attendance</h1>
            <h3><?php echo htmlspecialchars($session_info['course_name']); ?></h3>
            <p>Date: <?php echo htmlspecialchars($session_info['session_date']); ?> | Code: <?php echo htmlspecialchars($session_info['session_code']); ?></p>
        </header>
        
        <?php if ($message): ?> <p style="color: green;"><?php echo $message; ?></p> <?php endif; ?>

        <form method="POST">
            <table>
                <thead><tr><th>Student Name</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($students as $student): 
                        $status = $student['status'] ?? 'Absent';
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                        <td>
                            <select name="attendance[<?php echo $student['student_id']; ?>]">
                                <option value="Present" <?php echo ($status === 'Present') ? 'selected' : ''; ?>>Present</option>
                                <option value="Absent" <?php echo ($status === 'Absent') ? 'selected' : ''; ?>>Absent</option>
                            </select>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn" style="margin-top: 15px;">Save Changes</button>
        </form>
    </div>
</body>
</html>
