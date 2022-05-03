<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mensa</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/cssmarc.css" rel="stylesheet" />
    <!-- Bootstrap-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Vue Js 3 -->
    <script src="https://unpkg.com/vue@3"></script>
    <!-- Bootstrp icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>

<body class="bg-c-white-cold">
    <div id="app">
        <header class="d-flex justify-content-between p-1 bg-c-white w-100">
            <div class="d-flex align-items-center mx-5 p-2">
                <img src="../img/logo.png" alt="logo" class="img-thumbnail bg-transparent p-0 mx-2 my-0 border-0 d-none d-sm-block" style="max-width: 80px" />
                <h4 class="mx-2 my-0 p-0 text-c-blue-dark">Prenotazione mensa</h4>
            </div>
        </header>
        <section>
            <!-- calendar navigation -->
            <div class="d-flex flex-column p-3">
                <div class="d-flex justify-content-center align-items-center">
                    <button type="button" @click="previous_month()" class="mx-4 border-0 rounded-circle d-flex justify-content-center align-items-center" :class="true ? 'bg-c-orange bg-ch-orange-hover text-white' : 'text-c-silver-dark'" style="width: 30px; height: 30px">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <div class="d-flex flex-column align-items-center mx-4 text-c-silver-dark" style="width: 200px">
                        <p class="h4">{{ current_date }}</p>
                    </div>
                    <button type="button" @click="next_month()" class="mx-4 border-0 bg-c-orange bg-ch-orange-hover text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 30px; height: 30px">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
            <!-- calendar display -->
            <div class="row d-flex justify-content-center m-0 mb-5 p-0 ">
                <div class="col-8 shadow bg-c-silver">
                    <div class="row border-top border-start">
                        <div class="col  d-flex justify-content-center align-items-center">
                            <p class="text-c-silver-dark  m-0 p-0">Domenica</p>
                        </div>
                        <div class="col  d-flex justify-content-center align-items-center">
                            <p class="text-c-silver-dark  m-0 p-0">Lunedì</p>
                        </div>
                        <div class="col  d-flex justify-content-center align-items-center">
                            <p class="text-c-silver-dark  m-0 p-0">Martedì</p>
                        </div>
                        <div class="col  d-flex justify-content-center align-items-center">
                            <p class="text-c-silver-dark  m-0 p-0">Mercoledì</p>
                        </div>
                        <div class="col  d-flex justify-content-center align-items-center">
                            <p class="text-c-silver-dark  m-0 p-0">Giovedì</p>
                        </div>
                        <div class="col  d-flex justify-content-center align-items-center">
                            <p class="text-c-silver-dark  m-0 p-0">Venerdì</p>
                        </div>
                        <div class="col border-end d-flex justify-content-center align-items-center h-100">
                            <p class="text-c-silver-dark  m-0 p-2">Sabato</p>
                        </div>
                    </div>
                    <div class="row border-top border-start" v-for="(week, week_key) in days_by_week" :key="week_key">
                        <div class="col border-botton border-end p-0" v-for="(day, day_key) in week" :key="day_key">
                            <div
                                v-if="day"
                                class="d-flex align-items-center mb-5 w-100 h-100"
                                :class="setCalendarClass(day.date, day.has_order, day.has_consumazione, day.disabled)"
                            >
                                <p
                                    class="d-flex h-100 align-items-start m-0 p-2 fw-bold"
                                    :class="today > day.date || day.has_order ? 'text-white' : 'text-c-silver-dark'"
                                >
                                    {{ day.date.getDate() }}
                                </p>
                                <div class="d-flex justify-content-end align-items-end m-0 p-0 w-100 h-100 " v-if="!(day.date.getDay() == 0 || day.date.getDay() == 6)">
                                    <i
                                        class="h4 m-0 p-2 bi  text-c-silver-dark"
                                        :class="day.has_order ? 'bi-eye text-white' : 'd-none'"
                                        @click="set_piatti_giorno(day.date, day.has_order, day.has_takeaway, false)" data-bs-toggle="modal" data-bs-target="#prenotazione"
                                    ></i>
                                    <i
                                        class="h4 m-0 p-2 bi  text-c-silver-dark"
                                        :class="day.has_order ? 'bi-pencil text-white' : 'bi-plus-circle'"
                                        v-if="today <= day.date && !day.disabled"
                                        @click="set_piatti_giorno(day.date, day.has_order, day.has_takeaway, true)" data-bs-toggle="modal" data-bs-target="#prenotazione"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row border-top">
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal prenotazione -->
        <div class="modal fade" id="prenotazione" data-bs-backdrop="static" tabindex="-1" aria-labelledby="prenotazioneLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prenotazioneLabel">Prenotazione mensa</h5>
                        <button type="button" class="btn mx-1" :class="message.text ? 'btn-success' : 'btn-warning'" data-bs-dismiss="modal">
                            {{ message.text ? "OK" : "CHIUDI" }}
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- select dishes of day -->
                        <div class="row justify-content-center my-3 rounded-3" v-if="current_day_formated">
                            <div class="col-12">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-8 d-flex justify-content-center bg-white">
                                        <p class="h5 m-0 px-0 py-3 text-c-silver-dark">
                                            {{ current_day_formated }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card border-0 rounded-3 bg-white">
                                    <div class="card-body border-0 rounded-3 bg-white">
                                        <button type="button" class="d-flex justify-content-center w-100 border-0 rounded-3 m-0 p-3" :class="!takeaway && takeaway != null ? 'text-white bg-c-blue-dark' : 'text-white bg-c-silver-ligth'" @click="edit_piatti ? get_piatti_giorno(0) : null">Mensa</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card border-0 rounded-3 bg-white">
                                    <div class="card-body border-0 rounded-3 bg-white">
                                        <button class="d-flex justify-content-center w-100 border-0 rounded-3 m-0 p-3" :class="takeaway && takeaway != null ? 'text-white bg-c-blue-dark' : 'text-white bg-c-silver-ligth'" @click="edit_piatti ? get_piatti_giorno(1) : null">Take away</button>
                                    </div>
                                </div>
                            </div>
                            <!-- available dishes -->
                            <div class="col-6" v-if="Object.values(this.piatti).length">
                                <div class="py-4">
                                    <div class="card border-0 rounded-3 bg-white">
                                        <div class="d-flex justify-content-center">
                                            <p class="h6 m-0 p-0 text-c-silver-dark">Menu del giorno</p>
                                        </div>
                                        <div class="col-12 p-2" v-for="(tipologia, piatti_key) in piatti" :key="piatti_key">
                                            <div class="card-header d-flex align-items-center border-0 rounded-3 bg-white" @click="switch_tipologia(tipologia.id_tipologia)">
                                                <i v-if="tipologia.id_tipologia == 1" class="badge d-block rounded-pill bg-c-green me-2"></i>
                                                <i v-else-if="tipologia.id_tipologia == 2" class="badge d-block rounded-pill bg-c-red-dark me-2"></i>
                                                <i v-else-if="tipologia.id_tipologia == 3" class="badge d-block rounded-pill bg-c-yellow me-2"></i>
                                                <i v-else-if="tipologia.id_tipologia == 4" class="badge d-block rounded-pill bg-c-blue-light me-2"></i>
                                                <i v-else-if="tipologia.id_tipologia == 5" class="badge d-block rounded-pill bg-c-blue-dark me-2"></i>
                                                <i v-else class="badge d-block rounded-pill bg-c-silver me-2"></i>
                                                <h5 class="card-title m-0 p-0 text-c-silver-dark">{{ tipologia.tipologia }}</h5>
                                                <i class="bi mx-3 text-c-silver-dark" :class="tipologia.show_tipologia && edit_piatti ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                                            </div>
                                            <div class="card-body border-0 rounded-3 bg-white" v-if="tipologia.show_tipologia && edit_piatti">
                                                <ul class="list-group list-group-flush ">
                                                    <li class="list-group-item rounded p-1" :class="piatto.selected ? 'border-c-orange' : 'border-c-muted'" v-for="(piatto, piatto_key) in tipologia.piatti" :key="piatto_key">
                                                        <div class="d-flex justify-content-between w-100">
                                                            <div class="d-flex flex-column w-100 p-2">
                                                                <div class="d-flex align-items-center" @click="piatto.show_allergene = !piatto.show_allergene">
                                                                    <span class="m-1 text-c-silver-dark">
                                                                        {{ piatto.id_piatto }}.
                                                                    </span>
                                                                    <span class="m-1 text-c-orange">
                                                                        {{ piatto.piatto }}
                                                                    </span>
                                                                    <i class="bi bi-asterisk mx-1 text-danger" v-if="piatto.ingredienti.length"></i>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <span class="my-0 mx-1  p-0 fst-italic" :class="piatto.selected ? 'text-c-silver-ligth' : 'text-c-silver-dark'" v-if="piatto.show_allergene">
                                                                        <span v-for="(ingredienti, ingredienti_key) in piatto.ingredienti" :key="ingredienti_key">
                                                                            {{ ingredienti.ingrediente }}
                                                                            <span v-if="ingredienti_key != (piatto.ingredienti.length - 1)">, </span>
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <button type="button" @click="piatto.selected = true" class="btn bg-c-blue-bright text-white d-flex align-items-center my-1" v-if="edit_piatti">
                                                                    <i class="bi m-0 p-0 h5" :class="piatto.selected ? 'bi-check-lg' : 'bi-plus-lg'"></i>
                                                                </button>
                                                            </div>
                                                            <input class="d-none" type="checkbox" :id="'piatto_' + piatto.id_piatto" :value="piatto.id_piatto" v-model="piatto.selected" v-if="edit_piatti">
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- selected dishes -->
                            <div class="col-6" v-if="Object.values(this.piatti).length">
                                <div class="sticky-top py-4">
                                    <div class="card border-0 rounded-3 bg-white">
                                        <div class="d-flex justify-content-center">
                                            <p class="h6 m-0 p-0 text-c-silver-dark">Piatti Scelti</p>
                                        </div>
                                        <form @submit.prevent="save_piatti()">
                                            <div class="col-12 p-2" v-for="(tipologia, piatti_key) in piatti" :key="piatti_key">
                                                <div class="card-header d-flex align-items-center border-0 rounded-3 bg-white">
                                                    <i v-if="tipologia.id_tipologia == 1" class="badge d-block rounded-pill bg-c-green me-2"></i>
                                                    <i v-else-if="tipologia.id_tipologia == 2" class="badge d-block rounded-pill bg-c-red-dark me-2"></i>
                                                    <i v-else-if="tipologia.id_tipologia == 3" class="badge d-block rounded-pill bg-c-yellow me-2"></i>
                                                    <i v-else-if="tipologia.id_tipologia == 4" class="badge d-block rounded-pill bg-c-blue-light me-2"></i>
                                                    <i v-else-if="tipologia.id_tipologia == 5" class="badge d-block rounded-pill bg-c-blue-dark me-2"></i>
                                                    <i v-else class="badge d-block rounded-pill bg-c-silver me-2"></i>
                                                    <h5 class="card-title m-0 p-0 text-c-silver-dark">{{ tipologia.tipologia }}</h5>
                                                </div>
                                                <div class="card-body border-0 rounded-3 bg-white">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item rounded" :class="piatto.selected ? 'p-1 border-c-muted' : 'm-0 p-0 border-0'" v-for="(piatto, piatto_key) in tipologia.piatti" :key="piatto_key">
                                                            <div class="d-flex justify-content-between w-100" v-if="piatto.selected">
                                                                <div class="d-flex w-100">
                                                                    <p class="mx-1 my-0 p-0 text-c-silver-dark">
                                                                        {{ piatto.id_piatto }}.
                                                                    </p>
                                                                    <p class="m-0 p-0 text-c-orange">
                                                                        {{ piatto.piatto }}
                                                                    </p>
                                                                </div>
                                                                <label :for="'selected_piatto_' + piatto.id_piatto" class="btn bg-c-red-dark text-white d-flex align-items-center" v-if="edit_piatti">
                                                                    <i class="bi bi-dash-lg m-0 p-0 h5"></i>
                                                                </label>
                                                                <input class="d-none" type="checkbox" :id="'selected_piatto_' + piatto.id_piatto" :value="piatto.id_piatto" v-model="piatto.selected" v-if="edit_piatti">
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-12 p-2 d-flex">
                                                <div class="card-body border-0 rounded-3 bg-white">
                                                    <input type="hidden" id="consummation-status" name="consummation-status" v-model="consumazione">
                                                    <div class="d-flex mb-3" v-if="selected_piatti.length && takeaway">
                                                        <label class="d-flex p-2" for="note-takeaway">Nota:</label>
                                                        <input type="text" id="note-takeaway" name="note-takeaway" class="form-control" placeholder="Lascia una nota" :disabled="!edit_piatti" v-model="note_takeaway">
                                                    </div>
                                                    <div class="input-group mb-1" v-if="selected_piatti.length && !takeaway">
                                                        <div class="input-group-text w-100">
                                                            <input class="form-check-input mt-0" id="primo-turno" name="turno" type="radio" value="1" :disabled="!edit_piatti && !takeaway" v-model="turno">
                                                            <label class="mx-2 w-100 d-flex" for="primo-turno">Primo turno</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-1" v-if="selected_piatti.length && !takeaway">
                                                        <div class="input-group-text w-100">
                                                            <input class="form-check-input mt-0" id="secondo-turno" name="turno" type="radio" value="2" :disabled="!edit_piatti && !takeaway" v-model="turno">
                                                            <label class="mx-2 w-100 d-flex" for="secondo-turno">Secondo turno</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-1" v-if="selected_piatti.length && !takeaway">
                                                        <div class="input-group-text w-100">
                                                            <input class="form-check-input mt-0" id="terzo-turno" name="turno" type="radio" value="3" :disabled="!edit_piatti && !takeaway" v-model="turno">
                                                            <label class="mx-2 w-100 d-flex" for="terzo-turno">Terzo turno</label>
                                                        </div>
                                                    </div>
                                                    <div class="alert alert-danger p-2" role="alert" v-if="forma_message && !turno">
                                                        Selezionare una delle opzioni
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 p-2 d-flex mb-3">
                                                <p class="fst-italic">I piatti scelti non rispettano i <a data-bs-toggle="modal" data-bs-target="#rules-dishes" data-bs-dismiss="modal" class="text-decoration-none fw-bold text-dark">criteri aziendali per la composizione del pasto</a></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- message there isn't dishes -->
                            <div class="col-12" v-if="edit_piatti && piatti.length == 0">
                                <div class="card border-0 rounded-3 bg-white">
                                    <div class="card-body border-0 rounded-3 bg-white">
                                        <p class="d-flex justify-content-center w-100 text-c-blue-ligth-bright bg-c-silver-blue m-0 p-3">Nessun menu per questa data</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn mx-1" :class="message.text ? 'btn-success' : 'btn-warning'" data-bs-dismiss="modal">
                            {{ message.text ? "OK" : "CHIUDI" }}
                        </button>
                        <button type="button" class="btn bg-danger text-white mx-1" v-if="current_day_has_order && edit_piatti && !message.text && today <= current_day" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#eliminare">
                            ELIMINARE
                        </button>
                        <button type="button" class="btn btn-success mx-1" @click="save_piatti()" v-if="selected_piatti.length && edit_piatti && !message.text" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#alert-message">
                            PRENOTA
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal alert message -->
        <div class="modal fade" id="alert-message" data-bs-backdrop="static" tabindex="-1" aria-labelledby="alert-message-Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alert-message-Label">Alert message</h5>
                        <button type="button" class="btn mx-1" :class="message.text ? 'btn-success' : 'btn-warning'" data-bs-dismiss="modal">
                            {{ message.text ? "OK" : "CHIUDI" }}
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center my-3 rounded-3" v-if="message.text">
                            <div class="col-8">
                                <div class="alert alert-dismissible fade show" :class="message.class" role="alert">
                                    <strong>{{ message.text }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn mx-1" :class="message.text ? 'btn-success' : 'btn-warning'" data-bs-dismiss="modal">
                            {{ message.text ? "OK" : "CHIUDI" }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal delete confirmation -->
        <div class="modal fade" id="eliminare" tabindex="-1" aria-labelledby="eliminareLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-5">
                        <p>Vuoi veramente eliminare?</p>
                        <button type="button" class="btn btn-warning me-1" data-bs-target="#prenotazione" data-bs-toggle="modal" data-bs-dismiss="modal">Annulla</button>
                        <button type="button" class="btn btn-danger ms-1" data-bs-target="#alert-message" data-bs-toggle="modal" data-bs-dismiss="modal" @click="clear_date()">Eliminare</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal roles dishes -->
        <div class="modal fade" id="rules-dishes" data-bs-backdrop="static" tabindex="-1" aria-labelledby="rules-dishes-label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rules-dishes-label">Criteri composizione pasto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item" v-for="(rules, rules_key, index) in rules_dishes" :key="index">
                                <h2 class="accordion-header" :id="`heading${index}`">
                                    <button class="accordion-button" :class="rules_key == 'Composizione del pasto (regole aziendali).' ? '' : 'collapsed'" type="button" data-bs-toggle="collapse" :data-bs-target="`#collapse${index}`" :aria-controls="`collapse${index}`" aria-expanded="rules_key == 'Composizione del pasto (regole aziendali).' ? 'true' : 'false'">
                                        {{index + 1}}. {{rules_key}}
                                    </button>
                                </h2>
                                <div :id="`collapse${index}`" class="accordion-collapse collapse" :class="rules_key == 'Composizione del pasto (regole aziendali).' ? 'show' : ''" :aria-labelledby="`heading${index}`" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div v-for="(rule, rule_key) in rules" :key="rule_key">
                                            <ul class="list-group list-group-numbered border-0 mb-3" v-if="typeof(rule) == 'object'">
                                                <li class="list-group-item border-0" v-for="(item, item_key) in rule.list_items" :key="item_key">
                                                    {{item}}
                                                </li>
                                            </ul>
                                            <p v-else>{{rule}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-target="#prenotazione" data-bs-toggle="modal" data-bs-dismiss="modal">Accetta tutto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
    <!-- Vue js -->
    <script>
        Vue.createApp({
            data() {
                return {
                    id_user: 1,
                    today: new Date(),
                    current_month: new Date().getMonth(),
                    current_year: new Date().getFullYear(),
                    dates_with_orders: [],
                    piatti: {},
                    current_day: null,
                    current_day_has_order: false,
                    edit_piatti: false,
                    message: {
                        text: null,
                        class: null
                    },
                    takeaway: null,
                    consumazione: 0,
                    turno: null,
                    note_takeaway: '',
                    id_prenotazione: null,
                    forma_message: false,
                    rules_dishes: {},
                    rule: false,
                    desabled_dates: [],
                }
            },
            methods: {
                get_dates_with_orders() {
                    this.get_desabled_dates();
                    let firstDay = this.formatDate(this.firstDay);
                    let lastDay = this.formatDate(this.lastDay);
                    let formdata = new FormData();
                    formdata.append("action", "datesWithOrders");
                    formdata.append("id_utente", this.id_user);
                    formdata.append("firstDay", firstDay);
                    formdata.append("lastDay", lastDay);
                    let requestOptions = {
                        method: 'POST',
                        body: formdata,
                    };
                    fetch("action.php", requestOptions)
                        .then(response => response.json())
                        .then(result => {
                            let dates = [];
                            result.datesWithOrders.forEach(date => {
                                dates.push({
                                    giorno: new Date(Date.parse(date.giorno)),
                                    takeaway: Number(date.takeaway),
                                    consumazione: Number(date.consumazione),
                                });
                            });
                            this.dates_with_orders = dates
                        })
                        .catch(error => console.log('error', error));
                },
                previous_month() {
                    if (this.current_month == 0) {
                        this.current_month = 11
                        this.current_year--
                    } else {
                        this.current_month--
                    }
                    this.get_dates_with_orders()
                },
                next_month() {
                    if (this.current_month == 11) {
                        this.current_month = 0
                        this.current_year++
                    } else {
                        this.current_month++
                    }
                    this.get_dates_with_orders()
                },
                formatDate(date) {
                    return `${date.getFullYear()}-${date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1 }-${date.getDate() < 10 ? '0' + date.getDate() : date.getDate() }`;
                },
                set_piatti_giorno(day, has_order, takeaway, edit_piatti) {
                    this.edit_piatti = edit_piatti
                    this.id_prenotazione = null
                    this.current_day = day
                    this.current_day_has_order = has_order
                    this.takeaway = takeaway
                    this.message.text = null
                    this.message.class = null
                    this.turno = null
                    this.note_takeaway = ''
                    this.id_prenotazione = null
                    if (this.takeaway !== null) {
                        this.get_piatti_giorno(this.takeaway)
                    } else {
                        this.piatti = {}
                    }
                    
                },
                get_piatti_giorno(takeaway) {
                    this.forma_message = false
                    this.takeaway = takeaway
                    this.note_takeaway = ''
                    this.turno = null
                    let formdata = new FormData();
                    formdata.append("action", "getAllPiatti");
                    formdata.append("id_utente", this.id_user);
                    formdata.append("giorno", this.formatDate(this.current_day));
                    formdata.append("takeaway", this.takeaway);
                    let requestOptions = {
                        method: 'POST',
                        body: formdata,
                    };
                    fetch("action.php", requestOptions)
                        .then(response => response.json())
                        .then(result => {
                            this.current_day_has_order = result.has_order
                            if (result.piatti) {
                                if (result.has_order) {
                                    this.id_prenotazione = Number(result.prenotazione.id)
                                    if (takeaway) {
                                        this.note_takeaway = result.prenotazione.note_takeaway
                                        this.turno = null
                                    } else {
                                        this.note_takeaway = ''
                                        this.turno = Number(result.prenotazione.turno)
                                        if (this.turno == 0) {
                                            this.turno = null
                                        }
                                    }
                                }
                                this.piatti = result.piatti
                            } else {
                                this.piatti = []
                            }
                        })
                        .catch(error => console.log('error', error));
                },
                save_piatti() {
                    if ((this.turno == null || this.turno == 0) && !this.takeaway) {
                        this.forma_message = true;
                        return
                    }
                    this.forma_message = false;
                    let formdata = new FormData();
                    formdata.append("action", "save-prenotazione");
                    if (this.id_prenotazione) {
                        formdata.append("id_prenotazione", this.id_prenotazione);
                    }
                    formdata.append("id_utente", this.id_user);
                    formdata.append("giorno", this.formatDate(this.current_day));
                    formdata.append("takeaway", this.takeaway);
                    formdata.append("note_takeaway", this.note_takeaway);
                    formdata.append("turno", this.turno);
                    formdata.append("consumazione", this.consumazione);
                    this.selected_piatti.forEach(piatto_data => {
                        formdata.append("piatti_data[]", piatto_data.id_piatto);
                    });
                    let requestOptions = {
                        method: 'POST',
                        body: formdata,
                    };
                    fetch("action.php", requestOptions)
                        .then(response => response.json())
                        .then(result => {
                            this.current_day = null
                            this.message.text = result
                            this.message.class = 'alert-success'
                            this.get_dates_with_orders()
                        })
                        .catch(error => console.log('error', error));
                },
                // cancel_changes() {
                    // let date_data = this.dates_with_orders.find((day) => {
                    //     return day.giorno.getDate() == this.current_day.getDate()
                    // })
                    // date_data != undefined ? this.takeaway = date_data.takeaway : null;
                    // this.get_piatti_giorno(this.takeaway);
                    // this.note_takeaway = ''
                    // this.turno = null
                    // if (this.current_day_has_order) {
                    //     this.edit_piatti = false
                    // }
                // },
                clear_date() {
                    let formdata = new FormData();
                    formdata.append("action", "delete-prenotazione");
                    formdata.append("id_utente", this.id_user);
                    formdata.append("id_prenotazione", this.id_prenotazione);
                    let requestOptions = {
                        method: 'POST',
                        body: formdata,
                    };
                    fetch("action.php", requestOptions)
                        .then(response => response.json())
                        .then(result => {
                            this.current_day = null
                            this.message.text = result
                            this.message.class = 'alert-success'
                            this.get_dates_with_orders()
                        })
                        .catch(error => console.log('error', error));
                },
                remove_selected_dishe(key) {
                    if (this.edit_piatti) {
                        this.piatti[key].selected = null
                    }
                },
                switch_tipologia(id) {
                    Object.values(this.piatti).map((tipologia) => {
                        if (tipologia.id_tipologia == id) {
                            tipologia.show_tipologia = !tipologia.show_tipologia
                            return tipologia
                        } else {
                            tipologia.show_tipologia = false
                            return tipologia
                        }
                    })
                },
                get_rules_dishes() {
                    let requestOptions = {
                        method: 'GET',
                    };
                    fetch("rules-dishes.json", requestOptions)
                        .then(response => response.json())
                        .then(result => {
                            this.rules_dishes = result
                        })
                        .catch(error => console.log('error', error));
                },
                setCalendarClass(date, has_order, has_consumazione, disabled) {
                    if (disabled) return 'bg-c-silver-ligth'
                    if (this.today > date) {
                        if (has_order) {
                            if (has_consumazione) {
                                return 'bg-c--past-consumed'
                            }
                            return 'bg-c--past-not-consumed'
                        }
                        return 'bg-c-silver-ligth'
                    } else {
                        if (has_order) {
                            return 'bg-c--future-booked'
                        }
                        if (!(date.getDay() == 0 || date.getDay() == 6)) {
                            return 'bg-c-silver'
                        }
                        return 'bg-c-silver-ligth'
                    }
                },
                get_desabled_dates(){
                    let firstDay = this.formatDate(this.firstDay);
                    let lastDay = this.formatDate(this.lastDay);
                    var formdata = new FormData();
                    formdata.append("action", "getDesabledDates");
                    formdata.append("firstDay", firstDay);
                    formdata.append("lastDay", lastDay);
                    var requestOptions = {
                        method: 'POST',
                        body: formdata,
                    };
                    fetch("action.php", requestOptions)
                        .then(response => response.json())
                        .then(result => {
                            this.desabled_dates = result.desabledDates.map(({disabled_date}) => new Date(Date.parse(disabled_date)))
                        })
                        .catch(error => console.log('error', error));
                }
            },
            computed: {
                current_date() {
                    let options = {
                        year: 'numeric',
                        month: 'long',
                    };
                    return this.firstDay.toLocaleDateString('it-IT', options)
                },
                current_day_formated() {
                    if (!this.current_day) {
                        return null
                    }
                    let options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        weekday: 'long',
                    };
                    return this.current_day.toLocaleDateString('it-IT', options)
                },
                firstDay() {
                    return new Date(this.current_year, this.current_month, 1);
                },
                lastDay() {
                    return new Date(this.current_year, this.current_month + 1, 0);
                },
                empty_days() {
                    return this.firstDay.getDay()
                },
                days_by_week() {
                    let month_days = [];
                    let month_week = [];
                    for (month_days, dt = new Date(this.firstDay); dt <= this.lastDay; dt.setDate(dt.getDate() + 1)) {
                        let calendar_date = new Date(dt)
                        // date_has_order
                        let date_has_order = this.dates_with_orders.find(({
                            giorno
                        }) => giorno.getDate() == calendar_date.getDate())
                        if (date_has_order != undefined) {
                            date_has_order = true
                        } else {
                            date_has_order = false
                        }
                        // date_disabled
                        let date_disabled = this.desabled_dates.find((giorno) => giorno.getDate() == calendar_date.getDate())
                        if (date_disabled != undefined) {
                            date_disabled = true
                        } else {
                            date_disabled = false
                        }
                        // has_consumazione and has_takeaway
                        let has_consumazione = null;
                        let has_takeaway = null;
                        this.dates_with_orders.find((order_date) => {
                            if (order_date.giorno.getDate() == calendar_date.getDate()) {
                                has_takeaway = order_date.takeaway
                                has_consumazione = order_date.consumazione
                            }
                        })
                        month_days.push({
                            date: calendar_date,
                            has_order: date_has_order,
                            has_takeaway: has_takeaway,
                            has_consumazione: has_consumazione,
                            disabled: date_disabled,
                        });
                    }
                    for (let index = 0; index < this.empty_days; index++) {
                        month_days.unshift(null)
                    }
                    for (let index = 0; index <= (46 - month_days.length); index++) {
                        month_days.push(null)
                    }
                    calendar_rows = (month_days.length) / 7
                    for (let index = 0; index < calendar_rows; index++) {
                        let start = 7 * index
                        let end = 7 * (index + 1)
                        month_week.push(
                            month_days.slice(start, end)
                        )
                    }
                    return month_week;
                },
                selected_piatti() {
                    let selected_dishes = [];
                    Object.values(this.piatti).map(({
                        id_tipologia,
                        piatti
                    }) => {
                        Object.values(piatti).map(({
                            id_piatto,
                            selected
                        }) => {
                            if (selected) {
                                selected_dishes.push({
                                    id_tipologia: id_tipologia,
                                    id_piatto: id_piatto
                                });
                            }
                        })
                    })
                    return selected_dishes
                },
            },
            beforeMount() {
                this.get_dates_with_orders();
                this.get_rules_dishes();
                console.log('version:w23qwe3');
            },
        }).mount('#app')
    </script>
</body>

</html>