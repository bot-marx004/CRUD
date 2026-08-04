document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 4 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 4000);
});