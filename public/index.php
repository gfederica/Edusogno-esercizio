<?php

include_once '../public/db/DB_CONFIG.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.7.3/dist/css/uikit.min.css" />
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Edusogno Test</title>
</head>
<body>
    <header>
        <nav class="uk-margin" uk-navbar>
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo" href="#">
                    <img src="https://edusogno.com/wp-content/uploads/edusogno/logo/logo-v4-2.svg" alt="logo edusogno">
                </a>
            </div>
        </nav>
    </header>

    <main>
        <div class="uk-container">
            <h3>Registrati al portale per partecipare agli eventi</h3>
            <div class="uk-flex uk-flex-center">
                <form class="uk-width-1-3 form-style uk-margin-top" action="db/DB_UPDATE_NOMI.php" method="post">
                    <fieldset class="uk-fieldset">

                        <legend class="uk-legend">Registrati:</legend>
                        <div class="uk-margin">
                            <div class="uk-inline">
                                <span class="uk-form-icon" href="#" uk-icon="icon: user"></span>
                                <input class="uk-input" id="form-stacked-text" type="text" name="nome" placeholder="Nome">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <div class="uk-inline">
                                <span class="uk-form-icon" href="#" uk-icon="icon: user"></span>
                                <input class="uk-input" id="form-stacked-text" type="text" name="cognome" placeholder="Cognome">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <div class="uk-inline">
                                <span class="uk-form-icon" href="#" uk-icon="icon: mail"></span>
                                <input class="uk-input" id="form-stacked-text" type="text" name="email" placeholder="Email">
                            </div>
                        </div>
                    
                    </fieldset>
                    <button class="uk-button">Invia</button>
                </form>

                <form class="uk-width-1-2 form-style uk-margin-top" action="db/DB_UPDATE_EVENTI.php" method="post">
                    <fieldset class="uk-fieldset">

                        <legend class="uk-legend">Gestione eventi</legend>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">Nome evento</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-stacked-text" type="text" name="nome_evento" placeholder="Nome evento">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">Descrizione evento</label>
                            <div class="uk-form-controls">
                                <textarea class="uk-textarea" name="descrizione_evento" placeholder="Descrizione evento"></textarea>
                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">Data</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-stacked-text" type="date" name="data" placeholder="Data">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">Ora</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-stacked-text" type="time" name="ora" placeholder="Ora">
                            </div>
                        </div>
                    
                    </fieldset>
                    <div class="buttons uk-flex ">
                        <button class="uk-button uk-width-1-2 uk-margin-right">Crea Evento</button>
                        <button class="uk-button uk-width-1-2" type="submit" formaction="../public/api/quickstart.php" formmethod="POST">Richiedi Info</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    
    <footer>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.3/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.3/dist/js/uikit-icons.min.js"></script>
</body>
</html>