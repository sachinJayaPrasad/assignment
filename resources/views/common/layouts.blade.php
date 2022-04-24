<!DOCTYPE html>
<html>
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>STUDENT MANAGEMENT SYSTEM</title>
    <style>
            .side-navbar {
                width: 250px;
                height: 100%;
                position: fixed;
                margin-left: -300px;
                background-color: #100901;
                transition: 0.5s;
            }
            .nav-link:active,
            .nav-link:focus,
            .nav-link:hover {
                background-color: #ffffff26;
            }
            .my-container {
                transition: 0.4s;
            }
            .active-nav {
                margin-left: 0;
            }
            /* for main section */
            .active-cont {
                margin-left: 180px;
            }
            #menu-btn {
                background-color: #100901;
                color: #fff;
                margin-left: -62px;
            }
            .content {
                background-color: white;
                padding: 10px;
            }
            .error {
                color: red;
                padding: 10px;
            }
            .modal { overflow: auto !important; }
        </style>
  </head>
  <body>
    <!-- Side-Nav -->
        <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar">
            <ul class="nav flex-column text-white w-100">
                <a href="#" class="nav-link h3 text-white">STUDENT MANAGEMENT SYSTEM </a>
                <a href="{{ url('') }}" class="nav-link text-white">
                    <i class="bx bx-user-check"></i> <span class="">STUDENTS</span>
                </a>
                <a href="{{ route('teacher_list') }}" class="nav-link text-white">
                    <i class="bx bxs-dashboard"></i> <span class="">TEACHERS</span>
                </a>
                <a href="{{ route('mark_list') }}" class="nav-link text-white">
                    <i class="bx bxs-dashboard"></i> <span class="">MARKS</span>
                </a>
            </ul>
        </div>
    <!-- Side-Nav -->   
    {{-- content --}}
    
        @yield('content')
    
    {{-- scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @yield('scripts')
  </body>
</html>