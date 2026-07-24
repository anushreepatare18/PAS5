// ================================
// Attendance Summary Update
// ================================

function updateAttendanceSummary() {

    const total = document.querySelectorAll("tbody tr").length;

    const present = document.querySelectorAll("input[value='Present']:checked").length;

    const absent = total - present;

    let percentage = 0;

    if(total > 0){

        percentage = ((present / total) * 100).toFixed(1);

    }

    document.getElementById("presentCount").innerHTML = present;

    document.getElementById("absentCount").innerHTML = absent;

    document.getElementById("attendancePercentage").innerHTML = percentage + "%";

}

// Radio Button Events

document.querySelectorAll("input[type='radio']").forEach(function(radio){

    radio.addEventListener("change", updateAttendanceSummary);

});

// First Time

updateAttendanceSummary();


// ================================
// Student Search
// ================================

const searchInput = document.getElementById("searchStudent");

if(searchInput){

searchInput.addEventListener("keyup", function(){

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