<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./index.css">        
    </head>
    <script defer = "defer" src = "./index.js"></script>
    <body>
        <div class="list-container">
            <header>
                <form id="list-form">

                    <div class="list-form__add-item">
                        <input
                            type="text"
                            id="add-item__input"
                            required="required"
                            autofocus="autofocus">
                        <input type="submit" value="✚">
                    </div>

                    <div class="list-form__search-item">
                        <input type="search" id="search-item__input">
                        <label for="search-item__input">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </label>
                    </div>
                </form>
            </header>

            <section>
                <ul class="to-do-list"></ul>

                <hr>

                <ul class="finished-list"></ul>
            </section>

            <div class="text-center">
                <a href="https://github.com/EastSun5566" target="_blank">
                    <i class="fa fa-github" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </body>
</html>