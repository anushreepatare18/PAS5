<?php
include '../../config/database.php';

if (isset($_GET['id'])) {

    $assessment_id = (int) $_GET['id'];

    $sql = "DELETE FROM assessment
            WHERE assessment_id = '$assessment_id'";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Assessment Deleted Successfully');
                window.location='view_assessment.php';
              </script>";

    } else {

        echo "<script>
                alert('Delete Failed');
                window.location='view_assessment.php';
              </script>";
    }

} else {

    header("Location: view_assessment.php");
    exit;
}
?>