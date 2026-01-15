@extends('admin.dashboard.master')

@section('main_content')

<style>

  /* Input and Select styling */
input.form-control,
select.form-select {
    color: #000;              /* Black text */
    font-size: 1.2rem;        /* Increase font size */
    font-weight: 500;          /* Slightly bold for readability */
    background-color: #fff;    /* Keep white background */
    padding: 0.5rem 0.75rem;   /* Add padding for better look */
}

/* Floating labels text */
.form-floating > label {
    font-size: 1.2rem;           /* Increase label size */
    font-weight: 500;
    color: #000;              /* Slightly darker gray for better readability */
}

/* Table inputs */
#itemsTable input,
#itemsTable select {
    font-size: 1.2rem;
    color: #000;
}

/* Cost summary inputs */
#chargeAmount,
#totalPartsCost,
#grandTotal {
    font-size: 1.1rem;
    font-weight: 500;
    color: #000;
}

/* Body & Card */
body {
    background-color: #f8f9fa;
}
.card {
    background-color: #fff;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
}
.card-header {
    background-color: #fff;
    border-bottom: 1px solid #e5e5e5;
}
.form-floating .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
}
.table thead th {
    vertical-align: middle;
    text-align: center;
}
.table tbody td {
    vertical-align: middle;
}
.table-hover tbody tr:hover {
    background-color: #f1f4f8;
}
.removeRow {
    cursor: pointer;
}
input.border-danger, select.border-danger {
    border-color: #dc3545 !important;
    animation: shake 0.3s;
}
@keyframes shake {
    0% { transform: translateX(0px); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
    100% { transform: translateX(0px); }
}
.btn-primary {
    background-color: #0d6efd;
    border: none;
}
.btn-success {
    background-color: #198754;
    border: none;
}
</style>

<section class="content-body py-5">
    <div class="container">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary"><i class="fa fa-tools me-2"></i> Create Maintenance Requisition</h3>
            <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>

        {{-- Form --}}
        <form id="requisitionForm" action="{{ route('maintenance.store') }}" method="POST">
            @csrf
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-header py-3">
                    <h4 class="mb-0 fw-bold"><strong>Requisition Details</strong></h4>
                </div>
                <div class="card-body">

                    <div class="row g-4">

                        {{-- Left Column --}}
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="requisition_type" class="form-select  select2" id="requisitionType">
                                    <option value="">Select Type</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Breakdown">Breakdown</option>
                                    <option value="Inspection">Inspection</option>
                                </select>
                                <label for="requisitionType">Requisition Type</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select name="priority" class="form-select  select2" id="priority">
                                    <option value="">Select Priority</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                    <option value="Urgent">Urgent</option>
                                </select>
                                <label for="priority">Priority</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select name="employee_id" class="form-select select2" id="employeeSelect">
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                    @endforeach
                                </select>
                                <label for="employeeSelect">Requisition For (Employee)</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select name="vehicle_id" class="form-select  select2" id="vehicleSelect">
                                    <option value="">Select Vehicle</option>
                                    @foreach($vehicles as $v)
                                        <option value="{{ $v->id }}">{{ $v->vehicle_name }} - {{ $v->model }}</option>
                                    @endforeach
                                </select>
                                <label for="vehicleSelect">Vehicle</label>
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="maintenance_type_id" class="form-select  select2" id="maintenanceType">
                                    <option value="">Select Type</option>
                                    @foreach($types as $t)
                                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                                    @endforeach
                                </select>
                                <label for="maintenanceType">Maintenance Type</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="date" name="maintenance_date" class="form-control" id="maintenanceDate">
                                <label for="maintenanceDate">Maintenance Date</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="service_title" class="form-control" id="serviceTitle">
                                <label for="serviceTitle">Service Title</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select name="charge_bear_by" class="form-select" id="chargeBearBy">
                                    <option value="">Select</option>
                                    <option>Company</option>
                                    <option>Employee</option>
                                    <option>Department</option>
                                </select>
                                <label for="chargeBearBy">Charge Bear By</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Maintenance Items --}}
                    <h5 class="fw-bold mb-3">Maintenance Items</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" id="itemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Category</th>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="items[0][category_id]" class="form-select categorySelect">
                                            <option value="">Select</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="items[0][item_name]" class="form-control itemName" placeholder="Item Name">
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][qty]" class="form-control qty text-center" value="1" min="1">
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][unit_price]" class="form-control unitPrice text-end" value="0" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][total_price]" class="form-control totalPrice text-end" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="addRow" class="btn btn-primary btn-sm mb-4"><i class="fa fa-plus me-1"></i> Add Item</button>

                    <hr class="my-4">

                    {{-- Cost Summary --}}
                    <div class="row g-3 text-center">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" name="charge_amount" id="chargeAmount" class="form-control text-end" value="0" step="0.01">
                                <label for="chargeAmount">Charge Amount</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" id="totalPartsCost" class="form-control text-end" readonly>
                                <label for="totalPartsCost">Total Parts Cost</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" id="grandTotal" class="form-control text-end" readonly>
                                <label for="grandTotal">Grand Total Cost</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-5 py-2"><i class="fa fa-check me-1"></i> Submit Requisition</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</section>

