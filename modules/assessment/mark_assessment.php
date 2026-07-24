<?php
include '../../config/database.php';

// Fetch Students
$students = mysqli_query($conn, "SELECT * FROM students ORDER BY roll_no ASC");

// Fetch Subjects
$subjects = mysqli_query($conn, "SELECT * FROM subjects ORDER BY subject_name ASC");

// Fetch Experiments
$experiments = mysqli_query($conn, "SELECT * FROM experiments ORDER BY experiment_name ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mark Assessment</title>

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="../assets/css/assessment.css">

</head>

<body class="bg-light">
    <div class="container-fluid py-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3>
                <i class="bi bi-journal-check"></i>
                Mark Assessment
            </h3>

        </div>

        <div class="card-body">

            <form action="save_assessment.php" method="POST">

                <div class="row">

                    <!-- Academic Year -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">Academic Year</label>

                        <select class="form-select" name="academic_year" required>

                            <option value="">Select Academic Year</option>

                            <option value="2025-26">2025-26</option>

                            <option value="2026-27">2026-27</option>

                        </select>

                    </div>

                    <!-- Semester -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">Semester</label>

                        <select class="form-select" name="semester" required>

                            <option value="">Select Semester</option>

                            <option value="I">Semester I</option>
                            <option value="II">Semester II</option>
                            <option value="III">Semester III</option>
                            <option value="IV">Semester IV</option>
                            <option value="V">Semester V</option>
                            <option value="VI">Semester VI</option>

                        </select>

                    </div>

                    <!-- Subject -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">Subject</label>

                        <select class="form-select" name="subject_id" required>

                            <option value="">Select Subject</option>

                            <?php while($subject = mysqli_fetch_assoc($subjects)){ ?>

                                <option value="<?= $subject['subject_id']; ?>">

                                    <?= htmlspecialchars($subject['subject_name']); ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <!-- Experiment -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">Experiment</label>

                        <select class="form-select" name="experiment_id" required>

                            <option value="">Select Experiment</option>

                            <?php while($experiment = mysqli_fetch_assoc($experiments)){ ?>

                                <option value="<?= $experiment['experiment_id']; ?>">

                                    <?= htmlspecialchars($experiment['experiment_name']); ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>

                </div>

                <hr>

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th>#</th>

                            <th>Roll No</th>

                            <th>Student Name</th>

                            <th>Max Marks</th>

                            <th>Marks Obtained</th>

                            <th>Remarks</th>

                        </tr>

                    </thead>

                    <tbody>
                        <?php
$i = 1;

while ($student = mysqli_fetch_assoc($students)) {
?>

<tr>

    <td><?= $i++; ?></td>

    <td><?= htmlspecialchars($student['roll_no']); ?></td>

    <td><?= htmlspecialchars($student['student_name']); ?></td>

    <td>100</td>

    <td>

        <input
            type="number"
            class="form-control"
            name="marks[<?= $student['student_id']; ?>]"
            min="0"
            max="100"
            required>

    </td>

    <td>

        <input
            type="text"
            class="form-control"
            name="remarks[<?= $student['student_id']; ?>]"
            placeholder="Enter Remarks">

    </td>

</tr>

<?php
}
?>

</tbody>

</table>

<div class="text-end mt-3">

    <button type="reset" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise"></i> Reset
    </button>

    <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Save Assessment
    </button>

</div>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>