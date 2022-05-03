<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mensa</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Datatables-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/cssmarc.css" rel="stylesheet" />
    <!-- Bootstrap-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <!-- jquery UI-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!--<link rel="stylesheet" href="../resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <!-- -->
    <!-- Bootstrp icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        #sidebar-wrapper {
            background-color: #303769;
        }

        .list-group-item {
            background-color: #303769;
        }


        #button-newIngredient {
            background-color: #303769;
        }

        /* https://jsfiddle.net/zinoui/3LfE2/ */
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            font-size: 1em;
        }

        .ui-draggable,
        .ui-droppable {
            background-position: top;
        }
    </style>
    <?php include_once('../auth/session.php'); ?>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end " id="sidebar-wrapper">
            <?php include_once('../sidebar/sidebar.php');   ?>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <?php include_once('../navbar/navbar.php');   ?>

            <!-- Page content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <p class='h2 text-c-silver-dark fw-bold'>Gestione ingredienti</p>
                        <p class='h5 text-c-silver-ligth'>Visualizza la lista degli ingredienti registrati</p>
                    </div>
                    <div class="col-md-4 offset-md-4 ">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#ModalPost" aria-controls="ModalPost" aria-expanded="false" aria-label="new pippo" id="button-newIngredient">Nuovo ingrediente
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
                                <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434L7.752.066ZM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567L4.25 7.504ZM7.5 9.933l-2.75 1.571v3.134l2.75-1.571V9.933Zm1 3.134 2.75 1.571v-3.134L8.5 9.933v3.134Zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567-2.742 1.567Zm2.242-2.433V3.504L8.5 5.076V8.21l2.75-1.572ZM7.5 8.21V5.076L4.75 3.504v3.134L7.5 8.21ZM5.258 2.643 8 4.21l2.742-1.567L8 1.076 5.258 2.643ZM15 9.933l-2.75 1.571v3.134L15 13.067V9.933ZM3.75 14.638v-3.134L1 9.933v3.134l2.75 1.571Z" />
                            </svg> </button>

                    </div>
                </div>
                <div class='row'>
                    <div class="col-xl-12 my-2">
                        <div class="card bg-transparent border-0">
                            <div class="card-header d-flex justify-content-start align-items-center text-white bg-c-blue-light-purple shadow rounded mb-1">
                                <p class="m-0">Ingredienti</p>
                            </div>
                            <div class="card-body bg-white shadow rounded mt-1">

                                <div class="table-responsive" id='griglia_riepilogo'>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



        </div>
        <!-- Modal POST-->
        <div class="modal fade" id="ModalPost" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header d-flex border-0">
                        <div class="d-flex justify-content-center w-100">
                            <h5 class="modal-title text-c-silver-dark" id="ingredienti-list-label">
                                Lista Ingredienti
                            </h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body border-0">
                        <p><?php //echo $_SESSION['nome'] . "" . $_SESSION['cognome_utente'] . "";  
                            ?></p>
                        <form id='formIngrediente'>
                            <div class="list-group m-2">
                                <div class="list-group-item d-flex p-0 w-100 bg-white">
                                    <div class="input-group w-100">
                                        <input type='hidden' name='action' value='post'>
                                        <input type='text' name='nomeIngrediente' class="form-control bg-transparent border-0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group m-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="allergene" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Allergene
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end p-1">
                                <button type="submit" class="btn bg-c-blue-bright text-white">
                                    Inserisci
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span id='result'></span>
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal" id='closemodal'>Chiude</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal PUT-->
        <div class="modal fade" id="ModalPut" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header d-flex border-0">
                        <div class="d-flex justify-content-center w-100">
                            <h5 class="modal-title text-c-silver-dark" id="ingredienti-list-label">
                                Modifica Ingrediente
                            </h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body border-0">
                        <p><?php // echo $_SESSION['nome'] . "" . $_SESSION['cognome_utente'] . "";  
                            ?></p>
                        <form id='formIngredientePut'>
                            <div class="list-group m-2">
                                <div class="list-group-item d-flex p-0 w-100 bg-white">
                                    <div class="input-group w-100">
                                        <input type='hidden' name='action' value='put'>
                                        <input type='hidden' name='id_ingrediente' id='id_ingrediente' value=''>
                                        <!-- il valore viene assegnato quando clicco sul bottone che fa vedere la modale-->
                                        <input type='text' name='nomeIngrediente' id='nomeIngrediente' class="form-control bg-transparent border-0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group m-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="allergene" id='allergene'>
                                    <label for='allergene'>Allergene</label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end p-1">
                                <button type="submit" class="btn bg-c-blue-bright text-white">
                                    Modifica
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span id='resultmod'></span>
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal" id='closemodal'>Chiude</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>
        <script>
            $(document).ready(function() {
                $('#ingredienti').DataTable();
                $('#griglia_riepilogo').load('griglia.php'); //primo caricamento
                $("#formIngrediente").on("submit", function(event) {
                    event.preventDefault();
                    var formValues = $(this).serialize();
                    $.post("action.php", formValues, function(data) {
                        $("#result").html(data);
                        $('#griglia_riepilogo').load('griglia.php');
                    });
                });
                $("#formIngredientePut").on("submit", function(event) {
                    event.preventDefault();
                    var formValues = $(this).serialize();
                    console.log(formValues);
                    $.post("action.php", formValues, function(data) {
                        $("#result").html(data);
                        $('#griglia_riepilogo').load('griglia.php');
                    });
                });
                $('#griglia_riepilogo').on('click', '.modificaIngrediente', function() {
                    var idingrediente = $(this).val();
                    $('#id_ingrediente').val(idingrediente);
                    $.post('action.php', {
                        id_ingrediente: idingrediente,
                        action: 'getById'
                    }, function(data) {
                        var id_ingrediente;
                        var ingrediente;
                        var allergene;
                        console.log(data[0]['allergene']);
                        if (data[0]['allergene'] == "on") {
                            allergene = true
                        } else {
                            allergene = false
                        }
                        $('#nomeIngrediente').val(data[0]['ingrediente']);
                        $('#allergene').prop('checked', allergene);
                    }, 'json');
                });
                $('#griglia_riepilogo').on('click', '.eliminaIngrediente', function() {
                    var idingrediente = $(this).val();
                    var mielimini = confirm('Sei sicuro di voler eliminare questo ingrediente');
                    if (mielimini === true) {
                        $.post('action.php', {
                            id_ingrediente: idingrediente,
                            action: 'delete'
                        }, function(data) {
                            alert(data);
                            $('#griglia_riepilogo').load('griglia.php');
                        });
                    } else {
                        alert('Azione annullata');
                    }
                });
            });
        </script>
</body>

</html>