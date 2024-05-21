<?php
include ('./connect.php');

if (isset($_GET['student'])) {
    $student = $_GET['student'];

    try {

        $query = "DELETE FROM student WHERE student_id = '$student'";

        $stmt = $connect->prepare($query);

        $query_execute = $stmt->execute();

        if ($query_execute) {
            echo "
                <script>
                    alert('Student deleted successfully!');
                    window.location.href = 'http://localhost/151-finalreq/access.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Failed to delete student!');
                    window.location.href = 'http://localhost/151-finalreq/access.php';
                </script>
            ";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>