// This file can be used for client-side form validation and dynamic UI updates.

document.addEventListener('DOMContentLoaded', function() {
    // Example: Dynamic form fields for registration based on role selection
    const roleSelector = document.getElementById('role_id');
    const providerFields = document.getElementById('service-provider-fields');

    if (roleSelector) {
        roleSelector.addEventListener('change', function() {
            if (this.value === '3') { // Assuming '3' is the role_id for Service Provider
                providerFields.style.display = 'block';
            } else {
                providerFields.style.display = 'none';
            }
        });
    }
});
