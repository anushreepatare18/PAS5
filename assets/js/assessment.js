// ================================
// Assessment Calculation
// ================================

function updateAssessment() {

    let rows = document.querySelectorAll("tbody tr");

    let totalStudents = rows.length;

    let grandTotal = 0;

    let highest = 0;

    let lowest = 50;

    rows.forEach(function(row){

        let viva = parseInt(row.querySelector(".viva").value) || 0;

        let journal = parseInt(row.querySelector(".journal").value) || 0;

        let practical = parseInt(row.querySelector(".practical").value) || 0;

        let attendance = parseInt(row.querySelector(".attendance").value) || 0;

        let total = viva + journal + practical + attendance;

        row.querySelector(".totalMarks").innerHTML = total;

        let grade = "F";

        if(total >= 45){

            grade = "A+";

        }

        else if(total >= 40){

            grade = "A";

        }

        else if(total >= 35){

            grade = "B";

        }

        else if(total >= 30){

            grade = "C";

        }

        else{

            grade = "Fail";

        }

        row.querySelector(".grade").innerHTML = grade;

        grandTotal += total;

        if(total > highest){

            highest = total;

        }

        if(total < lowest){

            lowest = total;

        }

    });

    let average = 0;

    if(totalStudents > 0){

        average = (grandTotal / totalStudents).toFixed(1);

    }

    document.getElementById("averageMarks").innerHTML = average;

    document.getElementById("highestMarks").innerHTML = highest;

    document.getElementById("lowestMarks").innerHTML = lowest;

}

document.querySelectorAll(".mark").forEach(function(input){

    input.addEventListener("keyup", updateAssessment);

    input.addEventListener("change", updateAssessment);

});

updateAssessment();


// ================================
// Search Student
// ================================

const searchStudent = document.getElementById("searchStudent");

if(searchStudent){

searchStudent.addEventListener("keyup", function(){

let filter = this.value.toLowerCase();

let rows = document.querySelectorAll("tbody tr");

rows.forEach(function(row){

let text = row.innerText.toLowerCase();

if(text.includes(filter)){

row.style.display="";

}

else{

row.style.display="none";

}

});

});

}