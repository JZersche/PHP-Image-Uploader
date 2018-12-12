<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" content="text/css" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>


<header>
    <div class="wrapper">
<?php include 'database.php'; ?>

        <div class="inputs">
            <form method="POST" action="" id="new_document_attachament" enctype="multipart/form-data">
                <span id='resultcnt'><textarea id='result' name="imageb64"></textarea></span>
                Name:<input type="text" name="name"><br />
                Image:<input type="text" name="image"><br />
                <input type="file" name="file" id="img_upload"><br />
                <?php

$rChar = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; $r = str_shuffle($rChar); $rSub = substr($r,0,8); 

if (isset($_FILES['file'])) {

	$name = $_FILES['file']['name'];
    $file_ext = substr($name, strripos($name, '.'));
    //$file_basename = substr($name, 0, strripos($name, '.'));
    $file_basename = 'aaaaa';
	if (!empty($name)) {


		$location = 'images/';
		$tmp_name = $_FILES['file']['tmp_name'];
        $random_name = $location.$file_basename.$rSub.$file_ext;
		if (move_uploaded_file($tmp_name, $random_name)) {
			//echo 'Uploaded!';
		}
	}
}

?>
                Paste Image:<div id='editor' name="pasted" contenteditable=true></div><br>
                Filename:<input type="text" name="filename"><br>
                Download URL:<input type="text" name="download_link"><br>
                <input type="submit" value="Insert into DB"><input type="submit" name="DisplayDB" value="Display Database"><input type="submit" name="DeleteSQL" value="Delete SQL">
            </form>
        </div>
    </div>
</header>


<script type="text/javascript">
    $(document).ready(function() {
        $('#editor').on('paste', function(e) {
            var orgEvent = e.originalEvent;
            for (var i = 0; i < orgEvent.clipboardData.items.length; i++) {
if (orgEvent.clipboardData.items[i].kind == "file" && orgEvent.clipboardData.items[i].type == "image/png" && orgEvent.clipboardData.items[i].getAsFile().size > 500000) {
    var imageFile = orgEvent.clipboardData.items[i].getAsFile();
        var filename = imageFile.name; var ext = filename.split('.').reverse()[0].toLowerCase();
                var item = orgEvent.clipboardData.items[i]; 

                    const form = document.getElementById("new_document_attachament");
                    const fileInput = document.getElementById("img_upload");

                    fileInput.addEventListener('change', () => {
                    form.submit();
                    });

                    window.addEventListener('paste', e => {
                    fileInput.files = e.clipboardData.files;
                    });

    console.log(imageFile); // Get Image File 
      console.log(imageFile.size); // Get Image File Size
        console.log(filename); // Get File Name
         console.log(ext); // Get File Extension
                console.log("Line 73 " + item.type);

                var fileReader = new FileReader();
                    fileReader.onloadend = function() {

                        if (imageFile.size > 20000000) {  //  Size Limit
                            console.log('File Size too large');
                            $("#result").css({
                                "display": "inline-block",
                                "background": "#f00"
                            });
                            $("#editor img").css({
                                "display": "none"
                            }); return false;
                        } else {
                            $('#result').html(fileReader.result);
                            $("#result").css({
                                "display": "inline-block","background": "#06ad","line-height": "12px","width": "258px","top": "110px","left": "25px","height": "48px"
                            });
                            $("#img_upload").css({
                                "display": "block","background": "transparent","background": "transparent","margin-bottom": "35px"
                            });

                            if ($.inArray(ext, ['jpg', 'png']) > -1) { 
                            	if (item.type.indexOf("image") > -1) { 
                            		console.log(item.type.indexOf("image")) 
                            		console.log('Line 99');
                            	    } 
                                }
                        }
                    }

                    fileReader.readAsDataURL(imageFile);

                    //fileReader.readAsBinaryString(imageFile);
                    break;
                }

                if (orgEvent.clipboardData.items[i].kind == "file" && orgEvent.clipboardData.items[i].type == "image/png" && orgEvent.clipboardData.items[i].getAsFile().size < 500000) {

                    var imageFile = orgEvent.clipboardData.items[i].getAsFile();
                    var filename = imageFile.name;
                    var ext = filename.split('.').reverse()[0].toLowerCase();

                    var item = orgEvent.clipboardData.items[i];

                    console.log(imageFile); // Get Image File
                    console.log(imageFile.size); // Get Image File Size
                    console.log(filename); // Get File Name
                    console.log(ext); // Get File Extension
                    console.log("Line 123: " + item.type);

                 var fileReader = new FileReader();
                    fileReader.onloadend = function() {

                        if (imageFile.size > 20000000) {  //  Size Limit
                            console.log('File Size too large');
                            $("#result").css({
                                "display": "inline-block",
                                "background": "#f00",
                            });
                            $("#editor img").css({
                                "display": "none"
                            }); return false;


                        } else {
                            $('#result').html(fileReader.result);
                            $("#result").css({
                                "display": "inline-block", "background": "#4a0f"
                            });
                            $("#img_upload").css({
                                "display": "none","background": "blue"
                            });

                            if ($.inArray(ext, ['jpg', 'png']) > -1) 
                            { 
                            	if (item.type.indexOf("image") > -1) { 
                                console.log(item.type.indexOf("image")) 
                                console.log('Line 155');
                                } 
                            }
                        }

                    }

                    fileReader.readAsDataURL(imageFile);

                    //fileReader.readAsBinaryString(imageFile);
                    break;
                }
            }
        });

    });
