function validateForm() {
    var userId = document.getElementsByName('user_id')[0].value;
    var pattern = /^\d{8}$/; // Regular expression for 8-digit number

    if (!pattern.test(userId)) {
        alert('Please enter a valid 8-digit Student ID.');
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}