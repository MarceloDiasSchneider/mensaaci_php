<!DOCTYPE html>
<html lang="en">
<?php

session_start();
require "../vendor/autoload.php";

use League\OAuth2\Client\Provider\Google;

/**
 * GOOGLE is an variable in source/Config file
 * Array that has the Google's Api Credentials
 */
$google = new Google(GOOGLE);
$authUrl = $google->getAuthorizationUrl();

if (!empty($_SESSION['user_data'])) {
    header("Location: ". URI['dashboard']);
    exit;
}

$google_auth_loged = false;

if (isset($_GET['state'])) {
    
    isset($_GET["error"]) ? $error = $_GET["error"] : $error = null;
    isset($_GET["code"]) ? $code = $_GET["code"] : $code = null;

    if ($error) {
        echo "<p>Error login with Google Auth</p>";
    }

    if ($code) {
        $token = $google->getAccessToken("authorization_code", [
            "code" => $code
        ]);
        $user_data = $google->getResourceOwner($token);
        $_SESSION["google_user_data"] = $user_data->toArray();
        header("Location: " . GOOGLE['redirectUri']);
        exit;
    }
}
if (!empty($_SESSION["google_user_data"])) {
    $google_auth_loged = true;
}
?>

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
    <style>
        .v-enter-active,
        .v-leave-active {
            transition: opacity 0.5s ease;
        }

        .v-enter-from,
        .v-leave-to {
            opacity: 0;
        }
    </style>
</head>

