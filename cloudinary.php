<?php 
	require "vendor/autoload.php";
	require "config-cloud.php";

	if(isset($_POST['submit'])) {
		$nama = $_POST['name'];
		$slug = $_POST['slug'];
		$gambar = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];

		\Cloudinary\Uploader::upload($file_tmp, array("public_id" => $slug));
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		img{width: 500px; margin-right: 10px;}
	</style>
</head>
<body>
	<form method="post" enctype="multipart/form-data">
		<input type="text" name="name" placeholder="name">
		<input type="text" name="slug" placeholder="slug">
		<?php echo cl_image_upload_tag('image_id'); ?>
		<input type="submit" name="submit" value="Submit">
	</form>
	<br>
	<hr>
	<?php echo cl_image_tag('dil'); ?>
	<?php echo cl_image_tag('ibgebaghaouret36cfeu'); ?>
</body>
</html>