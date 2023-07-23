@extends('layouts.app')
@section('title')
    My Transfers
@endsection

@section('content')
    <div class="bg-info open d-flex align-items-baseline justify-content-between p-2">
        <span class="search-text fw-bold me-2">نموذج اضافة حوالة</span>
        <button class="btn border-0 search-button bg-info">
            <i class="fa-solid  arrow fs-4 border-0 fa-circle-chevron-down"></i>
        </button>
    </div>
    <div class="container">
        <form id="filterForm" method="GET" action="{{route('transfer.filter')}}">
            <div class="form row py-5">
                <div class="col">
                    <input type="text" name="from_date" class="form-control" onfocus="(this.type = 'date')" placeholder="من تاريخ">
                </div>
                <div class="col">
                    <input type="text" name="to_date" class="form-control" onfocus="(this.type = 'date')" placeholder="إلى تاريخ">
                </div>
                <div class="col">
                    <button class="btn btn-success bg-success border-success" type="submit">فلترة</button>
                    <button id="clearFilters" class="btn btn-danger bg-danger border-danger" type="reset">الغاء الفلترة</button>
                </div>
                <div class="col d-flex justify-content-end">
                    <a type="button"  class="btn col" href="{{route('client.transfers')}}">حوالاتي</a>
                    <button class="btn mx-2" id="printTable">
                        <i class="fa-solid fa-print"></i>
                    </button>
                    <!-- <a href="{{ route('transfers.export') }}"> <button class="btn border"  style="margin-right: 10px;">
                        <i class="fa-solid fa-download"></i>
                    </button></a> -->
                </div>
            </div>
        </form>
        <div class="row my-4">
            <div class="col">
                <strong class="ms-5"><span class="p-2 txt">مجموع عدد الحوالات</span> <span class="value p-2" id="transferCount">{{$countTransfer}}</span></strong>
                <strong class="ms-5"><span class="p-2 txt">مجموع قيمة الحوالات</span> <span class="value p-2" id="totalAmount">{{$totalMount}}</span></strong>
            </div>
        </div>
        @if($transfers->isEmpty())
            <p class="text-center fs-3 text-danger mt-5">لا توجد بيانات</p>
        @else
        <table class="table" id="dataTable">
            <thead>
            <tr>
                <th>رقم العملية</th>
                <th>نوع العملية</th>
                <th>المبلغ</th>
                <th>تاريخ التحويل</th>
                <th>اسم المحول</th>
                <th>البنك</th>
                <th>رقم حساب العميل</th>
                <th>مصدر الحوالة</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transfers as $transfer)
                <tr data-id="{{$transfer->id}}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$transfer->type->name}}</td>
                    <td>{{$transfer->mount}}</td>
                    <td>{{$transfer->dateTransfer}}</td>
                    <td>{{$transfer->sender->name}}</td>
                    <td>{{$transfer->bank->name}}</td>
                    <td>{{$transfer->numberAccount}}</td>
                    <td>{{$transfer->receiver->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>


    <style>
        /* إضافة الأنماط المطلوبة بالـ CSS */
        th{
            border-radius: 4px;
            border: 1px solid limegreen;
            text-align: center;
        }
        td{
            border-radius: 4px;
            border: 1px solid #e1e1e1;
            text-align: center;
            vertical-align: middle;

        }
        table {
            border-collapse: separate;
            border-spacing: 10px 10px;
        }
        .txt, .btn{
            border: 2px solid #A45EE5;
            border-radius: 4px;
        }
        .value{
            border: 2px solid limegreen;
            border-radius: 4px;
        }
        .btn:hover{
            background: #A45EE5;
            color: white;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var hasAlertOpened = false;
            $('#filterForm').submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("transfer.filter") }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        var transfers = response.transfers;
                        if(transfers.length > 0){
                            // Clear the existing table data
                            $('#dataTable tbody').empty();

                            // Append the filtered data to the table
                            $.each(transfers, function (index, transfer) {
                                var newRow = '<tr data-id="' + transfer.id + '">' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + transfer.type.name + '</td>' +
                                    '<td>' + transfer.mount + '</td>' +
                                    '<td>' + transfer.dateTransfer + '</td>' +
                                    '<td>' + transfer.sender.name + '</td>' +
                                    '<td>' + transfer.bank.name + '</td>' +
                                    '<td>' + transfer.numberAccount + '</td>' +
                                    '<td>' + transfer.receiver.name + '</td>' +
                                    // Add other columns here
                                    '</tr>';

                                $('#dataTable tbody').append(newRow);
                            });
                        }
                        else{
                            $('#dataTable tbody').html('<tr><td colspan="9" class="text-center fs-3 text-danger mt-5">لا توجد بيانات</td></tr>');
                        }
                        $('#transferCount').text(response.countTransfer);
                        $('#totalAmount').text(response.totalMount);
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' - ' + error);
                    }
                });

            });
            $('#clearFilters').click(function () {
                fetchAllData();
            });
            function fetchAllData() {
                $.ajax({
                    url: '{{ route("all.data") }}', // Replace with the appropriate route for fetching all data
                    type: 'GET',
                    success: function (response) {
                        if(response.transfers.length > 0){
                            // Clear the existing table data
                            $('#dataTable tbody').empty();
                            $.each(response.transfers, function (index, transfer) {
                                var newRow = '<tr data-id="' + transfer.id + '">' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + transfer.type.name + '</td>' +
                                    '<td>' + transfer.mount + '</td>' +
                                    '<td>' + transfer.dateTransfer + '</td>' +
                                    '<td>' + transfer.sender.name + '</td>' +
                                    '<td>' + transfer.bank.name + '</td>' +
                                    '<td>' + transfer.numberAccount + '</td>' +
                                    '<td>' + transfer.receiver.name + '</td>' +
                                    '</tr>';
                                $('#dataTable tbody').append(newRow);
                            });
                        }
                        else {
                            $('#dataTable tbody').html('<tr><td colspan="9" class="text-center fs-3 text-danger mt-5">لا توجد بيانات</td></tr>');
                        }
                        $('#transferCount').text(response.countTransfer);
                        $('#totalAmount').text(response.totalMount);
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' - ' + error);
                    }
                });
            }

            $('#update-btn').on("click",function (){
                $('#dataTable tbody tr').each(function (){
                    var recordId = $(this).data("id");
                    var currentStatus = $(this).find(".status-select").val();
                    $.ajax({
                        type: "POST",
                        url: "/updateStatus",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id : recordId,
                            status : currentStatus
                        },
                        success : function (response){
                            if (!hasAlertOpened && response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'تم الحفظ بنجاح',
                                });
                                hasAlertOpened = true;
                                setTimeout(function() {
                                    hasAlertOpened = false;
                                }, 3000); // Set the variable to true to prevent displaying the message again
                            }
                        },
                        error: function (error){
                            console.error("Error updating status: " + error);
                        },
                    })

                })
            })

            $("#addBankBtn").on("click", function() {
                $("#addBankModal").modal("show");
            });
            $("#saveBankBtn").on("click", function() {
                $.ajax({
                    type: "POST",
                    url: "/save-bank",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $("#bankName").val(),
                        national_id: $("#nationalId").val()
                    },
                    success: function (response) {
                        if (response.errors) {
                            if (response.errors.name) {
                                $("#bankNameError").text('اسم البنك مطلوب');
                            }
                            else {
                                $("#bankNameError").text('');
                            }
                            if (response.errors.national_id) {
                                $("#nationalIdError").text('الرقم التعريفي مطلوب');
                            }
                            else {
                                $("#nationalIdError").text('');
                            }
                        } else {
                            console.log(response.message);
                            $(".error-message").text("");
                            $("#addBankModal").modal("hide");
                            $("#addBankForm")[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'تم الحفظ بنجاح',
                            });
                        }
                    },
                    error: function (error) {
                        console.error("Error saving bank: " + error);
                    }
                });
            });
            $("#closeSaveBank").on("click", function (){
                $("#addBankModal").modal("hide");
                $(".error-message").text("");
                $("#addBankForm")[0].reset();
            })

            $("#addTypeBtn").on("click", function() {
                $("#addTypeModal").modal("show");
            });
            $("#saveTypeBtn").on("click", function() {
                $.ajax({
                    type: "POST",
                    url: "/save-type",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $("#typeName").val(),
                    },
                    success: function (response) {
                        if (response.errors) {
                            if (response.errors.name) {
                                $("#typeNameError").text('اسم العملية مطلوب ');
                            }
                            else {
                                $("#typeNameError").text('');
                            }
                        } else {
                            console.log(response.message);
                            $(".error-message").text("");
                            $("#addTypeModal").modal("hide");
                            $("#addTypeForm")[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'تم الحفظ بنجاح',
                            });
                        }
                    },
                    error: function (error) {
                        console.error("Error saving Type: " + error);
                    }
                });
            });
            $("#closeSaveType").on("click", function (){
                $("#addTypeModal").modal("hide");
                $(".error-message").text("");
                $("#addTypeForm")[0].reset();
            })


            $('#printTable').click(function() {
                printTable();
            });
            function printTable() {
                var printWindow = window.open('', '_blank');
                var tableContent = $('#dataTable').clone();
                printWindow.document.open();
                printWindow.document.write('<html><head><title>Print Table</title></head><body>');
                printWindow.document.write(tableContent.prop('outerHTML'));
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            }

            $(".open").on("click", function() {
                var icon = $(this).find("i");
                if (icon.hasClass("fa-circle-chevron-down")) {
                    icon.removeClass("fa-circle-chevron-down").addClass("fa-circle-chevron-up");
                } else {
                    icon.removeClass("fa-circle-chevron-up").addClass("fa-circle-chevron-down");
                }
                $("#filterForm").toggle();
            });
        });
    </script>
@endsection
