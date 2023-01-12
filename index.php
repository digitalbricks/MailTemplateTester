<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail Template Tester</title>

    <link rel="stylesheet" href="mtt/css/uikit.min.css">
    <link rel="stylesheet" href="mtt/css/mtt.css">

</head>
<body>

    <header class="uk-background-muted uk-padding-small uk-flex uk-flex-between uk-flex-middle">

            <div class="apptitle">
                <abbr title="Mail Template Tester">MTT</abbr> <span>v1.0</span>
            </div>

            <div class="settings uk-flex">
                <div class="settings__item uk-margin-small-right">
                    <select class="uk-select">
                        <option>filename.html</option>
                    </select>
                </div>
                <div class="settings__item uk-flex">
                    <input class="uk-input" type="text" placeholder="E-Mail-Adresse">
                    <button class="uk-button uk-button-primary">Send</button>
                </div>
            </div>

            <div class="status uk-flex uk-flex-middle">
                <span class="status__text">Status</span>
                <span class="status__item status__item--success" title="not ready"></span>
                <span class="status__item status__item--error active" title="ready"></span>
            </div>


    </header>

    <main class="uk-padding">
        <div class="frameoptions uk-padding-small uk-text-center">
            <div id="framesize"><!-- updated via JS --></div>
        </div>

        <div class="uk-flex uk-flex-center">
            <div class="frameholder">
                <iframe id="preview" src="https://wikipedia.org/"></iframe>
            </div>
        </div>

    </main>


    <script src="mtt/js/uikit.min.js"></script>
    <script src="mtt/js/uikit-icons.min.js"></script>
    <script src="mtt/js/jquery-3.6.3.min.js"></script>
    <script src="mtt/js/mtt.js"></script>

</body>
</html>