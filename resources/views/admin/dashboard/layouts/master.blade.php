<!DOCTYPE html>
<html>
<head>
    <!-- ... other head elements ... -->
    
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <!-- Your existing styles -->
    @stack('styles')
</head>
<body>
    <!-- ... body content ... -->
    
    <!-- jQuery (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    
    <!-- Your existing scripts -->
    @stack('scripts')
    
    <script>
    // Common functions
    function toggleLoading(show) {
        if (show) {
            if (!$('#loadingIndicator').length) {
                $('body').append('<div id="loadingIndicator" class="loading-overlay"><div class="spinner"></div></div>');
            }
            $('#loadingIndicator').show();
        } else {
            $('#loadingIndicator').hide();
        }
    }

    function showAlert(type, message) {
        Swal.fire({
            icon: type,
            title: type === 'error' ? 'Error' : 'Success',
            text: message,
            timer: type === 'error' ? 0 : 1500,
            showConfirmButton: type === 'error'
        });
    }

    // Initialize any sortable elements
    $(document).ready(function() {
        try {
            if ($.fn.sortable) {
                $('.sortable').sortable({
                    handle: '.sort-handle',
                    update: function(event, ui) {
                        // Add your sort update logic here if needed
                    }
                });
            }
        } catch (e) {
            console.warn('Sortable initialization error:', e);
        }
    });
    </script>
</body>
</html>

<style>
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Sortable styles */
.sortable {
    list-style: none;
    padding: 0;
}

.sort-handle {
    cursor: move;
    margin-right: 10px;
}

.ui-sortable-helper {
    background: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.ui-sortable-placeholder {
    visibility: visible !important;
    background: #f8f9fa;
    border: 1px dashed #dee2e6;
}
</style> 