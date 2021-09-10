<?php 
		$conectdb = new mysqli("localhost", "root", "", "enterpicture");?>
		<?php
		if (isset($_GET['id'])){
		$id = $_GET['id'];
			$add=$conectdb->query("SELECT * FROM enterpic where id='$id'"); 
			$show=$add->fetch_array();
	 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>EDIT</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
  <input type="hidden" name="std_id" value="<?php echo $show['id']; ?>">
  <table border="2">
    <tr>
      <td>Select Image</td>
      <td><input type="file" name="image" required="">
<!-- below line is use for replace the old image to new image in update -->
      	<input type="hidden" name="old_image" value="<?php echo $show['image'] ?>">
      		<img src="<?php echo "uploadimage/".$show['image']; ?>" width="100px" ></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="updatesubmit" value="Up to Date"></td>			
    </tr>
  </table>
</form>
<?php
	 } 
	 //Update picture with rename and replace old image to NEW image in folder and database
			if (isset($_POST['updatesubmit'])) {
				$id =$_GET['id'];
				$old=$_POST['old_image'];
					
				$location1=$_FILES["image"]["name"];
				$rann = pathinfo($location1, PATHINFO_EXTENSION);
				$rename = time();
				$newname = $rename.'.'.$rann;   
        $folder = "uploadimage/".$newname;
        	move_uploaded_file($_FILES["image"]["tmp_name"],$folder);	

        	$location1 = $old;

    			$dataup = $conectdb->query("UPDATE enterpic set image='$newname' where id='$id'");
    			unlink("uploadimage/".$old);
    			if ($dataup) {
					echo "<script>window.location='picture.php' </script>";
				}
		}
		?>
</body>
</html>