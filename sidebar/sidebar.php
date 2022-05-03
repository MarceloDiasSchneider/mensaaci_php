
            <!--roba di marcelo-->
            <div class="list-group list-group-flush">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 shadow-lg min-vh-100 sticky-top">
                    <a href="/" class="d-flex justify-content-center my-3 mx-auto">
                        <img src="../img/logo.png" alt="logo" class="img-thumbnail bg-transparent p-0 m-0 border-0 d-none d-sm-block" style="max-width: 100px;">
                        <img src="../img/logo.png" alt="logo" class="img-thumbnail bg-transparent p-0 m-0 border-0 d-block d-sm-none" style="max-width: 35px;">
                    </a>
                    <ul class="nav nav-pills flex-column mb-auto mb-0 align-items-center align-items-sm-start w-100">
                        <li class="nav-item py-2 w-100">
                            <a href="../calendario/" class="nav-link align-middle px-0 
                            <?php isselected('calendario') ?> 
                            ">
                                <i class="bi bi-calendar mx-2 h5"></i>
                                <span class="mx-2 d-none d-sm-inline">Calendario</span>
                            </a>
                        </li>
                        <li class="nav-item py-2 w-100">
                            <a href="../ingrediente/" class="nav-link align-middle px-0 
                            <?php isselected('ingrediente') ?>                           
                            
                            ">
                                <i class="bi bi-cloud-fog mx-2 h5"></i>
                                <span class="mx-2 d-none d-sm-inline ms-2">Ingredienti</span></a>
                        </li>
                        <li class="nav-item py-2 w-100">
                            <a href="../piatto/" class="nav-link align-middle px-0 <?php isselected('piatto') ?>">
                                <i class="bi bi-cloud-fog mx-2 h5"></i>
                                <span class="mx-2 d-none d-sm-inline ms-2">Piatti</span></a>
                        </li>
                        <li class="nav-item py-2 w-100">
                            <a href="../menu/" class="nav-link align-middle px-0 <?php isselected('menupiatti') ?>">
                                <i class="bi bi-cloud-fog mx-2 h5"></i>
                                <span class="mx-2 d-none d-sm-inline ms-2">Menu</span></a>
                        </li>
                        <li class="nav-item py-2 w-100">
                            <a href="../prenotazione/" class="nav-link align-middle px-0 <?php isselected('utente') ?>">
                                <i class="bi bi-cloud-fog mx-2 h5"></i>
                                <span class="mx-2 d-none d-sm-inline ms-2">Prenotazione</span></a>
                        </li>
                        <li class="nav-item py-2 w-100">
                            <a href="../auth/" class="nav-link align-middle px-0 <?php isselected('utente') ?>">
                                <i class="bi bi-cloud-fog mx-2 h5"></i>
                                <span class="mx-2 d-none d-sm-inline ms-2">Auth</span></a>
                        </li>
                        <li class="nav-item py-2 w-100">
                            <a href="../totem/" class="nav-link align-middle px-0 <?php isselected('utente') ?>">
                                <i class="bi bi-cloud-fog mx-2 h5"></i>
                                <span class="mx-2 d-none d-sm-inline ms-2">Totem</span></a>
                        </li>
                    </ul>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-0 align-items-center align-items-sm-start w-100">
                        <li class="nav-item py-2 w-100"><a href="../auth/logout.php" class="nav-link align-middle px-0 bg-ch-blue-light-purple-hover text-white"><i class="bi bi-box-arrow-right mx-2 h5"></i><span class="ms-1 d-none d-sm-inline ms-2">Logout</span></a></li>
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
<?php function isselected($matchdir){
    if(basename(getcwd()) ==$matchdir ) {
        //sto qui
        echo "bg-white bg-ch-white-hover text-c-blue-dark";
    }    
    else{
        echo "bg-ch-blue-light-purple-hover text-white";
       // echo getcwd();

    }
}