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
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <!-- Vue Js 3 -->
    <script src="https://unpkg.com/vue@3"></script>
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



        /* #feedback { font-size: 1.4em; }*/
        #selectable .ui-selecting {
            background: #FECA40;
        }

        #selectable .ui-selected {
            background: #eeeeee;
            color: black;
        }

        #selectable {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 60%;
        }

        #selectable li {
            margin: 1px;
            margin-left: 5px;
            padding: 0;
            height: 20px;
        }
    </style>
    <?php include_once('../auth/session.php'); ?>
</head>
<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);

include_once('../menu/menu_class.php');
$menu_collection = new menu_class(); //recupero dati principali
$menuFound = json_encode($menu_collection->getAll());
// echo "<pre>";
// print_r($menuFound);
// echo "</pre>";

?>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end " id="sidebar-wrapper">
            <?php include_once('../sidebar/sidebar.php'); ?>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <?php include_once('../navbar/navbar.php'); ?>

            <!-- Page content-->
            <div id="app">
                <section class="row p-2">
                    <!-- col left -->
                    <div class="col-xl-4 my-2">
                        <!-- add menu -->
                        <div class="card mb-4 bg-transparent border-0">
                            <div class="card-header d-flex justify-content-start align-items-center text-white bg-c-blue-light-purple shadow rounded mb-1">
                                <p class="m-0">Menu preconfigurati</p>
                            </div>
                            <div class="card-body bg-white shadow rounded mt-1">
                                <div class="list-group ">
                                    <div v-for="(dishes, key) in preset_dishes" :key="key" class="list-group-item list-group-item-action d-flex justify-content-between bg-white text-c-silver-dark ps-3 pe-0 py-0">
                                        <div class="d-flex align-items-center">
                                            <p class="m-0">{{ dishes.id }}.</p>
                                            <p class="m-0 ms-4 w-auto">{{ dishes.nome }}</p>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn bg-c-blue-bright text-white" @click="remove_menu_calendario(dishes.id)" v-if="added_menus.includes(dishes.id)">
                                                Togliere
                                            </button>
                                            <button type="button" class="btn bg-c-blue-bright text-white" @click="add_menu_calendario(dishes.id)" v-if="!added_menus.includes(dishes.id)">
                                                Aggiungere
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- dasable dates -->
                        <div class="card my-2 bg-transparent border-0">
                            <div class="card-header d-flex justify-content-start align-items-center text-white bg-c-blue-light-purple shadow rounded mb-1">
                                <p class="m-0">Disabilitare le date</p>
                            </div>
                            <div class="card-body bg-white shadow rounded mt-1">
                                <div class="mb-3">
                                    <label for="data-to-diasble" class="form-label" title="Selezionare una data per disabilitare nel calendario di prenotazione">Selezione una data</label>
                                    <input type="date" class="form-control" id="data-to-diasble" v-model="disable_date" aria-describedby="emailHelp">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn bg-c-blue-bright text-white" @click="disableDate()">Disabilitare</button>
                                </div>
                                <hr class="bg-danger border-2 border-top border-secondary my-2">
                                <div class="mt-3">
                                    <label class="form-label">Le date disabilitate</label>
                                </div>
                                <div class="list-group ">
                                    <div v-for="(disabled_date) in disableDates" :key="disabled_date.id" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-white text-c-silver-dark ps-3 pe-0 py-0">
                                        <p class="m-0 w-auto">{{ disabled_date.disabled_date }}</p>
                                        <button type="button" class="btn bg-c-blue-bright text-white" @click="removeDisableDate(disabled_date.disabled_date)">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- col rigth -->
                    <div class="col-xl-8 my-2">
                        <div class="card bg-transparent border-0">
                            <div class="card-header d-flex justify-content-between align-items-center text-white bg-c-blue-light-purple shadow rounded mb-1">
                                <p class="m-0">Calendario</p>
                                <div class="d-flex">
                                    <button @click="set_date(0)" class="btn mx-5 my-0 p-0 text-white">
                                        <p class="my-0 mx-2">Oggi</p>
                                    </button>
                                    <button @click="set_date_previous()" class="btn m-0 p-0 text-white">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <p class="my-0 mx-2" style="min-width: 150px">{{ display_date }}</p>
                                    <!-- <p class="my-0 mx-2">{{ manage_date }}</p> -->
                                    <!-- <input type="date" class="bg-transparent border-0 text-white" /> -->
                                    <button @click="set_date_next()" class="btn m-0 p-0 text-white">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body bg-white rounded shadow mt-1">
                                <div>
                                    <!-- date header -->
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <!-- <i class="bi bi-caret-down-fill py-2 text-c-silver-ligth"></i>
                                            <i class="bi bi-caret-up-fill py-2 text-c-silver-ligth"></i> -->
                                        </div>
                                    </div>
                                    <!-- date with dishes -->
                                    <div v-if="menu.length">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="badge d-block rounded-pill bg-c-green me-2"></i>
                                                    <p class="h5 my-0 mx-2 text-c-silver-dark">
                                                        Primi
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="badge d-block rounded-pill bg-c-red-dark me-2"></i>
                                                    <p class="h5 my-0 mx-2 text-c-silver-dark">
                                                        Secondi
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="badge d-block rounded-pill bg-c-yellow me-2"></i>
                                                    <p class="h5 my-0 mx-2 text-c-silver-dark">
                                                        Contorni
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="badge d-block rounded-pill bg-c-blue-light me-2"></i>
                                                    <p class="h5 my-0 mx-2 text-c-silver-dark">
                                                        Dolci
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" v-for="(menu, menu_key) in organized_menus" :key="menu_key">
                                            <div class="col-12">
                                                <p class="h6 mx-0 my-2 p-0 text-c-silver-dark">Menu: {{menu.nome}}</p>
                                            </div>
                                            <div class="col-3" v-for="(piatti, piatti_key) in menu.piatti" :keu="piatti_key">
                                                <div class="d-flex align-items-center" v-for="(piatto, piatto_key) in piatti" :keu="piatto_key">
                                                    <p class="m-0 p-1 text-c-silver-dark">{{piatto.id_piatto}}.</p>
                                                    <p class="m-0 p-1 text-c-silver-dark">{{piatto.nome}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" v-else>
                                        <div class="d-flex">
                                            <div class="w-100 mx-2">
                                                <button type="button" class="btn text-c-blue-ligth-bright bg-c-silver-blue p-3 w-100">
                                                    <p class="m-0 p-0">Nessun menu per questa data</p>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <script src="../js/scripts.js"></script>
        <script>
            Vue.createApp({
                data() {
                    return {
                        preset_dishes: <?php echo $menuFound ?>,
                        data_menu: null,
                        manage_date: 0,
                        date_value: null,
                        menu: [],
                        disable_date: null,
                        disableDates: [],
                    }
                },
                methods: {
                    add_menu_calendario(id) {
                        var formdata = new FormData();
                        formdata.append("action", "post");
                        formdata.append("id_menu", id);
                        formdata.append("giorno", this.date_value);
                        var requestOptions = {
                            method: 'POST',
                            body: formdata,
                        };
                        fetch("action.php", requestOptions)
                            .then(response => response.text())
                            .then(result => {
                                console.log(result)
                                this.get_menu_giorno()
                            })
                            .catch(error => console.log('error', error));
                    },
                    remove_menu_calendario(id) {
                        var formdata = new FormData();
                        formdata.append("action", "delete");
                        formdata.append("id_menu", id);
                        formdata.append("giorno", this.date_value);
                        var requestOptions = {
                            method: 'POST',
                            body: formdata,
                        };
                        fetch("action.php", requestOptions)
                            .then(response => response.text())
                            .then(result => {
                                console.log(result)
                                this.get_menu_giorno()
                            })
                            .catch(error => console.log('error', error));
                    },
                    set_date() {
                        this.manage_date = 0
                        this.data_menu = new Date();
                        this.date_value = `${this.data_menu.getFullYear()}-${this.data_menu.getMonth() + 1 < 10 ? '0' + (this.data_menu.getMonth() + 1) : this.data_menu.getMonth() + 1 }-${this.data_menu.getDate() < 10 ? '0' + this.data_menu.getDate() : this.data_menu.getDate() }`;
                        this.get_menu_giorno()
                    },
                    set_date_previous() {
                        this.manage_date++;

                        date = new Date()
                        let daysAgo = new Date(date.getTime());
                        daysAgo.setDate(date.getDate() - this.manage_date)
                        this.data_menu = daysAgo

                        this.date_value = `${this.data_menu.getFullYear()}-${this.data_menu.getMonth() + 1 < 10 ? '0' + (this.data_menu.getMonth() + 1) : this.data_menu.getMonth() + 1 }-${this.data_menu.getDate() < 10 ? '0' + this.data_menu.getDate() : this.data_menu.getDate() }`;
                        this.get_menu_giorno()
                    },
                    set_date_next() {
                        this.manage_date--;

                        date = new Date()
                        let daysAgo = new Date(date.getTime());
                        daysAgo.setDate(date.getDate() - this.manage_date)
                        this.data_menu = daysAgo

                        this.date_value = `${this.data_menu.getFullYear()}-${this.data_menu.getMonth() + 1 < 10 ? '0' + (this.data_menu.getMonth() + 1) : this.data_menu.getMonth() + 1 }-${this.data_menu.getDate() < 10 ? '0' + this.data_menu.getDate() : this.data_menu.getDate() }`;
                        this.get_menu_giorno()
                    },
                    get_menu_giorno() {
                        var formdata = new FormData();
                        formdata.append("action", "getAll");
                        formdata.append("giorno", this.date_value);
                        var requestOptions = {
                            method: 'POST',
                            body: formdata,
                        };
                        fetch("action.php", requestOptions)
                            .then(response => response.json())
                            .then(result => {
                                if (result.menu) {
                                    this.menu = result.menu
                                } else {
                                    this.menu = []
                                }
                            })
                            .catch(error => console.log('error', error));
                    },
                    getDisableDates() {
                        var formdata = new FormData();
                        formdata.append("action", "getDisableDates");
                        var requestOptions = {
                            method: 'POST',
                            body: formdata,
                        };
                        fetch("action.php", requestOptions)
                            .then(response => response.json())
                            .then(result => {
                                console.log(result);
                                this.disableDates = result.dates;
                            })
                            .catch(error => console.log('error', error));
                    },
                    disableDate() {
                        var formdata = new FormData();
                        formdata.append("action", "disableDate");
                        formdata.append("disabled_date", this.disable_date);
                        var requestOptions = {
                            method: 'POST',
                            body: formdata,
                        };
                        fetch("action.php", requestOptions)
                            .then(response => response.json())
                            .then(result => {
                                console.log(result);
                                this.getDisableDates();
                            })
                            .catch(error => console.log('error', error));
                    },
                    removeDisableDate(date_to_remove) {
                        var formdata = new FormData();
                        formdata.append("action", "removeDisableDate");
                        formdata.append("disabled_date", date_to_remove);
                        var requestOptions = {
                            method: 'POST',
                            body: formdata,
                        };
                        fetch("action.php", requestOptions)
                            .then(response => response.json())
                            .then(result => {
                                console.log(result);
                                this.getDisableDates();
                            })
                            .catch(error => console.log('error', error));
                    },
                },
                computed: {
                    display_date() {
                        let options = {
                            weekday: 'long',
                            month: 'long',
                            day: 'numeric'
                        };
                        return this.data_menu.toLocaleDateString('it-IT', options)
                    },
                    added_menus() {
                        return this.menu.map((menu) => menu.id_menu)
                    },
                    organized_menus() {
                        return this.menu.map((menu) => {
                            menu.piatti = menu.piatti.reduce((previous, current) => {
                                previous[current.tipologia.id] = previous[current.tipologia.id] || [];
                                previous[current.tipologia.id].push(current);
                                return previous;
                            }, Object.create(null));
                            return menu;
                        })
                    },
                },
                beforeMount() {
                    this.set_date(0);
                    this.getDisableDates();
                },
            }).mount('#app')
        </script>
</body>

</html>