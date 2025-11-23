-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2025 at 06:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dash_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendanceId` int(11) NOT NULL,
  `enrollmentId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `attendanceDate` date NOT NULL,
  `status` enum('Present','Absent','Late','Excused') DEFAULT 'Absent',
  `remarks` text DEFAULT NULL,
  `recordedBy` int(11) DEFAULT NULL,
  `recordedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseId` int(11) NOT NULL,
  `courseName` varchar(100) NOT NULL,
  `courseCode` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `instructorName` varchar(100) DEFAULT NULL,
  `totalHours` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseId`, `courseName`, `courseCode`, `description`, `instructorName`, `totalHours`, `created_date`) VALUES
(1, 'Web Development Fundamentals', 'CS101', 'Learn HTML, CSS, JavaScript and modern web development practices. Build responsive websites from scratch.', 'Dr. Sarah Johnson', 120, '2025-10-08 12:05:19'),
(2, 'Database Management Systems', 'CS201', 'Comprehensive course on SQL, database design, normalization, and relational database concepts.', 'Prof. Michael Chen', 90, '2025-10-08 12:05:19'),
(3, 'Mobile App Development', 'CS301', 'Build native and cross-platform mobile applications using React Native and modern frameworks.', 'Dr. Emily Brown', 100, '2025-10-08 12:05:19'),
(4, 'Cloud Computing & AWS', 'CS401', 'Learn cloud infrastructure, deployment, scaling, and AWS services for modern applications.', 'Prof. David Wilson', 80, '2025-10-08 12:05:19'),
(5, 'Data Structures & Algorithms', 'CS202', 'Master fundamental data structures and algorithms essential for software engineering interviews.', 'Dr. Robert Lee', 110, '2025-10-08 12:05:19'),
(6, 'Python Programming', 'CS102', 'Introduction to Python programming, covering basics to advanced topics including OOP and libraries.', 'Prof. Amanda White', 75, '2025-10-08 12:05:19'),
(7, 'Cybersecurity Essentials', 'CS501', 'Learn about network security, cryptography, ethical hacking, and security best practices.', 'Dr. Kevin Park', 95, '2025-10-08 12:05:19'),
(8, 'Machine Learning Basics', 'CS601', 'Introduction to ML algorithms, neural networks, and practical applications using Python.', 'Prof. Lisa Garcia', 130, '2025-10-08 12:05:19'),
(9, 'Human-Computer Interaction', 'CS320', 'User-centered design, usability testing, and interface design principles.', 'Dr. Maria Garcia', 42, '2025-10-10 12:55:35'),
(10, 'Cloud Computing', 'CS480', 'Cloud architecture, virtualization, and deployment strategies using AWS and Azure.', 'Prof. Robert Martinez', 52, '2025-10-10 12:55:35'),
(11, 'Data Science Fundamentals', 'DS101', 'Introduction to data analysis, visualization, and statistical methods.', 'Dr. Sarah Chen', 45, '2025-10-10 12:55:35'),
(12, 'Mobile UI/UX Design', 'DES305', 'Design principles for mobile applications and user experience optimization.', 'Prof. Lisa Wong', 40, '2025-10-10 12:55:35'),
(13, 'Blockchain Technology', 'CS470', 'Fundamentals of blockchain, smart contracts, and decentralized applications.', 'Dr. Michael Bitcoin', 50, '2025-10-10 12:55:35'),
(14, 'Machine Learning', 'CS455', 'Advanced machine learning algorithms and practical applications.', 'Prof. Anna Neural', 65, '2025-10-10 12:55:35'),
(15, 'Web Security', 'CS425', 'Web application security, penetration testing, and secure coding practices.', 'Dr. Security Expert', 48, '2025-10-10 12:55:35'),
(39, 'Introduction to Computer Science', 'CS301_1', 'Fundamental concepts of computer science, algorithms, and programming basics using Python.', 'Dr. Kwame Mensah', 45, '2025-10-10 12:27:47'),
(40, 'Database Management Systems', 'CS902_1', 'Comprehensive study of database design, SQL, normalization, and database administration.', 'Prof. Ama Serwah', 60, '2025-10-10 12:27:47'),
(41, 'Web Development', 'CS305_4', 'Modern web development including HTML5, CSS3, JavaScript, and responsive design principles.', 'Dr. Sarah Johnson', 55, '2025-10-10 12:27:47'),
(42, 'Mobile Application Development', 'CS410_5', 'Building mobile applications for iOS and Android using React Native and Flutter.', 'Prof. Michael Chen', 50, '2025-10-10 12:27:47'),
(43, 'Data Structures and Algorithms', 'CS201_8', 'Advanced data structures, algorithm analysis, and complexity theory.', 'Dr. Emily Brown', 65, '2025-10-10 12:27:47'),
(44, 'Software Engineering', 'CS301_3', 'Software development lifecycle, agile methodologies, and project management.', 'Prof. James Wilson', 55, '2025-10-10 12:27:47'),
(45, 'Network Security', 'CS415_6', 'Principles of network security, cryptography, and secure system design.', 'Dr. Lisa Taylor', 48, '2025-10-10 12:27:47'),
(46, 'Artificial Intelligence', 'CS450_1', 'Introduction to AI, machine learning, and intelligent systems.', 'Prof. David Anderson', 60, '2025-10-10 12:27:47'),
(47, 'Human-Computer Interaction', 'CS320_6', 'User-centered design, usability testing, and interface design principles.', 'Dr. Maria Garcia', 42, '2025-10-10 12:27:47'),
(48, 'Cloud Computing', 'CS480_8', 'Cloud architecture, virtualization, and deployment strategies using AWS and Azure.', 'Prof. Robert Martinez', 52, '2025-10-10 12:27:47'),
(49, 'Realman', 'RE344', 'A course for realmen', 'Dane Whackfield', 45, '2025-10-10 21:53:03'),
(51, 'Gutter', 'GU344', 'Gutterboi', 'Regenald ofoe', 45, '2025-10-11 02:12:16');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `enrollmentId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `enrollment_date` datetime DEFAULT current_timestamp(),
  `progress_percentage` int(11) DEFAULT 0,
  `status` enum('Enrolled','completed','dropped') DEFAULT 'Enrolled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`enrollmentId`, `userId`, `courseId`, `enrollment_date`, `progress_percentage`, `status`) VALUES
