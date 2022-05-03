<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Simple Sidebar - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/cssmarc.css" rel="stylesheet" />
    <style>
        #sidebar-wrapper {
            background-color: #303769;
        }

        .list-group-item {
            background-color: #303769;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end " id="sidebar-wrapper">
            
            <!--roba di marcelo-->
            <div class="list-group list-group-flush">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 shadow-lg min-vh-100 sticky-top">
                    <a href="/" class="d-flex justify-content-center my-3 mx-auto">
                        <img src="http://mensa.marceloschneider.dev.br/public/storage/img/logo.png" alt="logo" class="img-thumbnail bg-transparent p-0 m-0 border-0 d-none d-sm-block" style="max-width: 100px;">
                        <img src="http://mensa.marceloschneider.dev.br/public/storage/img/logo.png" alt="logo" class="img-thumbnail bg-transparent p-0 m-0 border-0 d-block d-sm-none" style="max-width: 35px;">
                    </a>
                    <ul class="nav nav-pills flex-column mb-auto mb-0 align-items-center align-items-sm-start w-100">
                        <li class="nav-item py-2 w-100">
                            <a href="admin/calendario" class="nav-link align-middle px-0 bg-white bg-ch-white-hover text-c-blue-dark">
                                <i class="bi bi-calendar mx-2 h5"></i>
                                <span class="mx-2 d-none d-sm-inline">Calendario</span>
                            </a>
                        </li>
                        <li class="nav-item py-2 w-100">
                            <a href="admin/piatti" class="nav-link align-middle px-0 bg-ch-blue-light-purple-hover text-white">
                                <i class="bi bi-cloud-fog mx-2 h5"></i>
                                <span class="mx-2 d-none d-sm-inline ms-2">Piatti</span></a>
                        </li>
                        <li class="nav-item py-2 w-100">
                            <a href="admin/piatti" class="nav-link align-middle px-0 bg-ch-blue-light-purple-hover text-white">
                                <i class="bi bi-cloud-fog mx-2 h5"></i>
                                <span class="mx-2 d-none d-sm-inline ms-2">Ingredienti</span></a>
                        </li>
                    </ul>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-0 align-items-center align-items-sm-start w-100">
                        <li class="nav-item py-2 w-100"><a href="#" class="nav-link align-middle px-0 bg-ch-blue-light-purple-hover text-white"><i class="bi bi-box-arrow-right mx-2 h5"></i><span class="ms-1 d-none d-sm-inline ms-2">Logout</span></a></li>
                    </ul>
                </div>
                
                <!-- vecchio template
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Dashboard</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Shortcuts</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Overview</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Events</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Profile</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Status</a> -->
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Link</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#!">Action</a>
                                    <a class="dropdown-item" href="#!">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#!">Something else here</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="container-fluid">
                <h1 class="mt-4">Simple Sidebar</h1>
                <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
                <p>
                    Make sure to keep all page content within the
                    <code>#page-content-wrapper</code>
                    . The top navbar is optional, and just for demonstration. Just create an element with the
                    <code>#sidebarToggle</code>
                    ID which will toggle the menu when clicked.
                </p>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>