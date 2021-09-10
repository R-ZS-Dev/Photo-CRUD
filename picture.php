<?php 
		$conectdb = new mysqli("localhost", "root", "", "enterpicture");
	?>
	<?php
	$msg = "";
	if (isset($_POST['submit'])) {
		$allowed_extension = array('gif', 'png', 'jpg', 'jpeg');
		$filename = $_FILES["image"]["name"];
		$file_extension = pathinfo($filename , PATHINFO_EXTENSION);
		if (in_array($file_extension, $allowed_extension)) {
					echo "UPLOADED";
				
		$randomno = rand(0,100);
		$rename ='name'.date('ymd').$randomno;

		$newname = $rename.'.'.$file_extension;

    	$tempname = $_FILES["image"]["tmp_name"];   
        $folder = "uploadimage/".$newname;
		
		$conectdb->query("INSERT into enterpic (image) values ('$newname')");	
		if (move_uploaded_file($tempname, 'uploadimage/'.$newname))  {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
      }
      }
		}
	?>
<?php 
			if (isset($_GET['delete'])) {
		$selectSql = "select * from enterpic where id = ".$_GET['delete'];
		$rsSelect = mysqli_query($conectdb,$selectSql);
		$getRow = mysqli_fetch_assoc($rsSelect);
		
		$getIamgeName = $getRow['image'];
		
		$createDeletePath = "uploadimage/".$getIamgeName;
		
		if(unlink($createDeletePath))
		{
			$deleteSql = "delete from enterpic where id = ".$getRow['id'];
			$rsDelete = mysqli_query($conectdb, $deleteSql);	
			
			}
		}
 		?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Picture</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
  <table border="2">
    <tr>
      <td>Select Image</td>
      <td><input type="file" name="image" required=""></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="submit" value="Upload"></td>			
    </tr>
  </table>
</form>
<table border="1">
			<tr>
				<th>Id</th>
				<th>Image</th>
				<th>Photo Name</th>
				<th>Delete</th>
				<th>Up-Date</th>
			</tr>
		<?php

		$i=1;
			$one = $conectdb->query("SELECT * FROM enterpic");
			while ($show=$one->fetch_array()) {
		?>
		<tr>
		    <th><?php echo $i++ ?></th>
			<th><img src="uploadimage/<?php echo $show['image']; ?>" width="100" height="100"></th>	
			<th><?php echo $show['image'] ?></th>	
			<th><a href="?delete=<?php echo $show['id'] ?>">Delete</a></th>
			<th><a href="picedit.php?id=<?php echo $show['id'] ?>">Edit</a></th>
		</tr>
			<?php } ?>
</body>
</html>