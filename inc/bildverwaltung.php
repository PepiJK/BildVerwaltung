<?php 

// create the thumbnails with a height of 125px from the uploaded images
function createThumbs($desired_height, $filename) {
	$srcDir = "./pictures/uploads/";
	$destDir = "./pictures/thumbs/";

	$src = $srcDir . $filename;
	$dest = $destDir . $filename;

	$fileExtention = pathinfo($filename);

	switch($fileExtention['extension']) {
		case "jpeg":
		case "jpg":
			// read the source image 
			$source_image = imagecreatefromjpeg($src);
			break;
		
		case "png":
			// read the source image 
			$source_image = imagecreatefrompng($src);
			break;
		
		case "gif":
			// read the source image 
			$source_image = imagecreatefromgif($src);
			break;
		}

	// get width and height from image
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	// find the "desired width" of this thumbnail, relative to the desired height 
	$desired_width = floor($width * ($desired_height / $height));
	
	// create a new, "virtual" image
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	
	// copy source image at a resized size 
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
	
	switch($fileExtention['extension']) {
		case "jpeg":
		case "jpg":
			// create the physical thumbnail image to its destination 
			imagejpeg($virtual_image, $dest);
			break;
		
		case "png":
			// create the physical thumbnail image to its destination 
			imagepng($virtual_image, $dest);
			break;
		
		case "gif":
			// create the physical thumbnail image to its destination 
			imagegif($virtual_image, $dest);
			break;
	}
	imagedestroy($virtual_image);
	imagedestroy($source_image);
}


// calculate gps cordinates (° ' ") to float values
function getGps($exifCoord, $hemi) {
	$degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
	$minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
	$seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2]) : 0;

	$flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

	return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
}

function gps2Num($coordPart) {
	$parts = explode('/', $coordPart);

	if (count($parts) <= 0)
		return 0;

	if (count($parts) == 1)
		return $parts[0];

	return floatval($parts[0]) / floatval($parts[1]);
}


if($_GET['url'] == 'bildverwaltung') { 
	if (isset($_FILES['file'])) {	
		// create unique filename
		$fileName = uniqid() . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$uploadfile = './pictures/uploads/' . $fileName;
		// upload image
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			// create the thumbnails with a height of 200px from the uploaded images
			createThumbs(200, $fileName);
			
			// get image metadata
			$exif = exif_read_data($uploadfile, 'IFD0', 0);

			// create current timestamp
			$timestamp = date('Y-m-d H:i:s');
		
			// if gps data exist
			if(isset($exif['GPSLongitude']) && isset($exif['GPSLatitude'])) {
				// get longitude and latitude from picture
				$lon = getGps($exif['GPSLongitude'], $exif['GPSLongitudeRef']);
				$lat = getGps($exif['GPSLatitude'], $exif['GPSLatitudeRef']);
			} else {
				$lon = NULL;
				$lat = NULL;
			}

			// if image name exists
			if(isset($exif['DocumentName'])) {
				$name = $exif['DocumentName'];
			} else {
				// just use filename without extention
				$name = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
			}
			
			// safe picture in database
			$id = $db->safePicture($fileName, $name, $lon, $lat, $timestamp, $user);

			$returnData =  array(
				'fileName' => $name,
				'fileLocationThumb'=> './pictures/thumbs/' . $fileName,
				'id' => $id,
			);

			$returnData = json_encode($returnData);
			echo $returnData;
			die();		
		}
	}
	
	// get every image that belungs to the user
	$userImages = $db->getUserImages($user->username);
	
	// get every image that is shared to the user
	$sharedImages = $db->getSharedImages($user->username);

	// get every normal user
	$allUsers = $db->getAllUsers();

	// bildverwaltung.js ajax calls
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		$action = $_POST['action'];
		switch($action) {
			case 'getImageData': 
				$dataPics = $db->getPicturesFromId($_POST['id']);
				$dataPics = json_encode($dataPics);
				echo $dataPics;
				die();
				break;
			case 'getUsers': 
				$dataUsers = $db->getAllUsersExcept($user->username);
				$dataUSers = json_encode($dataUsers);
				echo $dataUSers;
				die();
				break;
			case 'getSharedUsers': 
				$dataShared = $db->getUsersSharedImage($_POST['id']);
				$dataShared = json_encode($dataShared);
				echo $dataShared;
				die();
				break;
			case 'safeSharedPictures':
				print_r($_POST['users']);
				die();
				break;
		}
	}
?>

<main>
	<div class="container mt-3">
		<h1>Bildverwaltung</h1>


		<!--
		<form enctype="multipart/form-data" action="./index?url=bildverwaltung" method="POST">
			<div class="input-group">
				<div class="input-group-prepend">
					<input class="input-group-text" type="submit" value="Upload" />
				</div>
				<div class="custom-file">
					<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
					<input type="file" name="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
					<label class="custom-file-label" for="inputGroupFile01">Bild auswählen</label>
				</div>
			</div>
		</form>
		-->



		<div class="row">
			<div class="col-12 col-lg-4 mb-5 mb-lg-0">
				<!-- Drag & Drop with dropzone.js -->
				<h2>Bilder Upload</h2>
				<div id="dropzone">
					<form action="./index.php?url=bildverwaltung" class="dropzone dz-clickable" id="dropzoneForm">
						<div class="dz-message">Bilder hereinziehen</div>
					</form>
				</div>


				<hr>

				<h2>Bilder bearbeiten</h2>
				<!-- form to edit images -->
				<form action="./index.php?url=bildverwaltung" method="POST">
					<div class="form-group">
						<!-- selected images will be displayed here -->
						<div class="mb-2" id="imgEdit"></div>
						<input id="imgSrc" type="hidden" name="imgSrc">
						<div class="row">
							<div class="col col-lg-7">
								<select name="selectEdit" class="form-control">
									<option value="grey">Graustufen</option>
									<option value="90left">90° nach links</option>
									<option value="90right">90° nach rechts</option>
								</select>
							</div>
							<div class="col col-lg">
								<button type="submit" class="btn btn-primary">bearbeiten</button>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="col col-lg">
				<h2>Meine Bilder</h2>
				<div id="userImages">
					<?php if(empty($userImages)) echo '<div id="userImagesAlert" class="alert alert-info" role="alert">Der User besitzt keine Bilder</div>';
					// Loop through every image that belungs to the user
					foreach ($userImages as $image) { ?>
					<img src="<?php echo $image->location_thumb ?>" class="img-fluid img-thumbnail pics"
						alt="<?php echo $image->name ?>" imgid="<?php echo $image->id ?>" onclick="userImageModal(this)">
					<?php } ?>
					<!-- Modal that gets called when image is clicked -->
				</div>

				<hr>

				<h2>Für mich freigegeben</h2>
				<div id="sharedImages">
					<?php if(empty($sharedImages)) echo '<div id="sharedImagesAlert" class="alert alert-info" role="alert">Keine Bilder für diesen User freigegeben</div>';
					// Loop through every image that is shared to the user
					foreach ($sharedImages as $image) { ?>
					<img src="<?php echo $image->location_thumb ?>" class="img-fluid img-thumbnail pics" data-toggle="modal"
						data-target="#sharedImageModal" alt="<?php echo $image->name ?>">
					<?php } ?>
				</div>

				<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalTitle"
					aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h3 id="modalTitle" class="modal-title" id="imageModalLongTitle"></h3>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div id="modalBody" class="modal-body">
							</div>
							<div id="modalFooter" class="modal-footer">
							</div>
						</div>
					</div>
				</div>




			</div>
		</div>
	</div>
</main>

<?php }
