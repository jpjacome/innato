<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            // Remove active class from all tabs and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            document.getElementById(tabId + '-tab').classList.add('active');
        });
    });

    // Add activity functionality
    let activityIndex = {{ count($destination->activities ?? []) }};
    document.getElementById('add-activity').addEventListener('click', function() {
        const container = document.getElementById('activities-container');
        const newActivity = document.createElement('div');
        newActivity.className = 'activity-item';
        newActivity.innerHTML = `
            <input type="text" name="activities[${activityIndex}][name]" placeholder="Activity name">
            <input type="text" name="activities[${activityIndex}][icon]" placeholder="Icon class" value="ph ph-activity">
            <button type="button" class="remove-item">Remove</button>
        `;
        container.appendChild(newActivity);
        activityIndex++;
        
        // Add remove functionality to new item
        newActivity.querySelector('.remove-item').addEventListener('click', function() {
            newActivity.remove();
        });
    });

    // Add service functionality
    let serviceIndex = {{ count($destination->services ?? []) }};
    document.getElementById('add-service').addEventListener('click', function() {
        const container = document.getElementById('services-container');
        const newService = document.createElement('div');
        newService.className = 'service-item';
        newService.innerHTML = `
            <input type="text" name="services[${serviceIndex}][name]" placeholder="Service name">
            <select name="services[${serviceIndex}][available]">
                <option value="1">Available</option>
                <option value="0">Not Available</option>
            </select>
            <button type="button" class="remove-item">Remove</button>
        `;
        container.appendChild(newService);
        serviceIndex++;
        
        // Add remove functionality to new item
        newService.querySelector('.remove-item').addEventListener('click', function() {
            newService.remove();
        });
    });

    // Add remove functionality to existing items
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            this.parentElement.remove();
        });
    });

    // Form auto-save (optional)
    let saveTimeout;
    const formInputs = document.querySelectorAll('input, textarea, select');
    
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            // Show saving indicator
            saveTimeout = setTimeout(() => {
                // Auto-save functionality can be implemented here
                console.log('Auto-save triggered');
            }, 2000);
        });
    });
});
</script>
