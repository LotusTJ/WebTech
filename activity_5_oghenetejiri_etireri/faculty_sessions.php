<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_user.php");
    exit();
}

$conn = getDBConnection();

$faculty_id = $_SESSION['user_id'];
$faculty_name = $_SESSION['user_name'];

$stmt = $conn->prepare("SELECT course_id, CourseName FROM courses WHERE FacultyID = ?");
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$stmt = $conn->prepare("
SELECT s.session_id, s.course_id, s.course_name, s.session_date

FROM sessions s
JOIN courses c ON s.course_id = c.course_id
WHERE c.FacultyID = ?");

$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();
$sessions = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $course_id = $_POST['course_id'];
    $session_date = $_POST['session_date'];

    $conn = getDBConnection();
    $insert_stmt = $conn->prepare("INSERT INTO sessions (course_id, course_name, session_date) VALUES (?, (SELECT CourseName FROM courses WHERE course_id = ?), ?)");
    $insert_stmt->bind_param("iis", $course_id, $course_id, $session_date);
    $insert_stmt->execute();
    $insert_stmt->close();
    $conn->close();
    header("Location: faculty_sessions.php");
    exit();
}
?>

<!DOCTYPE html>     
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Dashboard - Sessions</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #f0f8ff;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background: #003366;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 20px 40px;
        }

        h1 {
            color: #003366;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <nav>
        <a href="facultydashboard.php">Dashboard</a>
        <a href="faculty_sessions.php">Sessions</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <h1>Faculty Sessions</h1>

        <?php if (empty($sessions)): ?>
            <p>No sessions available.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Session ID</th>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Session Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sessions as $session): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($session['session_id']); ?></td>
                            <td><?php echo htmlspecialchars($session['course_id']); ?></td>
                            <td><?php echo htmlspecialchars($session['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($session['session_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <h2> Add New Session </h2>
        <form method="POST" action="faculty_session.php">
            <label for="course_id">Course:</label>
            <select id="course_id" name="course_id" required>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo htmlspecialchars($course['course_id']); ?>">
                        <?php echo htmlspecialchars($course['CourseName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="session_date">Session Date:</label>
            <input type="date" id="session_date" name="session_date" required>

            <button type="submit">Add Session</button>
    </div>


