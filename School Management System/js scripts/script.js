document.addEventListener("DOMContentLoaded", function() {
    // Password visibility toggle
    const togglePasswordIcons = document.querySelectorAll(".password-toggle");

    togglePasswordIcons.forEach(icon => {
        icon.addEventListener("click", function() {
            const passwordInput = icon.previousElementSibling;
            const iconElement = icon.querySelector('i');

            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
            iconElement.classList.toggle('fa-eye');
            iconElement.classList.toggle('fa-eye-slash');
        });
    });

    // Validation for Sign Up form
    const signUpForm = document.querySelector("#signUpForm");
    if (signUpForm) {
        signUpForm.addEventListener("submit", function(event) {
            const password = signUpForm.querySelector("input[name='password']").value;
            const repeatPassword = signUpForm.querySelector("input[name='repeat_password']").value;

            if (password !== repeatPassword) {
                alert("Passwords do not match.");
                event.preventDefault();
            }
        });
    }

    // Validation for Sign In form
    const signInForm = document.querySelector("#signInForm");
    if (signInForm) {
        signInForm.addEventListener("submit", function(event) {
            const username = signInForm.querySelector("input[name='username']").value;
            const password = signInForm.querySelector("input[name='password']").value;

            if (!username || !password) {
                alert("Both username and password are required.");
                event.preventDefault();
            }
        });
    }

    // Initialize Chart.js for Performance Chart
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const performanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Math', 'English', 'Science', 'History', 'Art'],
            datasets: [{
                label: 'Grades',
                data: [88, 92, 85, 94, 90],
                backgroundColor: ['#4a90e2', '#50bcb6', '#e28849', '#e34949', '#8650bc'],
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});

// Task Management
function addTask() {
    const taskInput = document.getElementById('new-task');
    const taskList = document.getElementById('task-list');
    const taskValue = taskInput.value.trim();

    if (taskValue) {
        const li = document.createElement('li');
        li.innerHTML = `<input type="checkbox"> ${taskValue} <button onclick="removeTask(this)">Remove</button>`;
        taskList.appendChild(li);
        taskInput.value = ''; // Clear the input field
    } else {
        alert('Please enter a task.'); // Alert if the input is empty
    }
}

function removeTask(button) {
    const taskItem = button.parentElement; // Get the parent <li> element
    taskItem.remove(); // Remove the task from the list
}

// Subject Enrollment Management
const availableSubjects = [
    'Mathematics', 'Science', 'History', 'English', 'Biology', 
    'Chemistry', 'Physics', 'Computer Science', 'Geography', 'Literature'
];

function searchAndEnrollSubject() {
    const searchInput = document.getElementById('subject-search');
    const searchResult = document.getElementById('search-result');
    const enrolledSubjects = document.getElementById('enrolled-subjects');

    const searchTerm = searchInput.value.trim().replace(/\w\S*/g, 
        txt => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase());

    searchResult.textContent = '';

    if (availableSubjects.includes(searchTerm)) {
        const existingEnrollments = Array.from(enrolledSubjects.children)
            .map(li => li.textContent.replace('Deregister', '').trim());

        if (existingEnrollments.includes(searchTerm)) {
            searchResult.textContent = `You are already enrolled in ${searchTerm}.`;
            searchResult.style.color = 'orange';
        } else {
            const li = document.createElement('li');
            li.innerHTML = `${searchTerm} <button onclick="deregisterCourse(this)">Deregister</button>`;
            enrolledSubjects.appendChild(li);
            
            searchResult.textContent = `Successfully enrolled in ${searchTerm}!`;
            searchResult.style.color = 'black';
        }
    } else {
        searchResult.textContent = `Sorry, ${searchTerm} is not available.`;
        searchResult.style.color = 'black';
    }

    searchInput.value = '';
}

function deregisterCourse(button) {
    const subjectItem = button.parentElement;
    const courseName = subjectItem.textContent.replace('Deregister', '').trim();
    
    subjectItem.remove();
    
    const searchResult = document.getElementById('search-result');
    searchResult.textContent = `${courseName} has been deregistered.`;
    searchResult.style.color = 'blue';
}
