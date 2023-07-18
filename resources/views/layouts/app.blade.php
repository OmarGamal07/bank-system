<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield('title')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body{
            font-family: 'Noto Kufi Arabic';
            background:#FAF9F6;
        }
        .navbar{
            background: #A45EE5;
        }
        .logo{
            width: 100px;
        }
        .navbar .navbar-nav .nav-link{
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img class="logo" alt="logo" src="{{asset('images/logo.png')}}">
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav w-100 d-flex justify-content-evenly">
                <a class="nav-link" href="#">العضويات</a>
                <a class="nav-link" href="#">اصدار عضوية جديدة</a>
                <a class="nav-link" href="#">الملف الشخصي</a>
                <a class="nav-link" href="#">التحقق من العضوية</a>
                <a class="nav-link" href="#">الشبكة الطبية</a>
                <a class="nav-link" href="#">المستخدمين</a>
                <a class="nav-link" aria-current="page" href="#">الايداعات</a>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="mt-2">
        @yield('content')
    </div>
</div>
</body>
</html>