<!-- SweetAlert2 -->
 	<!-- Core JS Files - Use only one version of jQuery -->
<script src="{{ asset('public/admin_resource/assets/vendor/jquery/jquery.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    // Initialize Select2 for static fields
    $('.select2').select2();

    let row = 1;

    // Add new row
    $("#addRow").on("click", function () {
        let newRow = `
            <tr>
                <td>
                    <select name="items[${row}][category_id]" class="form-select categorySelect select2Dynamic">
                        <option value="">Select</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="items[${row}][item_name]" class="form-control itemName"></td>
                <td><input type="number" name="items[${row}][qty]" class="form-control qty text-center" value="1"></td>
                <td><input type="number" name="items[${row}][unit_price]" class="form-control unitPrice text-end" value="0"></td>
                <td><input type="number" name="items[${row}][total_price]" class="form-control totalPrice text-end" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-minus"></i></button></td>
            </tr>
        `;

        $("#itemsTable tbody").append(newRow);

        // Re-init Select2 for dynamically added dropdowns
        $(".select2Dynamic").select2({
            width: "100%"
        });

        row++;
    });

    // Remove row
    $(document).on("click", ".removeRow", function () {
        $(this).closest("tr").remove();
        calculateTotals();
    });

    // Value change triggers calculation
    $(document).on("input", ".qty, .unitPrice, #chargeAmount", function () {
        calculateTotals();
    });

    function calculateTotals() {
        let totalParts = 0;

        $("#itemsTable tbody tr").each(function () {
            let qty = $(this).find(".qty").val() || 0;
            let price = $(this).find(".unitPrice").val() || 0;
            let total = qty * price;

            $(this).find(".totalPrice").val(total.toFixed(2));
            totalParts += total;
        });

        $("#totalPartsCost").val(totalParts.toFixed(2));

        let chargeAmount = parseFloat($("#chargeAmount").val()) || 0;
        $("#grandTotal").val((totalParts + chargeAmount).toFixed(2));
    }

    // AJAX Submit
    $("#requisitionForm").on("submit", function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        // Validate required fields
        let requiredFields = [
            "#requisitionType", "#priority", "#vehicleSelect",
            "#maintenanceType", "#maintenanceDate", "#serviceTitle"
        ];

        let missing = false;
        requiredFields.forEach(function (f) {
            if ($(f).val() === "") missing = true;
        });

        if (missing) {
            Swal.fire("Required Fields Missing", "Please fill all fields!", "warning");
            return;
        }

        // Validate items
        let invalidRow = false;
        $("#itemsTable tbody tr").each(function () {
            let category = $(this).find(".categorySelect").val();
            let itemName = $(this).find(".itemName").val();
            let qty = $(this).find(".qty").val();
            let unitPrice = $(this).find(".unitPrice").val();

            if (!category || !itemName || !qty || !unitPrice) {
                invalidRow = true;
                return false;
            }
        });

        if (invalidRow) {
            Swal.fire("Invalid Item", "Please complete all item rows!", "warning");
            return;
        }

        // AJAX request
        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: formData,
            success: function (res) {
                Swal.fire("Success", res.message, "success");

                // Reload or redirect
                setTimeout(() => {
                    window.location.href = "{{ route('maintenance.index') }}";
                }, 1500);
            },
            error: function (xhr) {
                Swal.fire("Error", "Something went wrong!", "error");
            }
        });
    });

});
</script>



