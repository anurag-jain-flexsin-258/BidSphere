/* ==========================================================================
   App JS
   ==========================================================================
   - Shared across all Blade frontend pages
   - Small UX enhancements only
   - No inline JS anywhere
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function() {

    // -------------------------------
    // Confirm delete actions
    // -------------------------------
    const deleteForms = document.querySelectorAll('form[method="POST"] button[type="submit"]');

    deleteForms.forEach(function(button) {
        const form = button.closest('form');
        if (form && form.dataset.confirm !== 'false') {
            button.addEventListener('click', function(e) {
                const confirmed = confirm('Are you sure you want to proceed?');
                if (!confirmed) e.preventDefault();
            });
        }
    });

    // -------------------------------
    // Auto-focus first input in forms
    // -------------------------------
    const firstInputs = document.querySelectorAll('.app-card form input, .app-card form textarea, .app-card form select');
    firstInputs.forEach(function(input) {
        if (!input.disabled && !input.readOnly) {
            input.focus();
            return false; // Only focus first input per page
        }
    });

    // -------------------------------
    // Smooth scroll to first error
    // -------------------------------
    const errorFields = document.querySelectorAll('.is-invalid, .alert');
    if (errorFields.length > 0) {
        errorFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // -------------------------------
    // Optional: Add ripple effect to buttons (for nicer UX)
    // -------------------------------
    const rippleButtons = document.querySelectorAll('.btn');
    rippleButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const circle = document.createElement('span');
            circle.classList.add('ripple');
            this.appendChild(circle);
            const d = Math.max(this.clientWidth, this.clientHeight);
            circle.style.width = circle.style.height = d + 'px';
            const rect = this.getBoundingClientRect();
            circle.style.left = e.clientX - rect.left - d/2 + 'px';
            circle.style.top = e.clientY - rect.top - d/2 + 'px';
            setTimeout(() => circle.remove(), 600);
        });
    });

});
