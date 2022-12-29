<div id="teacherCountry" class="hidden z-10 w-60 bg-white rounded-xl shadow">
    <div class = "my-2 justify-center px-1">  
    <?php foreach ($countryList as $country) {        
        ?><input type="checkbox" id = "<?php echo $country; ?>" name = "filter_teacher_country" value="<?php echo $country; ?>" class="hidden" />
        <label for="<?php echo $country; ?>" class="filter_checkbox text-gray-800 bg-gray-300 hover:bg-gray-400 font-medium rounded-2xl text-xs px-2 mx-1 py-2 my-1 text-center inline-flex items-center"
        ><?php echo $country; ?></label>
    <?php } ?>      
    </div>           
</div>