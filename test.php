<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./dist/output.css" rel="stylesheet">
        <title>Dialog</title>
    </head>
    <body><br><br><br><br><br><br><br><br><br><br>
        <button class = "bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white m-5 show-modal">show modal</button>
        <div class = "modal h-full w-full fixed bottom-0 justify-center items-center bg-black bg-opacity-50 hidden">
            <div class = "flex flex-col-reverse w-full h-full">
                <!-- modal -->
                <div class = "bg-white rounded shadow-lg w-full h-5/6 items-center border-2 pt-20">
                    <!-- modal_header -->
                    <div class = "border-b px-4 py-2">
                        <h3>Modal Title</h3>
                    </div>
                    <!-- modal_body -->
                    <div class = "p-3">
                        모달내용모달내용모달내용모달내용모달내용모달내용모달내용모달내용모달내내용
                    </div>
                    <div class = "flex justify-end items-center w-100 border-t p-3">
                        <button class = "bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white mr-1 close-modal">Cancel</button>
                        <button class = "bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white">Ok</button>
                    </div>
                </div>
            </div>
        </div>  
        <script>
            const modal = document.querySelector('.modal');

            const showModal = document.querySelector('.show-modal');
            const closeModal = document.querySelector('.close-modal');

            showModal.addEventListener('click', function() {
                modal.classList.remove('hidden');
            });

            closeModal.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        </script>        
    </body>
</html>