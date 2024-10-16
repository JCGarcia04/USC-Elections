function validateForm() {
    // Get the President checkboxes and count how many are checked
    const presidentChecked = document.querySelectorAll('input[name="president[]"]:checked').length;
    if (presidentChecked !== 1) {
        alert("You must select exactly one candidate for President.");
        return false; // Prevents form submission
    }

    // Get the Vice President Internal checkboxes and count how many are checked
    const vpInternalChecked = document.querySelectorAll('input[name="vpinternal[]"]:checked').length;
    if (vpInternalChecked === 0 || vpInternalChecked > 2) {
        alert("You must select up to 2 candidates for Vice President Internal.");
        return false; // Prevents form submission
    }

    // Add similar checks for other positions if necessary, change position before "Checked" if necessary
    const vpExternalChecked = document.querySelectorAll('input[name="vpexternal[]"]:checked').length;
    if (vpExternalChecked === 0 || vpExternalChecked > 2) {
        alert("You must select up to 2 candidates for Vice President External.");
        return false; // Prevents form submission
    }

    const secretaryChecked = document.querySelectorAll('input[name="secretary[]"]:checked').length;
    if (secretaryChecked === 0 || secretaryChecked > 2) {
        alert("You must select up to 2 candidates for Secretary.");
        return false; // Prevents form submission
    }

    return true;
}