<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/color.css') }}">
    <style>
      
      .dropdown-menu{
        position: absolute !important;
        transform: translateX(-10%) translateY(5%);
      }

      .active{
        background-color: #997AFC;
        color: white !important;

      }
      .opacity-1{
        opacity: 0.9;
      }
    </style>
    @yield('style')
  </head>

  <body class="dark-shadow">
    <nav class="navbar navbar-dark fixed-top dark flex-md-nowrap py-3 opacity-1 ">
      <div class="relative w-25 form-inline justify-content-center search-bar">
        <form action="@yield('action')" method="GET">
            <span><i class="fas fa-lg fa-search"></i></span>
            <input class=" search form-control form-control-no-border form-control-sm w-75 justify-content-center mx-2" type="text" name="search" placeholder="Search" aria-label="Search">
        </form>
       
      </div>

      <ul class="navbar-nav px-3 mx-5">
        <li class="nav-item text-nowrap dropdown">
          <a class="text-dark nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  v-pre>
            <i class="fas  fa-lg  fa-user mx-2"></i> {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href={{ route('users.edit') }}>Profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </div>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row dark-gradient">
        <nav class="col-md-2 d-none d-md-block sidebar lavender">
          <div class="sidebar-sticky pt-0">
            <div class="d-block py-3 text-center text-white border-bottom pb-3 border-purple" style="transform :translateY(11%)" >
              <h5>Laravel Bank</h5>
            </div>

            <ul class="nav mt-5 flex-column">
              <li class="nav-item item mb-3 mx-2">
                <a class="nav-link text-purple" href="/home">
                  <i class="fas fa-home mx-1"></i> <span class="mx-3">Home</span>
                </a>
              </li>
              <li class="nav-item item mx-2 mb-3" id="data">
                <a class="nav-link sidebar-menu text-purple" href="#data">
                  <i class="fas  fa-users mx-1"></i> <span class="mx-3">Master Data</span> 
                </a>
                <div class="sub-menu">
                  @can('isAdmin')
                    <a href={{ route('users.index') }}>Data User</a>
                  @endcan
                  <a href={{route('member.index')}}>Data Anggota</a>
                  <a href={{route('masterInterest.index')}}>Data Bunga</a>
                  <a href="">Data Jenis Transaksi</a>
                </div>
              </li>
              <li class="nav-item item mx-2 mb-3" id="transaksi">
                <a class="nav-link sidebar-menu text-purple" href="#transaksi">
                  <i class="fas  fa-hand-holding-usd mx-1"></i> <span class="mx-3">Master Transaksi</span> 
                </a>
                <div class="sub-menu">
                  <a href={{route('deposit.index')}}>Transaksi</a>
                  <a href={{route('calculationInterest.index')}}>Perhitungan Bunga</a>
                </div>
              </li>
              <li class="nav-item item mx-2 mb-3" id="report">
                <a class="nav-link sidebar-menu text-purple" href="#report">
                  <i class="fas  fa-hand-holding-usd mx-1"></i> <span class="mx-3">Master Report</span>
                </a>
                <div class="sub-menu">
                  <a href="">Report Nasabah</a>
                  <a href="">Report Harian</a>
                  <a href={{route('weeklyReport.index')}}>Report Mingguan</a>
                  <a href={{route('monthlyReport.index')}}>Report Bulanan</a>
                  <a href={{route('annualReport.index')}}>Report Tahun</a>
                </div>
              </li>
            </ul>

          </div>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 bg-main">
            @yield('content')
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    @yield('script')
  </body>
</html>
