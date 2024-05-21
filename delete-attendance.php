<?php
include ('./connect.php');

if (isset($_GET['attendance'])) {
    $attendance = $_GET['attendance'];

    try {

        $query = "DELETE FROM campusaccess WHERE campusaccess_id = '$attendance'";

        $stmt = $connect->prepare($query);

        $query_execute = $stmt->execute();

        if ($query_execute) {
            echo "
                <script>
                    alert('Attendance deleted successfully!');
                    window.location.href = 'http://localhost/151-finalreq/main.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Failed to delete attendance!');
                    window.location.href = 'http://localhost/151-finalreq/main.php';
                </script>
            ";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>