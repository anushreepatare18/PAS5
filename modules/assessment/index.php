<?php
include '../../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: view_assessment.php");
    exit;
}

$id = (int)$_GET['id'];

$sql = "SELECT
            a.*,
            s.roll_no,
            s.student_name,
            sub.subject_name,
            e.experiment_name
        FROM assessment a
        INNER JOIN students s
            ON a.student_id = s.student_id
        INNER JOIN subjects sub
            ON a.subject_id = sub.subject_id
        INNER JOIN experiments e
            ON a.experiment_id = e.experiment_id
        WHERE a.assessment_id = '$id'";

$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Assessment record not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Assessment</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-warning">

<h3>

<i class="bi bi-pencil-square"></i>

Edit Assessment

</h3>

</div>

<div class="card-body">

<form action="update_assessment.php" method="POST">

<input
type="hidden"
name="assessment_id"
value="<?= $data['assessment_id']; ?>">
<div class="mb-3">

    <label class="form-label">Roll No</label>

    <input
        type="text"
        class="form-control"
        value="<?= htmlspecialchars($data['roll_no']); ?>"
        readonly>

</div>

<div class="mb-3">

    <label class="form-label">Student Name</label>

    <input
        type="text"
        class="form-control"
        value="<?= htmlspecialchars($data['student_name']); ?>"
        readonly>

</div>

<div class="mb-3">

    <label class="form-label">Subject</label>

    <input
        type="text"
        class="form-control"
        value="<?= htmlspecialchars($data['subject_name']); ?>"
        readonly>

</div>

<div class="mb-3">

    <label class="form-label">Experiment</label>

    <input
        type="text"
        class="form-control"
        value="<?= htmlspecialchars($data['experiment_name']); ?>"
        readonly>

</div>

<div class="mb-3">

    <label class="form-label">Marks Obtained</label>

    <input
        type="number"
        name="marks_obtained"
        class="form-control"
        min="0"
        max="100"
        value="<?= $data['marks_obtained']; ?>"
        required>

</div>

<div class="mb-3">

    <label class="form-label">Remarks</label>

    <textarea
        name="remarks"
        class="form-control"
        rows="3"><?= htmlspecialchars($data['remarks']); ?></textarea>

</div>

<div class="text-end">

    <a href="view_assessment.php" class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>
        Back

    </a>

    <button type="submit" class="btn btn-primary">

        <i class="bi bi-save"></i>
        Update Assessment

    </button>

</div>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>