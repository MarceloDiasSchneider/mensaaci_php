<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">
        <button class="btn btn-primary" id="sidebarToggle">Nascondi Menu</button>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <?php
                        if (isset($_SESSION['user_data']['first_name'])) {
                            echo $_SESSION['user_data']['first_name'];
                        } else {
                            echo 'Utente non loged in';
                        }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>