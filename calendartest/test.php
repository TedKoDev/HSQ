<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>
    <link rel = "stylesheet" type = "text/css" href = "test.css"/>
    <script type="module" defer="defer" src="./test.js"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <body class="bg-gray-100 w-full">
        <div class="sec_cal">
            <div class="cal_nav">
                <a href="javascript:;" class="nav-btn go-prev">prev</a>
                <div class="year-month"></div>
                <a href="javascript:;" class="nav-btn go-next">next</a>
            </div>
            <div class="cal_wrap">
                <div class="days">
                    <div class="day">MON</div>
                    <div class="day">TUE</div>
                    <div class="day">WED</div>
                    <div class="day">THU</div>
                    <div class="day">FRI</div>
                    <div class="day">SAT</div>
                    <div class="day">SUN</div>
                </div>
                <div class="dates"></div>
            </div>
        </div>
    </body>
</html>