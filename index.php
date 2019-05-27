<?php
  // Luodaan tietokanta yhteys
  $db = mysqli_connect("localhost", "root", "", "youtube_harjoittelu_kannat");

  // Luodaan valokuva muutuja
  $msg = "";

  // Kun lataus painiketta painetaan ...
  if (isset($_POST['upload'])) {
  	//Haetaan kuvan nimi nimeä
  	$image = $_FILES['image']['name'];
  	// Haetaan kuba tekstiä
  	$image_text = mysqli_real_escape_string($db, $_POST['image_text']);

  	// image file directory
  	$target = "kuvat/".basename($image);

  	$sql = "INSERT INTO kuvan_lataus_serverille (image, image_text) VALUES ('$image', '$image_text')";
  	// Suoritetaan sql lause
  	mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $result = mysqli_query($db, "SELECT * FROM kuvan_lataus_serverille");
?>
<!DOCTYPE html>
<html>
<head>
<title>Image Upload</title>
<style type="text/css">
   #content{
   	width: 50%;
   	margin: 20px auto;
   	border: 1px solid #cbcbcb;
   }
   form{
   	width: 50%;
   	margin: 20px auto;
   }
   form div{
   	margin-top: 5px;
   }
   #img_div{
   	width: 80%;
   	padding: 5px;
   	margin: 15px auto;
   	border: 1px solid #cbcbcb;
   }
   #img_div:after{
   	content: "";
   	display: block;
   	clear: both;
   }
   img{
   	float: left;
   	margin: 5px;
   	width: 300px;
   	height: 140px;
   }
</style>
</head>
<body>
    <h1 style="text-align:center;">Kuvan tallennus MySql kantaan ja sen näyttäminen selaimella</h1>
<div id="content">
  <?php
    while ($row = mysqli_fetch_array($result)) {
      echo "<div id='img_div'>";
      	echo "<img src='kuvat/".$row['image']."' >";
      	echo "<p>".$row['image_text']."</p>";
      echo "</div>";
    }
  ?>
  <form method="POST" action="index.php" enctype="multipart/form-data">
  	<input type="hidden" name="size" value="1000000">
  	<div>
  	  <input type="file" name="image">
  	</div>
  	<div>
      <textarea 
      	id="text" 
      	cols="40" 
      	rows="4" 
      	name="image_text" 
      	placeholder="Kuvateksti..."></textarea>
  	</div>
  	<div>
  		<button type="submit" name="upload">Lataa</button>
  	</div>
  </form>
</div>
</body>
</html>