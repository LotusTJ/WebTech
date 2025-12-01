<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_student.php");
    exit();
}

$conn = getDBConnection();
$student_id = $_SESSION['user_id'];
$student_name = $_SESSION['user_name'];

/*enrolled Courses*/
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

/*pending Requests*/
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
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #d9ecff;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background: #003366;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-size: 16px;
        }

        .container {
            width: 85%;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 3px solid #003366;
        }

        h1, h2 {
            color: #003366;
        }

        ul {
            background: #f5f9ff;
            border: 2px solid #003366;
            padding: 15px;
            border-radius: 10px;
            list-style: none;
        }

        ul li {
            padding: 10px 5px;
            border-bottom: 1px solid #aac7e3;
        }

        ul li:last-child {
            border-bottom: none;
        }

        .status {
            font-weight: bold;
        }

        .pending {
            color: #ff9800;
        }

        .approved {
            color: #4caf50;
        }
    </style>
</head>
<body>

<nav>
    <a href="studentdashboard.php">Dashboard</a>
    <a href="browse_courses.php">Browse Courses</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($student_name); ?>!</h1>

    
    <section>
        <h2>My Enrolled Courses</h2>
        <?php if (empty($enrolled_courses)): ?>
            <p>You are not enrolled in any courses yet.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($enrolled_courses as $course): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($course['CourseName']); ?></strong>
                        — Faculty: <?php echo htmlspecialchars($course['FacultyName']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    
    <section style="margin-top: 30px;">
        <h2>Pending Enrollment Requests</h2>
        <?php if (empty($pending_requests)): ?>
            <p>You have no pending enrollment requests.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($pending_requests as $req): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($req['CourseName']); ?></strong>
                        — Faculty: <?php echo htmlspecialchars($req['FacultyName']); ?>
                        — Status:
                        <span class="status pending"><?php echo ucfirst($req['status']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

</div>

</body>
</html>
