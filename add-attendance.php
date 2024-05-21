<?php
include("./connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['qr_code'])) {
        $qrCode = $_POST['qr_code'];

        $selectStmt = $connect->prepare("SELECT student_id FROM student WHERE qrcode = :qrcode");
        $selectStmt->bindParam(":qrcode", $qrCode, PDO::PARAM_STR);

        if ($selectStmt->execute()) {
            $result = $selectStmt->fetch();
            if ($result !== false) {
                $studentID = $result["student_id"];
                $timeIn =  date("Y-m-d H:i:s");
            } else {
                echo "No student found in QR Code";
            }
        } else {
            echo "Failed to execute the statement.";
        }


        try {
            $stmt = $connect->prepare("INSERT INTO campusaccess (student_id, timeofaccess) VALUES (:student_id, :timeofaccess)");
            
            $stmt->bindParam(":student_id", $studentID, PDO::PARAM_STR); 
            $stmt->bindParam(":timeofaccess", $timeIn, PDO::PARAM_STR); 

            $stmt->execute();

            header("Location: http://localhost/151-finalreq/main.php");

            exit();
        } catch (PDOException $e) {
            echo "Error:" . $e->getMessage();
        }

    } else {
        echo "
            <script>
                alert('Please fill in all fields!');
                window.location.href = 'http://localhost/151-finalreq/main.php';
            </script>
        ";
    }
}
?>
