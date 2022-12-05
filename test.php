<!DOCTYPE html>
<html lang="en">
<head>
    <link href="./dist/output.css" rel="stylesheet">    
    <title>Dialog</title>
</head>
<script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>

    <button id = "before_btn" class = "border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1">이전</button>
    <button id = "after_btn" class = "border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1">다음</button>
    <button id = "btn">sdsdf</button>
    <a id = "test_btn" >sdsd</a>    
    <script>
        let before_btn = document.getElementById("before_btn");
        let after_btn = document.getElementById("after_btn");
        let test_btn = document.getElementById("test_btn");
        
        // before_btn.addEventListener("click", alert("click"));
        after_btn.addEventListener("click", showText);
        test_btn.addEventListener("click", showText);

        var showBtn = document.getElementById("btn");
        showBtn.addEventListener("click", showText);
        function showText(){
            
            console.log("dddd");
            
        }

    </script>
</body>
</html>