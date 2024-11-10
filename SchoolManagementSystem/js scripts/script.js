console.log("JavaScript file loaded successfully");


document.addEventListener("DOMContentLoaded", function() {
    // Toggle student-specific fields
    const roleSelect = document.getElementById('role');
    const studentFields = document.getElementById('studentFields');
    const gradeField = document.querySelector("input[name='grade']");
    const parentNameField = document.querySelector("input[name='parent_name']");
    const parentContactField = document.querySelector("input[name='parent_contact']");

    document.addEventListener("DOMContentLoaded", function() {
        console.log("JavaScript file loaded successfully");
    
        const roleSelect = document.getElementById('role');
        const studentFields = document.getElementById('studentFields');
        const gradeField = document.querySelector("input[name='grade']");
        const parentNameField = document.querySelector("input[name='parent_name']");
        const parentContactField = document.querySelector("input[name='parent_contact']");
    
        console.log("roleSelect:", roleSelect);
        console.log("studentFields:", studentFields);
        console.log("gradeField:", gradeField);
        console.log("parentNameField:", parentNameField);
        console.log("parentContactField:", parentContactField);
    
        if (roleSelect && studentFields && gradeField && parentNameField && parentContactField) {
            // Hide student-specific fields initially if not a student
            studentFields.style.display = roleSelect.value === 'student' ? 'block' : 'none';
    
            roleSelect.addEventListener('change', function() {
                if (roleSelect.value === 'student') {
                    studentFields.style.display = 'block'; // Show student fields
                    gradeField.setAttribute('required', 'true');
                    parentNameField.setAttribute('required', 'true');
                    parentContactField.setAttribute('required', 'true');
                } else {
                    studentFields.style.display = 'none'; // Hide student fields
                    gradeField.removeAttribute('required');
                    parentNameField.removeAttribute('required');
                    parentContactField.removeAttribute('required');
                }
            });
        } else {
            console.error("One or more required elements (roleSelect, studentFields, gradeField, parentNameField, parentContactField) are missing.");
        }
    });
    

    // Ensure student fields are hidden or visible based on role selection on page load
    if (roleSelect.value !== 'student') {
        studentFields.style.display = 'none';
       
        gradeField.removeAttribute('required');
        parentNameField.removeAttribute('required');
        parentContactField.removeAttribute('required');
    }

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

    // Form submission validation for Sign Up
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

    // Form submission validation for Sign In
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

    // Task Management (For Dashboard)
    function addTask() {
        const taskInput = document.getElementById('new-task');
        const taskList = document.getElementById('task-list');
        const taskValue = taskInput.value.trim();

        if (taskValue) {
            const li = document.createElement('li');
            li.innerHTML = `<input type="checkbox"> ${taskValue} <button onclick="removeTask(this)">Remove</button>`;
            taskList.appendChild(li);
            taskInput.value = ''; 
        } else {
            alert('Please enter a task.'); 
        }
    }

    function removeTask(button) {
        const taskItem = button.parentElement; 
        taskItem.remove(); 
    }

    // Subject Enrollment Management (For Student Dashboard)
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
        searchResult.textContent = `${courseName} has been unenrolled.`;
        searchResult.style.color = 'blue';
    }
});
