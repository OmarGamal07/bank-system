@extends('layouts.app')
@section('title')
    Admin Dashboard
@endsection

@section('content')
    <div class="container mt-5">
        <form id="filterForm" method="GET" action="{{route('transfer.filter')}}">
            <div class="form row my-5">
                <div class="col">
                    <input type="text" name="from_date" class="form-control" onfocus="(this.type = 'date')" placeholder="من تاريخ">
                </div>
                <div class="col">
                    <input type="text" name="to_date" class="form-control" onfocus="(this.type = 'date')" placeholder="إلى تاريخ">
                </div>
                <div class="col">
                    <select class="form-control" name="client_name">
                        <option value="" selected disabled>اسم المستخدم</option>
                        <option value="الجميع">الجميع</option>
                        @foreach($clients as $client)
                            <option value="{{$client->name}}" {{old('client_name') === $client->name ? 'selected' : ''}}>{{$client->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="type_name">
                        <option value="" selected disabled> نوع العملية</option>
                        <option value="الجميع"> الجميع </option>
                        @foreach($types as $type)
                            <option value="{{$type->name}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="bank_name">
                        <option value="" selected disabled> البنك</option>
                        <option value="الجميع"> الجميع </option>
                        @foreach($banks as $bank)
                            <option value="{{$bank->name}}">{{$bank->name}} ({{$bank->nationalID}})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <button class="btn btn-success bg-success border-success" type="submit">فلترة</button>
                    <button id="clearFilters" class="btn btn-danger bg-danger border-danger" type="reset">الغاء الفلترة</button>
                </div>
            </div>
        </form>
        <div class="row mb-3">
            <div class="col">
                <strong class="ms-5"><span class="p-2 txt">مجموع عدد الحوالات</span> <span class="value p-2" id="transferCount">{{$countTransfer}}</span></strong>
                <strong class="ms-5"><span class="p-2 txt">مجموع قيمة الحوالات</span> <span class="value p-2" id="totalAmount">{{$totalMount}}</span></strong>
            </div>
            <div class="col d-flex justify-content-end">
                <button class="btn add">
                    اضافة بنك
                </button>
                <button class="btn add mx-2">
                    اضافة عملية
                </button>
                <button class="btn mx-2" id="printTable">
                    <i class="fa-solid fa-print"></i>
                </button>
                <button class="btn mx-2">
                    <i class="fa-solid fa-download"></i>
                </button>
            </div>
        </div>
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
                <th>قبول أو رفض</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transfers as $transfer)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$transfer->type->name}}</td>
                <td>{{$transfer->mount}}</td>
                <td>{{$transfer->dateTransfer}}</td>
                <td>{{$transfer->sender->name}}</td>
                <td>{{$transfer->bank->name}}</td>
                <td>{{$transfer->numberAccount}}</td>
                <td>{{$transfer->receiver->name}}</td>
                <td>
                    <select class="form-select border-0" id="status">
                        <option value="1" selected class="text-success">قبول</option>
                        <option value="2" class="text-danger">رفض</option>
                    </select>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <button class="btn border-primary bg-primary btn-primary w-100">حفظ</button>
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
            // Submit form using AJAX and fetch filtered data
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
                        // Clear the existing table data
                        $('#dataTable tbody').empty();

                        // Append the filtered data to the table
                        $.each(transfers, function (index, transfer) {
                            var newRow = '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + transfer.type.name + '</td>' +
                                '<td>' + transfer.mount + '</td>' +
                                '<td>' + transfer.dateTransfer + '</td>' +
                                '<td>' + transfer.sender.name + '</td>' +
                                '<td>' + transfer.bank.name + '</td>' +
                                '<td>' + transfer.numberAccount + '</td>' +
                                '<td>' + transfer.receiver.name + '</td>' +
                                '<td>' +
                                '<select class="form-select border-0" id="status' + index + '">' +
                                '<option value="1" selected class="text-success">قبول</option>' +
                                '<option value="2" class="text-danger">رفض</option>' +
                                '</select>' +
                                '</td>' +
                                // Add other columns here
                                '</tr>';

                            $('#dataTable tbody').append(newRow);
                        });
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
                        // Clear the existing table data
                        $('#dataTable tbody').empty();
                        $.each(response.transfers, function (index, transfer) {
                            var newRow = '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + transfer.type.name + '</td>' +
                                '<td>' + transfer.mount + '</td>' +
                                '<td>' + transfer.dateTransfer + '</td>' +
                                '<td>' + transfer.sender.name + '</td>' +
                                '<td>' + transfer.bank.name + '</td>' +
                                '<td>' + transfer.numberAccount + '</td>' +
                                '<td>' + transfer.receiver.name + '</td>' +
                                '<td>' +
                                '<select class="form-select border-0" id="status' + index + '">' +
                                '<option value="1" selected class="text-success">قبول</option>' +
                                '<option value="2" class="text-danger">رفض</option>' +
                                '</select>' +
                                '</td>' +
                                '</tr>';
                            $('#dataTable tbody').append(newRow);
                        });
                        $('#transferCount').text(response.countTransfer);
                        $('#totalAmount').text(response.totalMount);
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' - ' + error);
                    }
                });
            }
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
        });
    </script>
@endsection
