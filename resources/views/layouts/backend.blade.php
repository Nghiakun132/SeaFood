<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('backend/img/2.png') }}" type="image/x-icon">
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>
<style>
    .item-hover a {
        color: rgb(247, 246, 250) !important;
    }

    .item-hover:hover {
        background-color: #fff;
    }

    .item-hover:hover a {
        color: rgb(231, 6, 6) !important;
        font-weight: bold;
    }

    .item-hover:hover i {
        color: rgb(231, 6, 6) !important;
        font-weight: bold;
    }

</style>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
                <div class="sidebar-brand-text mx-3">
                    <img src="{{ asset('backend/img/2.png') }}" alt="">
                </div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item item-hover active">
                <a class="nav-link" href="{{ route('admin.home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item item-hover">
                <a class="nav-link" href="{{ route('admin.categories') }}" aria-expanded="true">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Danh m???c s???n ph???m</span>
                </a>
            </li>
            <li class="nav-item item-hover">
                <a class="nav-link" href="{{ route('admin.product') }}" aria-expanded="true">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>S???n ph???m</span>
                </a>
            </li>
            <li class="nav-item item-hover">
                <a class="nav-link" href="{{ route('admin.order') }}" aria-expanded="true">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>????n h??ng</span>
                </a>
            </li>

            <li class="nav-item item-hover">
                <a class="nav-link" href="{{ route('admin.import') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Nh???p h??ng</span></a>
            </li>
            <li class="nav-item item-hover">
                <a class="nav-link" href="{{ route('admin.comment') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>B??nh lu???n</span></a>
            </li>
            @if (Session::get('admins')->role == 2)
                <li class="nav-item item-hover">
                    <a href="{{route('admin.sales')}}" class="nav-link">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Gi???m gi?? (s???n ph???m)</span></a>
                    </a>
                </li>
                <li class="nav-item item-hover">
                    <a class="nav-link" href="{{ route('admin.staff') }}">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Nh??n vi??n</span></a>
                </li>
                <li class="nav-item item-hover">
                    <a class="nav-link" href="{{ route('admin.coupon') }}">
                        <i class="fas fa-fw fa-table"></i>
                        <span>M?? gi???m gi??</span></a>
                </li>
                <li class="nav-item item-hover">
                    <a class="nav-link" href="{{ route('admin.user') }}">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Kh??ch h??ng</span></a>
                </li>
                {{-- <li class="nav-item item-hover">
                    <a href="{{ route('admin.statistic') }}" class="nav-link">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Th???ng k??</span></a>
                    </a>
                </li> --}}
                {{-- gi???m gi?? s???n ph???m --}}
            @endif

            <li class="nav-item item-hover">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-table"></i>
                    <span>B??i vi???t</span></a>
            </li>
            <li class="nav-item item-hover">
                <a class="nav-link" href="{{ route('admin.notification') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Th??ng b??o</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    {{-- <form class="form-inline"> --}}
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    {{-- </form> --}}
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                @if ($countNoti > 3)
                                    <span class="badge badge-danger badge-counter">3+</span>
                                @else
                                    <span class="badge badge-danger badge-counter">{{ $countNoti }}</span>
                                @endif
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Th??ng b??o
                                </h6>
                                @foreach ($noti as $noti)
                                    @if ($noti->read == 0)
                                        <a class="dropdown-item d-flex align-items-center bg-warning"
                                            href="{{ route('admin.notification.read', $noti->id) }}">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">{{ $noti->created_at }}</div>
                                                <span class="font-weight-bold">{{ $noti->notification }}</span>
                                            </div>
                                        </a>
                                    @else
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('admin.order') }}">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">{{ $noti->created_at }}</div>
                                                <span class="font-weight-bold">{{ $noti->notification }}</span>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                                <a class="dropdown-item text-center small text-gray-500"
                                    href="{{ route('admin.notification') }}">Xem t???t c???</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <span class="badge badge-danger badge-counter">9999</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle"
                                            src="{{ asset('./backend/img/undraw_profile_1.svg') }}" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler ?? 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle"
                                            src="{{ asset('./backend/img/undraw_profile_2.svg') }}" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun ?? 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle"
                                            src="{{ asset('./backend/img/undraw_profile_3.svg') }}" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy
                                            with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez ?? 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because
                                            someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog ?? 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More
                                    Messages</a>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Session::get('admins')->name }}</span>
                                @if (Session::get('admins')->avatar != null)
                                    <img class="img-profile rounded-circle"
                                        src="{{ asset('./uploads/avatar/' . Session::get('admins')->avatar) }}">
                                @else
                                    <img class="img-profile rounded-circle"
                                        src="{{ asset('./uploads/avatar/default.png') }}">
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('admin.change_profile', Session::get('admins')->id) }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Th??ng tin
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    ????ng xu???t
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                @yield('content')
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">B???n mu???n tho??t</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">??</span>
                    </button>
                </div>
                <div class="modal-body">Ch???n "????ng xu???t" n???u b???n mu???n tho??t</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">H???y</button>
                    <a class="btn btn-primary" href="{{ route('admin.logout') }}">????ng xu???t</a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script>
        CKEDITOR.replace('editor1');
        CKEDITOR.replace('editor2');
        CKEDITOR.replace('editor3');
        CKEDITOR.replace('editor4');
    </script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/vi.json"
                }
            });
        });
    </script>

</body>

</html>
