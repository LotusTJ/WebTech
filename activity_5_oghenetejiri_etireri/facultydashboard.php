<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_user.php");
    exit();
}

$conn = getDBConnection();

$faculty_id = $_SESSION['user_id'];
$faculty_name = $_SESSION['user_name'];

/*    
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_request_id'])) {

    $approve_id = $_POST['approve_request_id'];

    $update_stmt = $conn->prepare("
        UPDATE enrollment e
        JOIN courses c ON e.course_id = c.course_ID
        SET e.status = 'approved'
        WHERE e.enrollment_id = ? AND c.FacultyID = ?
    ");

    $update_stmt->bind_param("ii", $approve_id, $faculty_id);

    if ($update_stmt->execute()) {
        $update_stmt->close();

        $insert_stmt = $conn->prepare("
            INSERT INTO enrollment_final (student_id, course_id)
            SELECT e.StudentID, e.course_id
            FROM enrollment e
            JOIN courses c ON e.course_id = c.course_ID
            WHERE e.enrollment_id = ? AND c.FacultyID = ?
        ");

        $insert_stmt->bind_param("ii", $approve_id, $faculty_id);
        $insert_stmt->execute();
        $insert_stmt->close();
    }
}

/* 
   GET faculty courses.
 */
$stmt = $conn->prepare("SELECT course_ID, courseName FROM courses WHERE FacultyID = ?");
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

/* 
   GET student enrollment requests
 */
$request_stmt = $conn->prepare("
    SELECT e.enrollment_id, e.course_id, c.courseName, s.StudentName
    FROM enrollment e
    JOIN courses c ON e.course_id = c.course_ID
    JOIN students s ON e.student_id= s.StudentID
    WHERE c.FacultyID = ?
");
$request_stmt->bind_param("i", $faculty_id);
$request_stmt->execute();
$result = $request_stmt->get_result();
$requests = $result->fetch_all(MYSQLI_ASSOC);
$request_stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Dashboard</title>

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

        .navbar ul li a:hover { opacity: 0.7; }

        .container {
            width: 80%;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 3px solid #003366;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1, h2 { color: #003366; }

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

        .approveBtn {
            padding: 6px 12px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .approveBtn:hover {
            background: darkgreen;
        }

        .status-pending { color: #ff9800; font-weight: bold; }
        .status-approved { color: #4caf50; font-weight: bold; }
    </style>
</head>

<body>

<div class="navbar">
    <a class="logo" href="#">Faculty Portal</a>
    <ul>
        <li><a href="faculty_dashboard.php">Dashboard</a></li>
        <li><a href="my_courses.php">Courses</a></li>
        <li><a href="add_course.php">Add Courses</a></li> 
    </ul>
</div>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($faculty_name); echo($faculty_id); ?> !</h1>

    <h2>Your Courses</h2>

    <?php if (!empty($courses)): ?>
        <table>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
            </tr>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['course_ID']); ?></td>
                    <td><?php echo htmlspecialchars($course['courseName']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>You have no assigned courses.</p>
    <?php endif; ?>

    <h2>Student Requests</h2>

    <?php if (!empty($requests)): ?>
        <table>
            <tr>
                <th>Student</th>
                <th>Course</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php foreach ($requests as $req): ?>
                <tr>
                    <td><?php echo htmlspecialchars($req['StudentName']); ?></td>
                    <td><?php echo htmlspecialchars($req['CourseName']); ?></td>
                    <td class="<?php echo $req['status'] === 'approved' ? 'status-approved' : 'status-pending'; ?>">
                        <?php echo ucfirst(htmlspecialchars($req['status'])); ?>
                    </td>
                    <td>
                        <?php if ($req['status'] !== 'approved'): ?>
                            <form method="POST" action="">
                                <input type="hidden" name="approve_request_id" value="<?php echo $req['enrollment_id']; ?>">
                                <button class="approveBtn">Approve</button>
                            </form>
                        <?php else: ?>
                            ✓
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php else: ?>
        <p>No student requests.</p>
    <?php endif; ?>

</div>

</body>
</html>
