<!DOCTYPE html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPUS ACCESS SYSTEM</title>

    <link rel="stylesheet" href="style.css"> <!-- gotfromtheinternet -->

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(to bottom, rgba(115, 0, 0, 0.15) 0%, rgba(0, 0, 0, 0.15) 100%), radial-gradient(at top center, rgba(115, 0, 0, 0.40) 0%, rgba(0, 0, 0, 0.40) 120%) maroon;
            background-blend-mode: multiply,multiply;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 91.5vh;
        }

        .header-title {
            font-size: 36px; /* Bigger font size */
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }

        .navbar-nav .nav-link {
        font-size: 18px; /* Bigger font size */
        color: #fff; /* White font color */
        }

        .navbar-nav .nav-link:hover {
        color: #ddd; /* Lighter color on hover */
        }

        .navbar-nav {
        flex-direction: column; /* Align items vertically */
        text-align: center; /* Center text */
        }

        .attendance-container {
            height: 90%;
            width: 90%;
            border-radius: 20px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .attendance-container > div {
            box-shadow: rgba(0, 0, 0, 0.20) 0px 3px 8px;
            border-radius: 10px;
            padding: 30px;
        }

        .attendance-container > div:last-child {
            width: 64%;
            margin-left: auto;
        }
    </style>
</head>
<body>
<div class="header-title mt-4 mb-2">
        CAMPUS ACCESS SYSTEM
    </div>
<nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <!-- Toggler button for small screens -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="./main.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="./access.php">List of Enrolled Students</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item mr-3">
                <a class="nav-link" href="#"></a>
            </li>
        </ul>
    </div>
</nav>


    <div class="main">
        
        <div class="attendance-container row">
            <div class="qr-container col-4">
                <div class="scanner-left">
                    <h5 class="text-center">SCAN BAR CODE</h5>
                    <video id="interactive" class="viewport" width="100%">
                </div>

                <div class="qr-detected-container" style="display: none;">
                    <form action="./add-attendance.php" method="POST">
                        <h4 class="text-center">Student BAR Detected!</h4>
                        <input type="hidden" id="detected-qr-code" name="qr_code">
                        <button type="submit" class="btn btn-dark form-control">Submit Attendance</button>
                    </form>
                </div>
            </div>

            <div class="attendance-list">
                <h4>List of Present Students</h4>
                <div class="table-container table-responsive">
                    <table class="table text-center table-sm" id="attendanceTable">
                        <thead class="bg-info">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Year and Course</th>
                            <th scope="col">Accessed Time</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                                include ('./connect.php');

                                $stmt = $connect->prepare("SELECT * FROM campusaccess LEFT JOIN student ON student.student_id = campusaccess.student_id");
                                $stmt->execute();
                
                                $result = $stmt->fetchAll();
                
                                foreach ($result as $row) {
                                    $attendanceID = $row["campusaccess_id"];
                                    $studentName = $row["student_name"];
                                    $studentCourse = $row["yearandsection"];
                                    $timeIn = $row["timeofaccess"];
                                ?>

                                <tr>
                                    <th scope="row"><?= $attendanceID ?></th>
                                    <td><?= $studentName ?></td>
                                    <td><?= $studentCourse ?></td>
                                    <td><?= $timeIn ?></td>
                                    <td>
                                        <div class="action-button">
                                            <button class="btn btn-danger delete-button" onclick="deleteAttendance(<?= $attendanceID ?>)">X</button>
                                        </div>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        
        </div>

    </div>
    
    <!-- gotfromtheinternet -->
    <script src="style-slimjquery.js"></script>
    <script src="style-popper.js"></script>
    <script src="style-bootstrap.js"></script>                         
    <script src="InstaScanFile.js"></script>

    <script>
        
        let scanner;

        function startScanner() {
            scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

            scanner.addListener('scan', function (content) {
                $("#detected-qr-code").val(content);
                console.log(content);
                scanner.stop();
                document.querySelector(".qr-detected-container").style.display = '';
                document.querySelector(".scanner-right").style.display = 'none';
            });

            Instascan.Camera.getCameras()
                .then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error('No cameras found.');
                        alert('No cameras found.');
                    }
                })
                .catch(function (err) {
                    console.error('Camera access error:', err);
                    alert('Camera access error: ' + err);
                });
        }

        document.addEventListener('DOMContentLoaded', startScanner);

        function deleteAttendance(id) {
            if (confirm("Delete?")) {
                window.location = "./delete-attendance.php?attendance=" + id;
            }
        }
    </script>
</body>
</html>