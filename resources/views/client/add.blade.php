@extends('layouts.app')
@section('title')
    Add Deposit
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mt-5">
        <button type="button" class="btn add border text-danger">
             عملية ايداع جديدة
            <i class="fa-solid fa-plus"></i>
        </button>
        <div>
            <button type="button" class="btn border">حوالاتي</button>
            <button class="btn border">
                <i class="fa-solid fa-print"></i>
            </button>
            <button class="btn border">
                <i class="fa-solid fa-upload"></i>
            </button>
            <button class="btn border">
                <i class="fa-solid fa-download"></i>
            </button>
        </div>
    </div>
    <div class="container d-flex justify-content-center mt-5">
    <form class="border p-4 rounded">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="operation-type" class="form-label">نوع العملية</label>
                <select class="form-select" id="operation-type">
                    <option selected>اختر...</option>
                    <option value="1">عملية 1</option>
                    <option value="2">عملية 2</option>
                    <option value="3">عملية 3</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="operation-number" class="form-label">رقم العملية</label>
                <input type="text" class="form-control" id="operation-number">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="transferrer-name" class="form-label">اسم المحول</label>
                <input type="text" class="form-control" id="transferrer-name">
            </div>
            <div class="col-md-6">
                <label for="amount" class="form-label">المبلغ</label>
                <input type="text" class="form-control" id="amount">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="transfer-date" class="form-label">تاريخ التحويل</label>
                <input type="date" class="form-control" id="transfer-date">
            </div>
            <div class="col-md-6">
                <label for="bank" class="form-label">البنك</label>
                <select class="form-select" id="bank">
                    <option selected>اختر...</option>
                    <option value="1">بنك 1</option>
                    <option value="2">بنك 2</option>
                    <option value="3">بنك 3</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="account-number" class="form-label">رقم حساب العميل</label>
                <input type="text" class="form-control" id="account-number">
            </div>
            <div class="col-md-6">
                <label for="source" class="form-label">مصدر الحوالة</label>
                <input type="text" class="form-control" id="source">
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
    </style>
@endsection
