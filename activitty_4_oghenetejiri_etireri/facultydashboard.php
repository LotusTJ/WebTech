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

        h1 {
            color: #003366;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
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
    </style>
</head>

<body>


<div class="navbar">
    <a class="logo" href="#">Faculty Portal</a>
    <ul>
        <li><a href="faculty_dashboard.php">Dashboard</a></li>
        <li><a href="my_courses.php">Courses</a></li>
        
       
    </ul>
</div>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($faculty_name); ?>!</h1>

    <h2>Your Courses</h2>

    <?php if (count($courses) > 0): ?>
        <table>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
            </tr>

            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['course_id']); ?></td>
                    <td><?php echo htmlspecialchars($course['CourseName']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php else: ?>
        <p>You have no assigned courses.</p>
    <?php endif; ?>
</div>

</body>
</html>
