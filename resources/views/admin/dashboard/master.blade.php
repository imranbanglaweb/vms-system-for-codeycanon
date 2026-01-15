<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
@include('admin.dashboard.common.header')
	
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<style>
	    /* Loading Spinner */
	    .loading-overlay {
	        display: none;
	        background: rgba(255, 255, 255, 0.8);
	        position: fixed;
	        top: 0;
	        left: 0;
	        width: 100%;
	        height: 100%;
	        z-index: 9999;
	    }

	    .loading-overlay .spinner {
	        position: absolute;
	        top: 50%;
	        left: 50%;
	        transform: translate(-50%, -50%);
	        text-align: center;
	    }

	    .loading-overlay .spinner i {
	        color: #007bff;
	    }

	    .loading-overlay .spinner p {
	        margin-top: 10px;
	        color: #6c757d;
	    }

	    /* Form Validation Styles */
	    .form-control.is-invalid {
	        border-color: #dc3545;
	        padding-right: calc(1.5em + 0.75rem);
	        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
	        background-repeat: no-repeat;
	        background-position: right calc(0.375em + 0.1875rem) center;
	        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
	    }

	    .form-control.is-invalid:focus {
	        border-color: #dc3545;
	        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
	    }

	    .invalid-feedback {
	        display: none;
	        width: 100%;
	        margin-top: 0.25rem;
	        font-size: 80%;
	        color: #dc3545;
	    }

	    .is-invalid ~ .invalid-feedback {
	        display: block;
	    }

	    /* Select2 Validation Styles */
	    .select2-container .select2-selection--single.is-invalid {
	        border-color: #dc3545;
	    }

	    .select2-container .select2-selection--single.is-valid {
	        border-color: #28a745;
	    }

	    /* Custom File Input Validation */
	    .custom-file-input.is-invalid ~ .custom-file-label {
	        border-color: #dc3545;
	    }

	    .custom-file-input.is-invalid:focus ~ .custom-file-label {
	        border-color: #dc3545;
	        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
	    }

	    .custom-file-label.is-invalid {
	        border-color: #dc3545;
	    }

	    .custom-file-label.is-valid {
	        border-color: #28a745;
	    }

	    /* Form Group Spacing */
	    .form-group {
	        margin-bottom: 1rem;
	    }

	    /* Required Field Indicator */
	    .required-field::after {
	        content: "*";
	        color: #dc3545;
	        margin-left: 4px;
	    }

	    /* Form Label Styling */
	    label {
	        margin-bottom: 0.5rem;
	        font-weight: 500;
	    }

	    /* Input Group Validation */
	    .input-group .form-control.is-invalid {
	        z-index: 2;
	    }

	    .input-group .form-control.is-invalid:focus {
	        z-index: 3;
	    }

	    /* Textarea Validation */
	    textarea.form-control.is-invalid {
	        padding-right: calc(1.5em + 0.75rem);
	        background-position: top calc(0.375em + 0.1875rem) right calc(0.375em + 0.1875rem);
	    }

	    /* Checkbox/Radio Validation */
	    .custom-control-input.is-invalid ~ .custom-control-label {
	        color: #dc3545;
	    }

	    .custom-control-input.is-invalid ~ .custom-control-label::before {
	        border-color: #dc3545;
	    }

	    /* Modal Form Validation */
	    .modal-body .form-control.is-invalid {
	        margin-bottom: 0;
	    }

	    .modal-body .invalid-feedback {
	        margin-bottom: 1rem;
	    }

	    /* Modal Styles */
	    .modal-header {
	        background: #f8f9fa;
	        border-bottom: 1px solid #dee2e6;
	    }

	    .modal-footer {
	        background: #f8f9fa;
	        border-top: 1px solid #dee2e6;
	    }

	    /* Alert Styles */
	    .alert {
	        padding: 0.75rem 1.25rem;
	        margin-bottom: 1rem;
	        border: 1px solid transparent;
	        border-radius: 0.25rem;
	    }

	    .alert-success {
	        color: #155724;
	        background-color: #d4edda;
	        border-color: #c3e6cb;
	    }

	    .alert-danger {
	        color: #721c24;
	        background-color: #f8d7da;
	        border-color: #f5c6cb;
	    }

	    /* Add to your existing style section */
	    .tox-tinymce {
	        border: 1px solid #ced4da !important;
	        border-radius: 0.25rem !important;
	    }

	    .tox-tinymce.is-invalid {
	        border-color: #dc3545 !important;
	    }

	    .tox-statusbar {
	        display: none !important;
	    }

	    .tox .tox-toolbar__group {
	        padding: 0 5px !important;
	    }

	    .tox .tox-toolbar__primary {
	        background: #f8f9fa !important;
	        border-bottom: 1px solid #dee2e6 !important;
	    }

	    /* Modal Styles */
	    .modal {
	        background: rgba(0, 0, 0, 0.5);
	    }

	    .modal-dialog {
	        margin: 1.75rem auto;
	    }

	    .modal-content {
	        position: relative;
	        display: flex;
	        flex-direction: column;
	        width: 100%;
	        background-color: #fff;
	        border-radius: 0.3rem;
	        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
	    }

	    .modal-backdrop {
	        background-color: rgba(0, 0, 0, 0.5);
	    }

	    .modal-backdrop.show {
	        opacity: 1;
	    }

	    /* Fix for multiple backdrops */
	    .modal-backdrop ~ .modal-backdrop {
	        display: none;
	    }

	    /* Fix for scrollbar jump */
	    body.modal-open {
	        padding-right: 0 !important;
	        overflow: hidden;
	    }
	</style>

	@stack('styles')
	<style>
		/* Custom professional sidebar theme */
		.sidebar-left {
			background: linear-gradient(180deg, #0b1220 0%, #07101a 100%);
			border-right: 1px solid rgba(255,255,255,0.03);
		}

		/* Sidebar header */
		.sidebar-left .sidebar-header {
			padding: 18px 16px;
			background: transparent;
			border-bottom: 1px solid rgba(255,255,255,0.03);
		}

		.sidebar-left .sidebar-title a {
			color: #ffffff;
			font-weight: 600;
			letter-spacing: 0.2px;
			text-transform: none;
		}

		/* Main nav links */
		.sidebar-left .nav-main .nav > li > a {
			color: #cbd5e1;
			padding: 10px 18px;
			display: flex;
			align-items: center;
			transition: background-color .15s ease, color .15s ease;
		}

		.sidebar-left .nav-main .nav > li > a i {
			color: #60a5fa; /* icon primary color */
			width: 22px;
			text-align: center;
			margin-right: 10px;
			font-size: 14px;
		}

		/* Active / hover state */
		.sidebar-left .nav-main .nav > li.active > a,
		.sidebar-left .nav-main .nav > li > a:hover,
		.sidebar-left .nav-main .nav > li > a:focus {
			background: rgba(96,165,250,0.08);
			color: #ffffff;
			border-left: 3px solid #60a5fa;
		}

		.sidebar-left .nav-main .nav > li.active > a i,
		.sidebar-left .nav-main .nav > li > a:hover i {
			color: #ffffff; /* icon white on active/hover */
		}

		/* Submenu style */
		.sidebar-left .nav-main .nav .nav-children {
			background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.00));
			margin-left: 6px;
			padding-left: 6px;
			border-left: 1px solid rgba(255,255,255,0.02);
		}

		.sidebar-left .nav-main .nav .nav-children li a {
			color: #98a6bb;
			padding-left: 36px;
			font-size: 14px;
		}

		.sidebar-left .nav-main .nav .nav-children li a:hover {
			color: #ffffff;
			background: rgba(255,255,255,0.02);
		}

		/* Small polish */
		.sidebar-left .nav-main .nav .fa { opacity: 0.95; }
		.sidebar-left .sidebar-toggle i { color: #cbd5e1; }
		.nano .nano-content { padding-top: 8px; }

		/* Ensure selected submenu stands out */
		.sidebar-left .nav-main .nav .sub-nav-active {
			color: #ffffff !important;
			background: rgba(96,165,250,0.06) !important;
		}
	</style>
</head>
<body>
	<!-- Loading Overlay -->
	<div class="loading-overlay">
		<div class="spinner">
			<i class="fa fa-spinner fa-spin fa-3x"></i>
			<p class="mt-2">Loading...</p>
		</div>
	</div>

	<!-- Main Wrapper -->
	<div class="wrapper">
		<!-- Include Sidebar -->
@include('admin.dashboard.common.sidebar')

		<!-- Content Wrapper -->
		<div class="content-wrapper">
				@yield('main_content')
			</div>
	</div>

	<!-- Core JS Files - Use only one version of jQuery -->
	<script src="{{ asset('public/admin_resource/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
	<!-- Popper (CDN; integrity removed because some installs reported SRI mismatch). If CDN fails, fallback to local copy. -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous" onerror="(function(){var s=document.createElement('script');s.src='{{ asset('public/admin_resource/assets/vendor/popper/popper.min.js') }}';s.crossOrigin='anonymous';document.head.appendChild(s);})();"></script>
	<script src="{{ asset('public/admin_resource/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
	<!-- theme's common.js not found in some installs; rely on theme.js below. If you need custom common utilities, add public/admin_resource/assets/vendor/common/common.js -->
	<script src="{{ asset('public/admin_resource/assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
	<script src="{{ asset('public/admin_resource/assets/vendor/magnific-popup/magnific-popup.js') }}"></script>
	<script src="{{ asset('public/admin_resource/assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
		
		<!-- Specific Page Vendor -->
	<script src="{{ asset('public/admin_resource/assets/vendor/select2/select2.js') }}"></script>
	<script src="{{ asset('public/admin_resource/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('public/admin_resource/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
		
		<!-- Theme Base, Components and Settings -->
	<script src="{{ asset('public/admin_resource/assets/javascripts/theme.js') }}"></script>
	<script src="{{ asset('public/admin_resource/assets/javascripts/theme.custom.js') }}"></script>
	<script src="{{ asset('public/admin_resource/assets/javascripts/theme.init.js') }}"></script>

	<!-- Global Script -->
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Setup AJAX CSRF token
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		// Initialize plugins
		if ($.fn.select2) {
			$('.select2').select2();
		}
		
		if ($.fn.DataTable) {
			$('.datatable').DataTable();
		}
		
		if ($.fn.nanoScroller) {
			$('.nano').nanoScroller();
		}
	});
	</script>

	<!-- Page Specific Scripts -->
	@stack('scripts')

	<!-- Add this just before </body> -->
	<div class="loading-overlay">
		<div class="spinner">
			<i class="fa fa-spinner fa-spin fa-3x"></i>
			<p class="mt-2">Loading...</p>
		</div>
	</div>

	<!-- Add in head section -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">

	<!-- Add before closing body tag -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

	<!-- Add this in the head section -->
	 <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet"> 
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>


