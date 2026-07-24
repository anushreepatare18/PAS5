<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Assessment</title>

<style>

body{
    margin:0;
    background:#f4f6f9;
    font-family:Arial;
}

.container{
    width:90%;
    margin:auto;
    margin-top:70px;
}

h2{
    margin-bottom:40px;
}

.cards{
    display:flex;
    gap:40px;
}

.card{

    width:280px;
    height:180px;

    background:white;

    border-radius:10px;

    display:flex;

    justify-content:center;

    align-items:center;

    text-decoration:none;

    color:#333;

    font-size:25px;

    font-weight:bold;

    box-shadow:0 5px 15px rgba(0,0,0,.15);

    transition:.3s;

}

.card:hover{

    background:#28a745;

    color:white;

    transform:translateY(-5px);

}

</style>

</head>

<body>

<div class="container">

<h2>Assessment</h2>

<div class="cards">

<a href="view_assessment.php" class="card">
View Assessment
</a>

<a href="mark_assessment.php" class="card">
Mark Assessment
</a>

</div>

</div>

</body>
</html>