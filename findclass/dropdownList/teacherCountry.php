<div id="teacherCountry" class="hidden z-10 w-52 bg-white rounded-xl shadow">
    <div class = "my-2 justify-center px-1">    
    <?php foreach ($countryList as $country) {        
        ?><button value = "<?php echo $country; ?>" class = "text-gray-800 bg-gray-300 hover:bg-gray-400 font-medium rounded-2xl text-xs px-2 mx-1 my-1 py-2 text-center inline-flex items-center">
        <?php echo $country; ?><button>
    <?php } ?>        
    </div>           
</div>