<?php
include("./connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['student_name'], $_POST['yearandsection'])) {
        $studentName = $_POST['student_name'];
        $studentCourse = $_POST['yearandsection'];
        $generatedCode = $_POST['qrcode'];

        try {
            $stmt = $connect->prepare("INSERT INTO student (student_name, yearandsection, qrcode) VALUES (:student_name, :yearandsection, :qrcode)");
            
            $stmt->bindParam(":student_name", $studentName, PDO::PARAM_STR); 
            $stmt->bindParam(":yearandsection", $studentCourse, PDO::PARAM_STR);
            $stmt->bindParam(":qrcode", $generatedCode, PDO::PARAM_STR);

            $stmt->execute();

            header("Location: http://localhost/151-finalreq/access.php");

            exit();
        } catch (PDOException $e) {
            echo "Error:" . $e->getMessage();
        }

    } else {
        echo "
            <script>
                alert('Please fill in all fields!');
                window.location.href = 'http://localhost/151-finalreq/access.php';
            </script>
        ";
    }
}
?>
