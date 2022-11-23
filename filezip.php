<html>
<head>
    <title>Create Zip File of Multiple Uploaded Files using PHP</title>

</head>
<body>
    <?php include 'filezipup.php'; ?>
    <div class="row">
    	<div class="page-container row-12">
    		<h4 class="col-12 text-center mb-5">Create Zip File of Multiple Uploaded Files </h4>
    		<div class="row-8 form-container">
           
    			<p class="error text-center"><?php echo $error; ?></p>
         
          
    			<p class="success text-center">
            Files uploaded successfully and compressed into a zip format
            </p>
            <p class="success text-center">
            <a href="uploads/<?php echo $success; ?>" target="__blank">Click here to download the zip file</a>
            </p>
	    	 
		    	<form action="" method="post" enctype="multipart/form-data">
				    <div class="input-group">
						<div class="input-group-prepend">
						    <input type="submit" class="btn btn-primary" value="Upload">
						</div>
						<div class="custom-file">
						    <input type="file" class="custom-file-input" name="img[]" multiple>
						    <label class="custom-file-label" >Choose File</label>
						</div>
					</div>
				</form>
				
    		</div>
		</div>
	</div>
</body>
</html>