<?php
include '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $assessment_id = mysqli_real_escape_string($conn, $_POST['assessment_id']);
    $marks = mysqli_real_escape_string($conn, $_POST['marks']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);

    // Validate Marks
    if ($marks < 0 || $marks > 100) {
        echo "<script>
                alert('Marks must be between 0 and 100');
                window.location='view_assessment.php';
              </script>";
        exit();
    }

    // Update Query
    $sql = "UPDATE assessment
            SET
                marks_obtained = '$marks',
                remarks = '$remarks'
            WHERE assessment_id = '$assessment_id'";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Assessment Updated Successfully');
                window.location='view_assessment.php';
              </script>";

    } else {

        echo "<script>
                alert('Error: " . mysqli_error($conn) . "');
                window.location='view_assessment.php';
              </script>";

    }

} else {

    header("Location: view_assessment.php");
    exit();

}
?>