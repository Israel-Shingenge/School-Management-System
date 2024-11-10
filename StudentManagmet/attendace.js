// Load students from server and populate the form
document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/students');
    const data = await response.json();

    const table = document.querySelector('table');
    data.students.forEach(student => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${student.name}</td>
            <td><input type="radio" name="${student.id}" value="Present" required></td>
            
        `;
        table.appendChild(row);
    });
});

// Validate form before submission
function validateForm() {
    const dateInput = document.getElementById('attendance_date').value;
    if (!dateInput) {
        alert('Please select a date.');
        return false;  // Prevent form submission
    }

    // Check that each student has a selected attendance status
    const studentRows = document.querySelectorAll('table tr');
    for (let i = 1; i < studentRows.length; i++) {  // Skip header row
        const radioGroup = studentRows[i].querySelectorAll('input[type="radio"]');
        const isChecked = Array.from(radioGroup).some(input => input.checked);
        
        if (!isChecked) {
            alert('Please mark attendance for all students.');
            return false;  // Prevent form submission
        }
    }

    return true;  // Allow form submission if all fields are filled
}