<!-- <script>
let row = 1;

// Add new row
document.getElementById("addRow").addEventListener("click", function () {
    let table = document.querySelector("#itemsTable tbody");
    let newRow = `
        <tr>
            <td>
                <select name="items[${row}][category_id]" class="form-select categorySelect">
                    <option value="">Select</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" name="items[${row}][item_name]" class="form-control itemName"></td>
            <td><input type="number" name="items[${row}][qty]" class="form-control qty text-center" value="1" min="1"></td>
            <td><input type="number" name="items[${row}][unit_price]" class="form-control unitPrice text-end" value="0" step="0.01"></td>
            <td><input type="number" name="items[${row}][total_price]" class="form-control totalPrice text-end" readonly></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-minus"></i></button></td>
        </tr>
    `;
    table.insertAdjacentHTML('beforeend', newRow);
    row++;
});

// Remove row
document.addEventListener("click", function (e) {
    if (e.target.closest(".removeRow")) {
        e.target.closest("tr").remove();
        calculateTotals();
    }
});

// Auto calculation
document.addEventListener("input", function (e) {
    if (e.target.classList.contains("qty") ||
        e.target.classList.contains("unitPrice") ||
        e.target.id === "chargeAmount") {
        calculateTotals();
    }
});

function calculateTotals() {
    let totalParts = 0;
    document.querySelectorAll("#itemsTable tbody tr").forEach((tr) => {
        let qty = tr.querySelector(".qty").value || 0;
        let price = tr.querySelector(".unitPrice").value || 0;
        let total = qty * price;
        tr.querySelector(".totalPrice").value = total.toFixed(2);
        totalParts += total;
    });
    document.getElementById("totalPartsCost").value = totalParts.toFixed(2);
    let chargeAmount = parseFloat(document.getElementById("chargeAmount").value || 0);
    document.getElementById("grandTotal").value = (totalParts + chargeAmount).toFixed(2);
}

// Form validation on submit
document.getElementById("requisitionForm").addEventListener("submit", function(e) {
    e.preventDefault(); // Prevent default submit

    // Required fields
    let requisitionType = document.getElementById("requisitionType").value;
    let priority = document.getElementById("priority").value;
    let vehicle = document.getElementById("vehicleSelect").value;
    let maintenanceType = document.getElementById("maintenanceType").value;
    let maintenanceDate = document.getElementById("maintenanceDate").value;
    let serviceTitle = document.getElementById("serviceTitle").value;

    if (!requisitionType || !priority || !vehicle || !maintenanceType || !maintenanceDate || !serviceTitle) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Required Fields',
            text: 'Please fill all required fields before submitting!',
        });
        return;
    }

    // At least one item
    let items = document.querySelectorAll("#itemsTable tbody tr");
    if (items.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No Items Added',
            text: 'Please add at least one maintenance item!',
        });
        return;
    }

    // Validate each item row
    for (let tr of items) {
        let category = tr.querySelector(".categorySelect").value;
        let itemName = tr.querySelector(".itemName").value;
        let qty = tr.querySelector(".qty").value;
        let unitPrice = tr.querySelector(".unitPrice").value;

        // alert(itemName);

        if (!category || !itemName || !qty || !unitPrice) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Item Row',
                text: 'Please fill all fields in each item row!',
            });
            return;
        }
    }

    // All validations passed, submit form
    this.submit();
});
</script> -->
@endsection
