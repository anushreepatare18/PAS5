<?php
include '../../config/database.php';

$sql = "SELECT
            a.assessment_id,
            s.roll_no,
            s.student_name,
            sub.subject_name,
            e.experiment_name,
            a.academic_year,
            a.semester,
            a.marks_obtained,
            a.remarks,
            a.created_at
        FROM assessment a
        INNER JOIN students s
            ON a.student_id = s.student_id
        INNER JOIN subjects sub
            ON a.subject_id = sub.subject_id
        INNER JOIN experiments e
            ON a.experiment_id = e.experiment_id
        ORDER BY a.assessment_id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>View Assessment</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container-fluid py-4">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>
<i class="bi bi-table"></i>
View Assessment
</h3>

</div>

<div class="card-body">

<table class="table table-bordered table-striped table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Roll No</th>
<th>Student Name</th>
<th>Subject</th>
<th>Experiment</th>
<th>Marks</th>
<th>Remarks</th>
<th>Academic Year</th>
<th>Semester</th>
<th>Date</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['assessment_id']; ?></td>

<td><?= htmlspecialchars($row['roll_no']); ?></td>

<td><?= htmlspecialchars($row['student_name']); ?></td>

<td><?= htmlspecialchars($row['subject_name']); ?></td>

<td><?= htmlspecialchars($row['experiment_name']); ?></td>

<td>
<span class="badge bg-primary">
<?= $row['marks_obtained']; ?>/100
</span>
</td>

<td><?= htmlspecialchars($row['remarks']); ?></td>

<td><?= htmlspecialchars($row['academic_year']); ?></td>

<td><?= htmlspecialchars($row['semester']); ?></td>

<td><?= date("d-m-Y", strtotime($row['created_at'])); ?></td>

<td>
    <!-- Edit Button -->

<button
class="btn btn-warning btn-sm editBtn"

data-bs-toggle="modal"
data-bs-target="#editModal"

data-id="<?= $row['assessment_id']; ?>"
data-marks="<?= $row['marks_obtained']; ?>"
data-remarks="<?= htmlspecialchars($row['remarks']); ?>">

<i class="bi bi-pencil-square"></i>
Edit

</button>

<!-- Delete Button -->

<a href="delete_assessment.php?id=<?= $row['assessment_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this assessment?');">

<i class="bi bi-trash"></i>
Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>
<!-- ================= EDIT MODAL ================= -->

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="update_assessment.php" method="POST">

                <div class="modal-header bg-warning text-dark">

                    <h5 class="modal-title" id="editModalLabel">
                        <i class="bi bi-pencil-square"></i>
                        Edit Assessment
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <!-- Hidden ID -->
                    <input
                        type="hidden"
                        name="assessment_id"
                        id="assessment_id">

                    <!-- Marks -->
                    <div class="mb-3">

                        <label class="form-label">
                            Marks
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="marks"
                            name="marks"
                            min="0"
                            max="100"
                            required>

                    </div>

                    <!-- Remarks -->
                    <div class="mb-3">

                        <label class="form-label">
                            Remarks
                        </label>

                        <textarea
                            class="form-control"
                            id="remarks"
                            name="remarks"
                            rows="4"></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Close
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        Update
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

// Edit button click
document.querySelectorAll(".editBtn").forEach(function(button){

    button.addEventListener("click", function(){

        document.getElementById("assessment_id").value = this.dataset.id;

        document.getElementById("marks").value = this.dataset.marks;

        document.getElementById("remarks").value = this.dataset.remarks;

    });

});

</script>

</body>

</html>