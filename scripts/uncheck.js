document.addEventListener("DOMContentLoaded", () => {
    const noneCheck = document.getElementById('permission-nobody');
    const otherChecks = document.querySelectorAll('.permission-check');

    if (noneCheck) {
        noneCheck.addEventListener('change', function() {
            if (this.checked) {
                otherChecks.forEach(check => check.checked = false);
            }
        });
    }

    otherChecks.forEach(check => {
        check.addEventListener('change', function() {
            if (this.checked && noneCheck) {
                noneCheck.checked = false;
            }
        });
    });
});