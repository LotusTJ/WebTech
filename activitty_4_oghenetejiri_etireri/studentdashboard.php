<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_student.php");
    exit();
}

$conn = getDBConnection();
$student_id = $_SESSION['user_id'];
$student_name = $_SESSION['user_name'];

$stmt = $conn->prepare("
    SELECT courses.course_id, courses.CourseName, faculty.FacultyName 
    FROM courses
    JOIN enrollments ON courses.course_id = enrollments.course_id
    JOIN faculty ON courses.FacultyID = faculty.FacultyID
    WHERE enrollments.StudentID = ? AND enrollments.status = 'approved'
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$enrolled_courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$stmt = $conn->prepare("
    SELECT courses.course_id, courses.CourseName, faculty.FacultyName, enrollments.request_date, enrollments.status
    FROM courses
    JOIN enrollments ON courses.course_id = enrollments.course_id
    JOIN faculty ON courses.FacultyID = faculty.FacultyID
    WHERE enrollments.StudentID = ? AND enrollments.status = 'pending'
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$pending_requests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <style>
        body {
            background: #d9ecff;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #003366;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            color: white;
            font-size: 22px;
            font-weight: bold;
            text-decoration: none;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 25px;
            margin: 0;
            padding: 0;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: opacity 0.3s;
        }

        .navbar ul li a:hover {
            opacity: 0.7;
        }

        .container {
            width: 80%;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 3px solid #003366;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1, h2 {
            color: #003366;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 30px;
        }

        th, td {
            border: 2px solid #003366;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #cbe2ff;
            color: #003366;
        }

        td {
            background: #f5f9ff;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #003366;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #0059b3;
        }

        .status-pending {
            color: #ff9800;
            font-weight: bold;
        }

        .status-approved {
            color: #4caf50;
            font-weight: bold;
        }

        .status-rejected {
            color: #f44336;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a class="logo" href="#">Student Portal</a>
    <ul>
        <li><a href="studentdashboard.php">Dashboard</a></li>
               
    </ul>
</div>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($student_name); ?>!</h1>

    <h2>My Enrolled Courses</h2>
    <?php if (count($enrolled_courses) > 0): ?>
        <table>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Faculty</th>
            </tr>
            <?php foreach ($enrolled_courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['course_id']); ?></td>
                    <td><?php echo htmlspecialchars($course['CourseName']); ?></td>
                    <td><?php echo htmlspecialchars($course['FacultyName']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>You are not enrolled in any courses yet.</p>
    <?php endif; ?>

    <h2>Pending Enrollment Requests</h2>
    <?php if (count($pending_requests) > 0): ?>
        <table>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Faculty</th>
                <th>Request Date</th>
                <th>Status</th>
            </tr>
            <?php foreach ($pending_requests as $request): ?>
                <tr>
                    <td><?php echo htmlspecialchars($request['course_id']); ?></td>
                    <td><?php echo htmlspecialchars($request['CourseName']); ?></td>
                    <td><?php echo htmlspecialchars($request['FacultyName']); ?></td>
                    
                    <td class="status-pending"><?php echo ucfirst(htmlspecialchars($request['status'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>You have no pending enrollment requests.</p>
    <?php endif; ?>

    <a href="browse_courses.php" class="btn">Browse Available Courses</a>
</div>

</body>
</html>