<body class="bg-c-white-cold">
    <div id="app">
        <nav class="navbar navbar-light bg-c-blue-dark p-0 m-0">
            <div class="container-fluid p-0 m-0">
                <a class="navbar-brand text-white p-0 mx-3 my-0 d-flex justify-content-center align-items-center" href="/">
                    <img src="../img/logo.png" alt="logo" width="140" class="p-2" />
                    <h1 class="h4 m-2 p-2">Mensa 0.2</h1>
                </a>
            </div>
        </nav>
        <section class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 p-4">
                    <div class="card">
                        <div class="card-header h3 text-muted d-flex align-items-center flex-column p-2">
                            <p>Esegui il Login</p>
                            <p>Nella piattaforma</p>
                        </div>
                        <div class="card-body">
                            <div class="m-2">
                                <!-- login -->
                                <form @submit.prevent="authenticate($event)" action="../calendario/" method="get" class="mb-4" v-show="login.show">
                                    <div class="form-group">
                                        <label for="email" class="mt-2">Email</label>
                                        <input type="email" class="form-control my-2" id="email" aria-describedby="emailHelp" placeholder="Inserisci la tua email" v-model="email" />
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="mt-2">Password</label>
                                        <input type="password" class="form-control my-2" id="password" placeholder="Password" v-model="password" />
                                    </div>
                                    <small id="loginHelp" class="form-text text-danger my-2">
                                        {{ login.message }}
                                    </small>
                                    <div class="row mt-4 mx-0">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Login
                                        </button>
                                    </div>
                                    <div class="row mt-4 mx-0">
                                        <a href="<?php echo $authUrl ?>" class="p-0 m-0">
                                            <button type="button" class="d-flex justify-content-between btn btn-white shadow text-primary btn-block w-100">
                                                <img src="../img/google.png" alt="logo google" class="logo-google" style="width: 25px">
                                                <span>
                                                    Continua con Google
                                                </span>
                                                <span style="width: 25px">
                                                </span>
                                            </button>
                                        </a>
                                    </div>
                                    <small id="loginHelp" class="form-text text-danger my-5">
                                        {{ login.message_google_auth }}
                                    </small>
                                </form>
                                <!-- recovery -->
                                <form @submit.prevent="recoveryAccount()" class="mb-4" v-show="recovery.show">
                                    <div class="form-group">
                                        <label for="email" class="mt-2">
                                            Email
                                        </label>
                                        <input type="email" class="form-control my-2" id="email" aria-describedby="emailHelp" placeholder="Inserisci la tua email" v-model="email" />
                                    </div>
                                    <small id="recoveryHelp" class="form-text text-danger my-2">
                                        {{ recovery.message }}
                                    </small>
                                    <div class="row mt-4 mx-0">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Ricevere un'e-mail
                                        </button>
                                    </div>
                                </form>
                                <!-- sigin -->
                                <form @submit.prevent="createAccount($event)" class="mb-4" v-show="sigin.show">
                                    <div class="form-group">
                                        <label for="name" class="mt-2">Nome</label>
                                        <input type="name" class="form-control my-2" id="name" aria-describedby="nameHelp" placeholder="Inserisci il tuo email" v-model="name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="mt-2">Email</label>
                                        <input type="email" class="form-control my-2" id="email" aria-describedby="emailHelp" placeholder="Inserisci la tua email" v-model="email" />
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="mt-2">Password</label>
                                        <input type="password" class="form-control my-2" id="password" placeholder="Password" v-model="password" />
                                    </div>
                                    <small id="siginHelp" class="form-text text-danger my-2">
                                        {{ sigin.message }}
                                    </small>
                                    <div class="row mt-4 mx-0">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Effetua la registrazione
                                        </button>
                                    </div>
                                </form>
                                <!-- divider -->
                                <div class="dropdown-divider"></div>
                                <!-- buttons -->
                                <div class="row mt-4 mx-0">
                                    <button @click="switchForm('login')" v-show="!login.show" type="submit" class="btn btn-block border border-primary text-primary my-2">
                                        Login
                                    </button>
                                    <button @click="switchForm('recovery')" v-show="!recovery.show" type="submit" class="btn btn-block border border-primary text-primary my-2">
                                        Recupera la password
                                    </button>
                                    <button @click="switchForm('sigin')" v-show="!sigin.show" type="submit" class="btn btn-block border border-primary text-primary my-2">
                                        Effetua la registrazione
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                    email: null,
                    password: null,
                    name: null,
                    login: {
                        show: true,
                        message: null,
                        message_google_auth: null,
                    },
                    recovery: {
                        show: false,
                        message: null,
                    },
                    sigin: {
                        show: false,
                        message: null,
                    },
                    uri_user: '<?php echo URI['dashboard']; ?>',
                };
            },
            methods: {
                switchForm(form) {
                    switch (form) {
                        case "login":
                            this.login.show = true;
                            this.recovery.show = false;
                            this.sigin.show = false;
                            break;
                        case "recovery":
                            this.login.show = false;
                            this.recovery.show = true;
                            this.sigin.show = false;
                            break;
                        case "sigin":
                            this.login.show = false;
                            this.recovery.show = false;
                            this.sigin.show = true;
                            break;
                    }
                },
                authenticate(e) {
                    let formdata = new FormData();
                    formdata.append("action", 'login');
                    formdata.append("email", this.email);
                    formdata.append("password", this.password);
                    let requestOptions = {
                        method: 'POST',
                        body: formdata,
                    };
                    fetch("action.php", requestOptions)
                        .then(response => response.json())
                        .then(response => {
                            this.login.message = null
                            if (response.auth == "success") {
                                e.target.submit()
                            }
                            if (response.auth == "error") {
                                this.login.message = response.message
                            }
                        })
                        .catch(error => {
                            console.log('error', error)
                        });
                },
                recoveryAccount() {
                    let data = new FormData();
                    data.append("email", this.email);
                    // call backend
                },
                createAccount(e) {
                    let data = new FormData();
                    data.append("name", this.name);
                    data.append("email", this.email);
                    data.append("password", this.password);
                    // call backend
                },
                google_auth_login(google_user_data) {
                    console.log(google_user_data);
                    let formdata = new FormData();
                    formdata.append("action", 'google_auth_login');
                    formdata.append("email", google_user_data.email);
                    formdata.append("google_sub_id", google_user_data.sub);
                    let requestOptions = {
                        method: 'POST',
                        body: formdata,
                    };
                    fetch("action.php", requestOptions)
                        .then(response => response.json())
                        .then(response => {
                            this.login.message = null
                            if (response.auth == "success") {
                                window.location.href = this.uri_user;
                            }
                            if (response.auth == "error") {
                                this.login.message_google_auth = response.message
                            }
                        })
                        .catch(error => {
                            console.log('error', error)
                        });
                }
            },
            computed: {

            },
            beforeMount() {
                <?php
                if ($google_auth_loged) {
                    echo 'this.google_auth_login(' . json_encode($_SESSION["google_user_data"]) . ')';
                }
                ?>
            },
        }).mount('#app')
    </script>
</body>

</html>