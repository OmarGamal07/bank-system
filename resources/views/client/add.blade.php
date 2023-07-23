@extends('layouts.app')
@section('title')
    Add Deposit
@endsection

@section('content')
    <div class="bg-info open d-flex align-items-baseline justify-content-between p-2">
        <span class="search-text fw-bold me-2">نموذج اضافة حوالة</span>
        <button class="btn search-button bg-info">
            <i class="fa-solid arrow fs-4 border-0 fa-circle-chevron-down"></i>
        </button>

    </div>
    <div class=" container custom-div" style="display: block;">
        <div class="d-flex custom-div justify-content-between align-items-center py-3">
            <a type="button" href="{{route('transfer.create')}}" class="btn add border text-danger">
                عملية ايداع جديدة
                <i class="fa-solid fa-plus"></i>
            </a>
            <div style="display: flex; align-items: center;">
    <!-- <a type="button" class="btn border" href="{{ route('client.transfers') }}">حوالاتي</a> -->
    @auth
    @if(auth()->user()->role === 'Admin')
        <a type="button" class="btn border" href="{{ route('transfer.index') }}">الحوالات</a>
    @else
        <a type="button" class="btn border" href="{{ route('client.transfers') }}">حوالاتي</a>
    @endif
@endauth
    <button class="btn border" style="margin-right: 10px;">
        <i class="fa-solid fa-print"></i>
    </button>
    <span style="flex: 1;margin-right: 10px;">
        <form id="importForm" action="{{ route('transfers.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="fileInput" class="custom-file-upload">
                <i class="fa-solid fa-upload"></i>
            </label>
            <input type="file" id="fileInput" name="file" class="form-control">
        </form>
    </span>
    <a href="{{ route('transfers.export') }}"> <button class="btn border"  style="margin-right: 10px;">
        <i class="fa-solid fa-download"></i>
    </button></a>
</div>

        </div>
    </div>

    <div class="container d-flex justify-content-center mt-5">
    <form method="POST" action="{{route('transfer.store')}}" class="border p-4 rounded">
        @csrf
        @method('POST')
        <div class="row mb-2">
            <div class="col-md-6">
                <label for="operation-type" class="form-label">نوع العملية</label>
                <select class="form-select {{ $errors->has('type_id') ? 'border border-danger' : '' }}" name="type_id" id="operation-type">
                    <option selected disabled>اختر...</option>
                    @foreach($types as $type)
                        <option value="{{$type->id}}" {{old('type_id') == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                    @endforeach
                </select>
                @error('type_id')
                     <p class="text-danger">*{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="operation-number" class="form-label">رقم العملية</label>
                <input type="text" name="numberOperation" class="form-control {{ $errors->has('numberOperation') ? 'border border-danger' : '' }}" id="operation-number" value="{{old('numberOperation')}}">
                @error('numberOperation')
                <p class="text-danger">*{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <label for="transferrer-name" class="form-label">اسم المحول</label>
                <input type="text" name="sender" class="form-control {{ $errors->has('sender') ? 'border border-danger' : '' }}" id="transferrer-name" value="{{old('sender')}}">
                @error('sender')
                <p class="text-danger">*{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="amount" class="form-label">المبلغ</label>
                <input type="text" name="mount" class="form-control {{ $errors->has('mount') ? 'border border-danger' : '' }}" id="amount" value="{{old('mount')}}">
                @error('mount')
                <p class="text-danger">*{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="transfer-date" class="form-label">تاريخ التحويل</label>
                <input type="date" name="dateTransfer" class="form-control {{ $errors->has('dateTransfer') ? 'border border-danger' : '' }}" id="transfer-date" value="{{old('dateTransfer')}}">
                @error('dateTransfer')
                <p class="text-danger">*{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="bank" class="form-label">البنك</label>
                <select name="bank_id" class="form-select {{ $errors->has('bank_id') ? 'border border-danger' : '' }}" id="bank">
                    <option selected disabled>اختر...</option>
                    @foreach($banks as $bank)
                        <option value="{{$bank->id}}" {{old('bank_id') == $bank->id ? 'selected' : ''}}>{{$bank->name}}</option>
                    @endforeach
                </select>
                @error('bank_id')
                <p class="text-danger">*{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <label for="account-number" class="form-label">رقم حساب العميل</label>
                <input type="text" name="numberAccount" class="form-control {{ $errors->has('numberAccount') ? 'border border-danger' : '' }}" id="account-number" value="{{old('numberAccount')}}">
                @error('numberAccount')
                    <p class="text-danger">*{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="source" class="form-label">مصدر الحوالة</label>
                <input type="text" name="receiver" class="form-control {{ $errors->has('receiver') ? 'border border-danger' : '' }}" id="source" value="{{old('receiver')}}">
                @error('receiver')
                <p class="text-danger">*{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">إضافة</button>
    </form>
    </div>

    <style>

        form{
            background: white;
        }
        .form-control,.form-select{
            border: none;
            border-bottom: 1px solid #A45EE5;
            transition: border-bottom-color 0.3s;
        }
        .btn:hover{
            background: #A45EE5;
            color: white;
        }
        /* Hide the default file input */
        input[type="file"] {
            display: none;
        }

        /* Style the custom button to look like a regular button */
        label.custom-file-upload {
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            padding: 6px 12px;
            cursor: pointer;
        }

        /* Optional: Add some hover effect */
        label.custom-file-upload:hover {
            background: #A45EE5;
            color: white;
        }
    </style>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".open").on("click", function() {
                var icon = $(this).find("i");
                if (icon.hasClass("fa-circle-chevron-down")) {
                    icon.removeClass("fa-circle-chevron-down").addClass("fa-circle-chevron-up");
                } else {
                    icon.removeClass("fa-circle-chevron-up").addClass("fa-circle-chevron-down");
                }
                $(".custom-div").toggle();
            });
        });
        $(document).ready(function () {
    // Listen for the change event on the file input
    $('#fileInput').on('change', function () {
        // Trigger form submission when a file is selected
        $('#importForm').submit();
    });
});
    </script>
@endsection