</script>


<?php
$statement = $dbconn->query("SELECT * FROM img_uploads;");
?>
<div class="masonry">
    <?php
while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
?>
    <div class="item">
        <img src="<?php echo $image = $row['image']; echo $imageb64 = $row['imageb64']; echo $image_path = $row['image_path']; ?>">
        <div class="download">
            <div><span><a href="<?php echo $download_link = $row['download_link']; ?>">Download</a></span></div>
        </div>
    </div>
<?php } ?> 
</div>
<?php


$statement = $dbconn->prepare("
  INSERT INTO img_uploads (name, image, image_path, imageb64, filename, download_link) 
  VALUES (:name, :image, :image_path, :imageb64, :filename, :download_link)
  ");

$statement->bindParam(':name', $name);
$statement->bindParam(':image', $image);
$statement->bindParam(':image_path', $image_path);
$statement->bindParam(':imageb64', $imageb64);
$statement->bindParam(':filename', $filename);
$statement->bindParam(':download_link', $download_link);


 if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['name']))
 {
    $location = 'images/';
    $name = htmlentities($_POST['name']);
    $image = htmlentities($_POST['image']);
          $image_path = htmlentities($location.$file_basename.$rSub.$file_ext);
    $file = htmlentities($_FILES['file']['tmp_name']);
 if (strlen($_POST['imageb64']) <= 500000) {
    $imageb64 = htmlentities($_POST['imageb64']);
    $image_path = "";
  //  $image_path = "";
} else { $imageb64 = "";}
//    $imageb64 = htmlentities(bin2hex($_POST['imageb64']));
    $filename = htmlentities($_POST['filename']);
    $download_link = htmlentities($_POST['download_link']);
	$statement->execute(); 
	?> <span style="color:#0f0;" class="success-message">  ::: SQL Data Inserted Successfully! <?php echo strlen($_POST['imageb64']) ?> </span>
<?php
 }


  elseif($_SERVER['REQUEST_METHOD'] == "POST" && empty($_POST['name']) && isset($_POST['DeleteSQL']))
    {
  $delete = $dbconn->query("DELETE FROM imguploads;");
  $delete = $dbconn->query("ALTER TABLE imguploads AUTO_INCREMENT = 0;");
    $delete->execute();
  ?> <span style="color:red;">─> Deleted Successfully! </span>
<?php
    }

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['DisplayDB'])) {
  header('Refresh: 1;');
}

?>