<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Test Upload</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Test Upload</h1>

	<div id="body">
		
		<input type="file" id="image_file" name="image_file[]" onchange="previewFile()">
		<br/><br/><div style="border-bottom: 1px solid #ddd; margin-bottom: 5px;"></div>

		<!-- <img src="" height="200" alt="Image preview..." > -->

		<div id="box-preview"></div>

	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>

   function previewFile() {



//		SINGLE PREVIEW
// 		-------------------------------------------------------------------------------------
//     	var preview = document.querySelector('img'); //selects the query named img
//     	var file    = document.querySelector('input[type=file]').files[0]; //sames as here
//     	var reader  = new FileReader();
//
//     	reader.onloadend = function () {
//         	preview.src = reader.result;
//     	}
//
//     	if (file) {
//         	reader.readAsDataURL(file); //reads the data as a URL
//     	} else {
//         	preview.src = "";
//     	}




		
		var file    = document.querySelector('input[type=file]').files[0]; //sames as here
		var reader  = new FileReader();

		reader.onloadend = function () {
    		$("#box-preview").append("<img src='"+reader.result+"' height='70'>");
    	}

       	reader.readAsDataURL(file);





    	// UPLOAD ----------------------------------------------------------------------------
    	var url  = 'http://localhost/_telkom/_backend/portal/Api/ArticleController/upload';
		var image_file = $('#image_file').get(0).files[0];

		var formData = new FormData();
		formData.append("image_file", image_file);

		$.ajax({
			url: url,
			type: 'POST',
			data: formData,
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			success: function (status) {
			  console.log("Success: "+status.url);
			  console.log(status.url);
			  console.log(status.name);
			}
		});

  }

  previewFile();  //calls the function named previewFile()

</script>

</body>
</html>