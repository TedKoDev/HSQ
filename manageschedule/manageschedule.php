<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>
    <script src="../commenJS/cookie.js"></script>
    <script defer="defer" src="./manageschedule.js"></script>
    <script>

        
        function test_click(event) {         
            
            let label_id = event.target.id;

            let label = document.getElementById(label_id+"_l");
           
            let result = "";
            if (event.target.checked) {
                result = event.target.value;                
                
                label.style.backgroundColor = 'red';
                
            } else {
                result = "0";

                label.style.backgroundColor = '#9CA3AF';
                
                console.log(result);
            }
        }
    </script>
    <body class="bg-gray-100">
        <!-- 네비바 -->
        <?php include '../components/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../components/navbar_t.php' ?>
        <br><br>
        <div
            class="flex flex-col justify-center max-w-3xl mx-auto bg-gray-50 shadow rounded-lg  "><br>
            <div class="mx-auto font-bold text-2xl mb-3">나의 일정</div>
            <div id="header_s" class="flex mx-auto"></div>
            <?php for ($i = 0; $i < 7; $i++) {
                    ?>
            <div id="body_s_<?php echo $i; ?>" class="flex mx-auto">
                <div class="flex flex-col">
                    <?php for ($j = 0; $j < 48; $j++) {
                        ?>
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id = "<?php echo $i; ?>_<?php echo $j; ?>"
                            name="A3-confirmation"
                            value="yes"
                            class="hidden"
                            onclick='test_click(event)'/>
                        <label
                            for="<?php echo $i; ?>_<?php echo $j; ?>"
                            id = "<?php echo $i; ?>_<?php echo $j; ?>_l"
                            class="px-3 py-1 mx-auto font-semibold bg-gray-400 text-white
                            rounded border"
                            name="test_label"></label>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </body>
</html>