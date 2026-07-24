<?php
// Student-facing page.
// Replace sample_data.php with your database query after the team finalizes table names.
// In the real application, get this from the authenticated session:
// $studentId = $_SESSION['student_id'];

$report = require __DIR__ . '/sample_data.php';
$student = $report['student'];
$experiments = $report['experiments'];

$cumulativeMarks = 0;
$presentCount = 0;
foreach ($experiments as &$experiment) {
    $experiment['total'] = $experiment['regularity'] + $experiment['conduction'] + $experiment['output'] + $experiment['viva'];
    $cumulativeMarks += $experiment['total'];
    if ($experiment['attendance'] === 'Present') {
        $presentCount++;
    }
}
unset($experiment);

$experimentCount = count($experiments);
$maximumCumulative = $experimentCount * 25;
$attendancePercentage = $experimentCount ? round(($presentCount / $experimentCount) * 100, 1) : 0;
$finalMarks = $experimentCount ? round($cumulativeMarks / $experimentCount, 2) : 0;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Assessment Report</title>
  <style>
    :root { --navy:#163d6b; --blue:#2563eb; --ink:#172033; --muted:#64748b; --line:#dce4ef; --surface:#ffffff; --background:#f5f8fc; }
    * { box-sizing:border-box; }
    body { margin:0; color:var(--ink); background:var(--background); font:15px/1.45 Arial, sans-serif; }
    .topbar { height:64px; display:flex; align-items:center; justify-content:space-between; padding:0 5.5%; background:var(--navy); color:#fff; }
    .brand { font-weight:bold; letter-spacing:.2px; }
    .profile { font-size:14px; opacity:.92; }
    main { max-width:1200px; margin:30px auto; padding:0 24px 45px; }
    .intro { display:flex; justify-content:space-between; align-items:end; gap:20px; margin-bottom:22px; }
    h1 { margin:0; font-size:28px; }
    .subtitle { margin:5px 0 0; color:var(--muted); }
    .badge { padding:7px 11px; border-radius:20px; background:#eaf1ff; color:#1d4ed8; font-weight:bold; white-space:nowrap; }
    .student-card, .report-card { background:var(--surface); border:1px solid var(--line); border-radius:12px; box-shadow:0 2px 10px #1720330b; }
    .student-card { display:grid; grid-template-columns:repeat(4, 1fr); margin-bottom:22px; overflow:hidden; }
    .detail { padding:17px 20px; border-right:1px solid var(--line); }
    .detail:last-child { border-right:0; }
    .label { display:block; color:var(--muted); font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:.4px; }
    .value { display:block; margin-top:4px; font-size:16px; font-weight:bold; }
    .report-card { padding:22px; }
    .section-title { margin:0 0 17px; font-size:19px; }
    .table-wrap { overflow-x:auto; }
    table { width:100%; min-width:900px; border-collapse:collapse; }
    th { padding:12px 10px; background:#eff5ff; color:#29405f; border-bottom:2px solid #c5d6ed; font-size:12px; text-transform:uppercase; letter-spacing:.3px; text-align:center; }
    td { padding:13px 10px; border-bottom:1px solid var(--line); text-align:center; }
    td:nth-child(2) { min-width:220px; text-align:left; font-weight:bold; }
    tr:last-child td { border-bottom:0; }
    .present { color:#137333; font-weight:bold; }
    .absent { color:#b42318; font-weight:bold; }
    .total { color:var(--blue); font-weight:bold; font-size:16px; }
    .summary { display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-top:24px; }
    .summary-item { padding:18px; border:1px solid var(--line); border-radius:9px; background:#fbfdff; }
    .summary-item strong { display:block; margin-top:5px; font-size:22px; color:var(--navy); }
    .note { margin:20px 0 0; color:var(--muted); font-size:13px; }
    @media (max-width:760px) { .student-card { grid-template-columns:repeat(2, 1fr); } .detail:nth-child(2) { border-right:0; } .detail { border-bottom:1px solid var(--line); } .summary { grid-template-columns:1fr; } .intro { align-items:start; flex-direction:column; } }
  </style>
</head>
<body>
  <header class="topbar"><span class="brand">Practical Assessment System</span><span class="profile">Student Portal</span></header>
  <main>
    <div class="intro">
      <div><h1>My Assessment Report</h1><p class="subtitle">Experiment-wise practical performance and final assessment.</p></div>
      <span class="badge">Academic Year <?= htmlspecialchars($student['academic_year']) ?></span>
    </div>

    <section class="student-card" aria-label="Student details">
      <div class="detail"><span class="label">Student Name</span><span class="value"><?= htmlspecialchars($student['name']) ?></span></div>
      <div class="detail"><span class="label">Roll Number</span><span class="value"><?= htmlspecialchars($student['roll_no']) ?></span></div>
      <div class="detail"><span class="label">Division</span><span class="value"><?= htmlspecialchars($student['division']) ?></span></div>
      <div class="detail"><span class="label">Subject</span><span class="value"><?= htmlspecialchars($student['subject']) ?></span></div>
    </section>

    <section class="report-card">
      <h2 class="section-title">Experiment-wise Assessment</h2>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Exp.</th><th>Experiment Title</th><th>Attendance</th><th>Regularity<br>/ 5</th><th>Practical Conduction<br>/ 10</th><th>Program Output<br>/ 5</th><th>Viva<br>/ 5</th><th>Total<br>/ 25</th></tr></thead>
          <tbody>
            <?php foreach ($experiments as $experiment): ?>
              <tr>
                <td><?= $experiment['number'] ?></td>
                <td><?= htmlspecialchars($experiment['title']) ?></td>
                <td class="<?= $experiment['attendance'] === 'Present' ? 'present' : 'absent' ?>"><?= htmlspecialchars($experiment['attendance']) ?></td>
                <td><?= $experiment['regularity'] ?></td><td><?= $experiment['conduction'] ?></td><td><?= $experiment['output'] ?></td><td><?= $experiment['viva'] ?></td><td class="total"><?= $experiment['total'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="summary">
        <div class="summary-item"><span class="label">Attendance Summary</span><strong><?= $presentCount ?>/<?= $experimentCount ?> (<?= $attendancePercentage ?>%)</strong></div>
        <div class="summary-item"><span class="label">Cumulative Marks</span><strong><?= $cumulativeMarks ?>/<?= $maximumCumulative ?></strong></div>
        <div class="summary-item"><span class="label">Final Practical Marks</span><strong><?= $finalMarks ?>/25</strong></div>
      </div>
      <p class="note">Final practical marks are calculated as the average score across completed experiments. Confirm the institute normalization rule before final integration.</p>
    </section>
  </main>
</body>
</html>