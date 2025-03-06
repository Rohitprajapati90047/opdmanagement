document.getElementById("registerForm").addEventListener("input", function () {
    let aadhaar = document.getElementById("aadhaar").value;
    let dob = document.getElementById("dob").value;

    if (aadhaar.length >= 5 && dob) {
        let firstFiveAadhaar = aadhaar.substring(0, 5);
        let dobDate = new Date(dob);
        let registrationDate = new Date();
        
        let day = ("0" + registrationDate.getDate()).slice(-2); // Get day of registration
        let year = registrationDate.getFullYear(); // Get year of registration
        let age = new Date().getFullYear() - dobDate.getFullYear(); // Calculate age

        let generatedUsername = `${firstFiveAadhaar}${day}${year}${age}`;
        document.getElementById("username").value = generatedUsername;
    }
});

// Show popup alert with username on form submission
document.getElementById("registerForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent actual form submission

    let username = document.getElementById("username").value;
    if (username) {
        alert(`Your generated username is: ${username}`);
    } else {
        alert("Please fill in all details to generate your username.");
    }
});
