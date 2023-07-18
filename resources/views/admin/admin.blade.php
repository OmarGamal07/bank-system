@extends('layouts.app')
@section('title')
    Admin Dashboard
@endsection

@section('content')
    <div class="container mt-5">
        <div class="form row my-5">
            <div class="col">
                <input type="text" class="form-control" onfocus="(this.type = 'date')" placeholder="من تاريخ">
            </div>
            <div class="col">
                <input type="text" class="form-control" onfocus="(this.type = 'date')" placeholder="إلى تاريخ">
            </div>
            <div class="col">
                <select class="form-control">
                    <option value="">اسم المستخدم</option>
                    <option value="user1">اسم المستخدم 1</option>
                    <option value="user2">اسم المستخدم 2</option>
                    <!-- أضف المزيد من الخيارات هنا -->
                </select>
            </div>
            <div class="col">
                <select class="form-control">
                    <option value=""> نوع العملية</option>
                    <option value="type1">نوع العملية 1</option>
                    <option value="type2">نوع العملية 2</option>
                    <!-- أضف المزيد من الخيارات هنا -->
                </select>
            </div>
            <div class="col">
                <select class="form-control">
                    <option value=""> البنك</option>
                    <option value="bank1">البنك 1</option>
                    <option value="bank2">البنك 2</option>
                    <!-- أضف المزيد من الخيارات هنا -->
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <strong class="ms-5"><span class="p-2 txt">مجموع عدد الحوالات</span> <span class="value p-2">10</span></strong>
                <strong class="ms-5"><span class="p-2 txt">مجموع قيمة الحوالات</span> <span class="value p-2">5000</span></strong>
            </div>
            <div class="col d-flex justify-content-end">
                <button class="btn add">
                    اضافة بنك
                </button>
                <button class="btn add mx-2">
                    اضافة عملية
                </button>
                <button class="btn mx-2">
                    <i class="fa-solid fa-print"></i>
                </button>
                <button class="btn mx-2">
                    <i class="fa-solid fa-download"></i>
                </button>
            </div>
        </div>
        <table class="table">
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
                <th>القبول</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>نوع العملية 1</td>
                <td>1000</td>
                <td>2023-07-18</td>
                <td>اسم المحول 1</td>
                <td>البنك 1</td>
                <td>1234567890</td>
                <td>مصدر الحوالة 1</td>
                <td>
                    <select class="form-select border-0" id="status">
                        <option value="1" selected class="text-success">قبول</option>
                        <option value="2" class="text-danger">رفض</option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
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
@endsection
