<?php
include '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $academic_year = $_POST['academic_year'];
    $semester      = $_POST['semester'];
    $subject_id    = $_POST['subject_id'];
    $experiment_id = $_POST['experiment_id'];

    foreach ($_POST['marks'] as $student_id => $marks) {

        $remarks = mysqli_real_escape_string($conn, $_POST['remarks'][$student_id]);

        $marks = (int)$marks;

        $sql = "INSERT INTO assessment
        (
            student_id,
            subject_id,
            experiment_id,
            academic_year,
            semester,
            marks_obtained,
            remarks
        )
        VALUES
        (
            '$student_id',
            '$subject_id',
            '$experiment_id',
            '$academic_year',
            '$semester',
            '$marks',
            '$remarks'
        )";

        if (!mysqli_query($conn, $sql)) {
            die("Insert Error: " . mysqli_error($conn));
        }
    }

    echo "<script>
        alert('Assessment Saved Successfully');
        window.location='view_assessment.php';
    </script>";
}
?>