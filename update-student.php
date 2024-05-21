<?php
include("./connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['student_name'], $_POST['yearandsection'])) {
        $studentId = $_POST['student_id'];
        $studentName = $_POST['student_name'];
        $studentCourse = $_POST['yearandsection'];

        try {
            $stmt = $connect->prepare("UPDATE student SET student_name = :student_name, yearandsection = :yearandsection WHERE student_id = :student_id");
            
            $stmt->bindParam(":student_id", $studentId, PDO::PARAM_STR); 
            $stmt->bindParam(":student_name", $studentName, PDO::PARAM_STR); 
            $stmt->bindParam(":yearandsection", $studentCourse, PDO::PARAM_STR);

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