(1, 1, 1, '2025-10-08 12:05:19', 75, 'Enrolled'),
(2, 1, 2, '2025-10-08 12:05:19', 60, 'Enrolled'),
(3, 1, 3, '2025-10-08 12:05:19', 45, 'Enrolled'),
(4, 1, 5, '2025-10-08 12:05:19', 30, 'Enrolled'),
(5, 2, 1, '2025-10-08 12:05:19', 100, 'completed'),
(6, 2, 4, '2025-10-08 12:05:19', 85, 'Enrolled'),
(7, 2, 6, '2025-10-08 12:05:19', 90, 'Enrolled'),
(8, 2, 8, '2025-10-08 12:05:19', 40, 'Enrolled'),
(9, 3, 2, '2025-10-08 12:05:19', 55, 'Enrolled'),
(10, 3, 5, '2025-10-08 12:05:19', 70, 'Enrolled'),
(11, 3, 7, '2025-10-08 12:05:19', 20, 'Enrolled'),
(12, 4, 3, '2025-10-08 12:05:19', 95, 'Enrolled'),
(13, 4, 6, '2025-10-08 12:05:19', 100, 'completed'),
(14, 4, 8, '2025-10-08 12:05:19', 65, 'Enrolled'),
(15, 5, 1, '2025-10-08 12:05:19', 50, 'Enrolled'),
(16, 5, 2, '2025-10-08 12:05:19', 45, 'Enrolled'),
(17, 5, 4, '2025-10-08 12:05:19', 80, 'Enrolled'),
(18, 5, 7, '2025-10-08 12:05:19', 35, 'Enrolled'),
(19, 6, 5, '2025-10-08 12:05:19', 88, 'Enrolled'),
(20, 6, 6, '2025-10-08 12:05:19', 92, 'Enrolled'),
(21, 6, 8, '2025-10-08 12:05:19', 75, 'Enrolled'),
(22, 7, 1, '2025-10-08 12:05:19', 15, 'Enrolled'),
(23, 7, 3, '2025-10-08 12:05:19', 25, 'Enrolled'),
(24, 7, 4, '2025-10-08 12:05:19', 10, 'dropped'),
(25, 8, 2, '2025-10-08 12:05:19', 78, 'Enrolled'),
(26, 8, 5, '2025-10-08 12:05:19', 100, 'completed'),
(27, 8, 7, '2025-10-08 12:05:19', 60, 'Enrolled'),
(28, 9, 1, '2025-10-10 12:55:35', 95, 'Enrolled'),
(29, 9, 2, '2025-10-10 12:55:35', 88, 'Enrolled'),
(30, 9, 3, '2025-10-10 12:55:35', 92, 'Enrolled'),
(31, 9, 4, '2025-10-10 12:55:35', 75, 'Enrolled'),
(32, 9, 6, '2025-10-10 12:55:35', 85, 'Enrolled'),
(33, 9, 8, '2025-10-10 12:55:35', 90, 'Enrolled'),
(34, 9, 10, '2025-10-10 12:55:35', 70, 'Enrolled'),
(35, 9, 11, '2025-10-10 12:55:35', 80, 'Enrolled'),
(36, 9, 13, '2025-10-10 12:55:35', 65, 'Enrolled'),
(37, 9, 14, '2025-10-10 12:55:35', 55, 'Enrolled'),
(38, 9, 49, '2025-10-10 21:53:03', 0, 'Enrolled'),
(39, 2, 12, '2025-10-11 02:03:26', 0, 'Enrolled'),
(40, 14, 51, '2025-10-11 02:12:16', 0, 'Enrolled');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `sessionId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `sessionTitle` varchar(100) NOT NULL,
  `sessionDate` date NOT NULL,
  `sessionTime` time NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`sessionId`, `courseId`, `sessionTitle`, `sessionDate`, `sessionTime`, `duration`, `location`) VALUES
(1, 1, 'Frontend Frameworks - React Basics', '2025-10-10', '10:00:00', 120, 'Room A101'),
(2, 1, 'Advanced CSS & Animations', '2025-10-15', '14:00:00', 90, 'Room A101'),
(3, 1, 'JavaScript ES6+ Features', '2025-10-20', '10:00:00', 120, 'Room A101'),
(4, 1, 'Building REST APIs', '2025-10-25', '10:00:00', 150, 'Lab B202'),
(5, 1, 'Project Presentation & Review', '2025-10-30', '13:00:00', 180, 'Auditorium'),
(6, 2, 'SQL Advanced Queries & Joins', '2025-10-12', '14:00:00', 120, 'Room C301'),
(7, 2, 'Database Normalization Workshop', '2025-10-17', '10:00:00', 90, 'Room C301'),
(8, 2, 'Transactions & ACID Properties', '2025-10-22', '14:00:00', 120, 'Room C301'),
(9, 2, 'Stored Procedures & Triggers', '2025-10-27', '10:00:00', 120, 'Lab B202'),
(10, 3, 'React Native Navigation', '2025-10-15', '11:00:00', 120, 'Room D401'),
(11, 3, 'State Management with Redux', '2025-10-18', '11:00:00', 90, 'Room D401'),
(12, 3, 'API Integration & Data Fetching', '2025-10-23', '11:00:00', 120, 'Lab B202'),
(13, 3, 'Publishing to App Stores', '2025-10-28', '14:00:00', 90, 'Room D401'),
(14, 4, 'AWS EC2 & Deployment Basics', '2025-10-11', '15:00:00', 120, 'Room E501'),
(15, 4, 'Docker Containers & Kubernetes', '2025-10-16', '15:00:00', 150, 'Lab B202'),
(16, 4, 'AWS Lambda & Serverless', '2025-10-21', '15:00:00', 120, 'Room E501'),
(17, 4, 'Cloud Security Best Practices', '2025-10-26', '15:00:00', 90, 'Room E501'),
(18, 5, 'Trees & Graph Algorithms', '2025-10-13', '09:00:00', 120, 'Room F601'),
(19, 5, 'Dynamic Programming Problems', '2025-10-18', '09:00:00', 150, 'Room F601'),
(20, 5, 'Hash Tables & Implementation', '2025-10-24', '09:00:00', 120, 'Room F601'),
(21, 5, 'Coding Interview Practice', '2025-10-29', '09:00:00', 180, 'Lab B202'),
(22, 6, 'Object-Oriented Programming', '2025-10-14', '13:00:00', 90, 'Room G701'),
(23, 6, 'File Handling & Exceptions', '2025-10-19', '13:00:00', 90, 'Room G701'),
(24, 6, 'Libraries: NumPy & Pandas', '2025-10-24', '13:00:00', 120, 'Lab B202'),
(25, 6, 'Final Project Workshop', '2025-10-29', '13:00:00', 150, 'Lab B202'),
(26, 7, 'Network Security Fundamentals', '2025-10-16', '16:00:00', 120, 'Room H801'),
(27, 7, 'Cryptography & Encryption', '2025-10-21', '16:00:00', 120, 'Room H801'),
(28, 7, 'Penetration Testing Lab', '2025-10-26', '16:00:00', 180, 'Lab B202'),
(29, 7, 'Security Audit & Compliance', '2025-10-31', '16:00:00', 90, 'Room H801'),
(30, 8, 'Supervised Learning Algorithms', '2025-10-17', '10:30:00', 150, 'Room I901'),
(31, 8, 'Neural Networks Deep Dive', '2025-10-22', '10:30:00', 150, 'Room I901'),
(32, 8, 'Model Training & Optimization', '2025-10-27', '10:30:00', 120, 'Lab B202'),
(33, 8, 'Real-world ML Project', '2025-11-01', '10:30:00', 180, 'Lab B202'),
(34, 1, 'Python Programming Workshop', '2025-10-20', '09:00:00', 120, 'CS Lab A'),
(35, 1, 'Algorithm Design', '2025-10-25', '09:00:00', 120, 'CS Lab A'),
(36, 2, 'Advanced SQL Queries', '2025-10-21', '14:00:00', 120, 'Database Lab'),
(37, 2, 'Database Optimization', '2025-10-26', '14:00:00', 120, 'Database Lab'),
(38, 3, 'React.js Fundamentals', '2025-10-22', '11:00:00', 120, 'Web Dev Studio'),
(39, 3, 'API Integration', '2025-10-27', '11:00:00', 120, 'Web Dev Studio'),
(40, 6, 'Agile Methodology', '2025-10-23', '13:00:00', 120, 'Project Room 101'),
(41, 6, 'Software Testing', '2025-10-28', '13:00:00', 120, 'Project Room 101'),
(42, 8, 'Neural Networks Intro', '2025-10-24', '15:00:00', 120, 'AI Research Lab'),
(43, 8, 'Machine Learning Models', '2025-10-29', '15:00:00', 120, 'AI Research Lab'),
(44, 10, 'AWS Services Overview', '2025-10-25', '16:00:00', 120, 'Cloud Computing Center'),
(45, 10, 'Azure Deployment', '2025-10-30', '16:00:00', 120, 'Cloud Computing Center'),
(46, 11, 'Data Visualization', '2025-10-26', '10:00:00', 120, 'Data Science Lab'),
(47, 11, 'Statistical Analysis', '2025-10-31', '10:00:00', 120, 'Data Science Lab'),
(48, 13, 'Smart Contracts', '2025-10-27', '14:00:00', 120, 'Blockchain Lab'),
(49, 13, 'Decentralized Apps', '2025-11-01', '14:00:00', 120, 'Blockchain Lab'),
(50, 14, 'Deep Learning', '2025-10-28', '16:00:00', 120, 'ML Research Center'),
(51, 14, 'Model Training', '2025-11-02', '16:00:00', 120, 'ML Research Center');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `role` enum('student','faculty') DEFAULT 'student',
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `date_registered` datetime DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `firstName`, `lastName`, `role`, `email`, `password_hash`, `date_registered`, `profile_picture`) VALUES
(1, 'John', 'Doe', 'student', 'john.doe@student.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-10-08 12:05:19', 'john.jpg'),
(2, 'Jane', 'Smith', 'student', 'jane.smith@student.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-10-08 12:05:19', 'jane.jpg'),
(3, 'Michael', 'Johnson', 'student', 'michael.j@student.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-10-08 12:05:19', 'michael.jpg'),
(4, 'Emily', 'Brown', 'student', 'emily.brown@student.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-10-08 12:05:19', 'emily.jpg'),
(5, 'David', 'Wilson', 'student', 'david.w@student.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-10-08 12:05:19', 'david.jpg'),
(6, 'Sarah', 'Martinez', 'student', 'sarah.m@student.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-10-08 12:05:19', 'sarah.jpg'),
(7, 'James', 'Anderson', 'student', 'james.a@student.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-10-08 12:05:19', 'james.jpg'),
(8, 'Lisa', 'Taylor', 'student', 'lisa.t@student.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-10-08 12:05:19', 'lisa.jpg'),
(9, 'David', 'Orhin', 'student', 'david.orhin@ashesi.edu.gh', '$2y$10$rVwAn1LQtMUO9aSxev9xxulKeV/cqT.CMn.wgwnqmc9MUY8FdlSHG', '2025-10-08 13:18:52', NULL),
(10, 'Adebayo', 'Bello', 'student', 'adebayo.bello@ashesi.edu.gh', '$2y$10$Oh8G1LbMhEq6ZwAWEpqNe.NqqobTPzMs0.yFTSOaSpXTtaQFh9mSG', '2025-10-09 19:07:30', NULL),
(11, 'regus', 'emma', 'student', 'regusemma@gmail.com', '$2y$10$Ub4r7X0vw2WDltkzWMuzjOBQwvXEhze5oibU/6zO1NceEMbHKOurO', '2025-10-10 13:00:46', NULL),
(12, 'Mandy', 'free', 'faculty', 'johoe@student.edu', '$2y$10$gs1.EB8DeUgqiYb.kP5aS.4lYFMpoAXvFVJaUxQY99/uKHuMafIQK', '2025-10-10 21:39:05', NULL),
(13, 'Mitch', 'ball', 'faculty', 'Mitchball@gmail.com', '$2y$10$QsP3lBel9gdJcRb4sjoVcuCGNvb0bTs8Lwdzm0ImxNR11x1mWvqmG', '2025-10-10 22:11:13', NULL),
(14, 'Frank', 'Lee', 'faculty', 'FL@intern.com', '$2y$10$.yKk4kayiCLrqHhQDRZIQuNATgv9u1.PqfX0aZqr2MTgcXKoI5eGK', '2025-10-11 01:52:22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendanceId`),
  ADD UNIQUE KEY `unique_attendance` (`sessionId`,`userId`),
  ADD KEY `enrollmentId` (`enrollmentId`),
  ADD KEY `recordedBy` (`recordedBy`),
  ADD KEY `idx_attendance_user` (`userId`),
  ADD KEY `idx_attendance_session` (`sessionId`),
  ADD KEY `idx_attendance_course` (`courseId`),
  ADD KEY `idx_attendance_date` (`attendanceDate`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseId`),
  ADD UNIQUE KEY `courseCode` (`courseCode`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`enrollmentId`),
  ADD UNIQUE KEY `userId` (`userId`,`courseId`),
  ADD KEY `courseId` (`courseId`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sessionId`),
  ADD KEY `courseId` (`courseId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendanceId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `enrollmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `sessionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`enrollmentId`) REFERENCES `enrollment` (`enrollmentId`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`courseId`) REFERENCES `courses` (`courseId`),
  ADD CONSTRAINT `attendance_ibfk_4` FOREIGN KEY (`sessionId`) REFERENCES `sessions` (`sessionId`),
  ADD CONSTRAINT `attendance_ibfk_5` FOREIGN KEY (`recordedBy`) REFERENCES `users` (`userId`);

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`courseId`) REFERENCES `courses` (`courseId`);

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `courses` (`courseId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