<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
if ('serviceWorker' in navigator && 'PushManager' in window) {

    navigator.serviceWorker.register('/vms/sw.js')
	
        .then(function (registration) {

            return Notification.requestPermission().then(function (permission) {

                if (permission !== 'granted') {
                    console.warn('Push permission denied');
                    return;
                }

                return registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: "{{ config('webpush.vapid.public_key') }}"
                });
            });
        })
        .then(function (subscription) {

            if (!subscription) return;
			    fetch("{{ route('push.subscribe') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(subscription)
            });
        })
        .then(function () {
            console.log('Push subscription stored');
        })
        .catch(function (err) {
            console.error('Push error:', err);
        });
}
</script>

	<script>

// helper function
function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');
    const rawData = atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    for (let i = 0; i < rawData.length; ++i) outputArray[i] = rawData.charCodeAt(i);
    return outputArray;
}

</script>

	<script>
Notification.requestPermission().then(function(permission) {
    console.log('Permission:', permission);
});
</script>
<script>
    Pusher.logToConsole = false;

    const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: true
    });

    const channel = pusher.subscribe('admin-notifications');

    channel.bind('requisition.created', function(data) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: 'New Requisition',
            html: `<strong>${data.number}</strong><br>Requested by ${data.employee}`,
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    });
</script>

	<!-- Replace the TinyMCE initialization script with this -->
	<script>
	// Initialize Summernote
	function initSummernote(selector = '.summernote') {
		$(selector).summernote({
			height: 100,
			toolbar: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough']],
				['para', ['ul', 'ol']],
				['insert', ['link']],
				['view', ['fullscreen', 'codeview']],
			],
			callbacks: {
				onChange: function(contents) {
					$(this).val(contents).trigger('change');
				}
			}
		});
	}

	// Initialize Summernote when document is ready
    //     $(document).ready(function() {
	// 	initSummernote();
	// });

	// Reinitialize Summernote in modal forms
	// $(document).on('shown.bs.modal', function() {
	// 	initSummernote();
	// });
	</script>

	<!-- Add this to your existing script section -->
	<script>
	// Global function to toggle loading overlay
	function toggleLoading(show = true) {
		if (show) {
			$('.loading-overlay').fadeIn();
		} else {
			$('.loading-overlay').fadeOut();
		}
	}

	// Global function to show form errors
	function showFormErrors(form, errors) {
		$.each(errors, function(field, messages) {
			var input = form.find(`[name="${field}"]`);
			input.addClass('is-invalid');
			input.siblings('.invalid-feedback').html(messages[0]);
			
			// Special handling for Select2
			if (input.hasClass('select2')) {
				input.next('.select2-container').find('.select2-selection').addClass('is-invalid');
			}
		});
	}

	// Global function to clear form errors
	function clearFormErrors(form) {
		form.find('.is-invalid').removeClass('is-invalid');
		form.find('.invalid-feedback').html('');
		form.find('.select2-selection').removeClass('is-invalid');
		$('#modal-alert-container').empty();
	}

	// Global function to show modal alerts
	function showModalAlert(type, message) {
		var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
		var alert = `
			<div class="alert ${alertClass} alert-dismissible fade show">
				${message}
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		`;
		$('#modal-alert-container').html(alert);
	}

	// Global function to show alerts (SweetAlert2)
	function showAlert(type, message) {
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			timerProgressBar: true
		});

		Toast.fire({
			icon: type,
			title: message
		});
	}

	// Global function to handle form submissions
	function submitForm(form) {
		$.ajax({
			url: form.attr('action'),
			method: form.attr('method'),
			data: form.serialize(),
			beforeSend: function() {
				toggleLoading(true);
				form.find('button[type="submit"]').prop('disabled', true);
			},
			success: function(response) {
				if (response.success) {
					$('.modal').modal('hide');
					showAlert('success', response.message);
					// Reload the table or page after successful submission
					setTimeout(function() {
						window.location.reload();
					}, 1000);
				} else {
					showModalAlert('error', response.message || 'Error occurred');
				}
			},
			error: function(xhr) {
				if (xhr.responseJSON && xhr.responseJSON.errors) {
					showFormErrors(form, xhr.responseJSON.errors);
					showModalAlert('error', 'Please correct the errors below.');
				} else {
					showModalAlert('error', 'An error occurred while processing your request.');
				}
			},
			complete: function() {
				toggleLoading(false);
				form.find('button[type="submit"]').prop('disabled', false);
			}
		});
	}

	// Initialize Summernote in modals
	$(document).on('shown.bs.modal', function() {
		$('.summernote').summernote({
			height: 200,
			toolbar: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough']],
				['para', ['ul', 'ol']],
				['height', ['height']]
			]
		});
	});

	// Clean up Summernote when modal is closed
	$(document).on('hidden.bs.modal', function() {
		$('.summernote').summernote('destroy');
});
		</script>

	<!-- In the head section -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.css"> 

	<!-- Before closing body tag -->
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>

	<!-- NiceScroll -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script>
$(document).ready(function () {
    $("body").niceScroll({
        cursorcolor: "#000",   // scrollbar color
        cursorwidth: "10px",
        cursorborder: "2px solid #666",
        cursorborderradius: "6px",
        background: "#f6f6f6", // scrollbar track color
        autohidemode: true,
        smoothscroll: true,
        scrollspeed: 60,
        mousescrollstep: 40
    });
});
</script>

@yield('scripts')

	</body>
</html>