<div id="teacherLanguage" class="hidden z-10 w-56 bg-white rounded-xl shadow">
    <div class = "my-2 justify-center px-1">            
    <?php foreach ($languageList as $language) {        
        ?><button value = "<?php echo $language; ?>" class = "text-gray-800 bg-gray-300 hover:bg-gray-400 font-medium rounded-2xl text-xs px-2 mx-1 my-1 py-2 text-center inline-flex items-center">
        <?php echo $language; ?><button>
    <?php } ?>        
    </div>           
</div>