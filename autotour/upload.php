<?php
header('Content-Type: application/json');

$targetDir = "photos/";
$thumbnailDir = "thumbnails/";
$thumbnails = [];
$logoDir = "assets/";

$response = ['status' => 'success', 'message' => 'Upload complete.'];

// Logo upload
if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] === UPLOAD_ERR_OK) {
    $logoFile = $_FILES["logo"];

    if ($logoFile["type"] !== "image/png") {
        echo json_encode(['status' => 'error', 'message' => 'The logo must be a PNG file.']);
        exit;
    }

    $logoTargetFile = $logoDir . "logo.png";
    if (!move_uploaded_file($logoFile["tmp_name"], $logoTargetFile)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload the logo.']);
        exit;
    }

    $response['logo'] = './' . $logoTargetFile;  // Ensure the path is correct
}

// Photos upload
if (isset($_FILES["photos"])) {
    foreach ($_FILES["photos"]["error"] as $key => $error) {
        if ($error === UPLOAD_ERR_OK) {
            $name = $_FILES["photos"]["name"][$key];
            $targetFile = $targetDir . basename($name);
            $thumbnailFile = $thumbnailDir . basename($name);

            // Move the uploaded file to photos directory
            if (move_uploaded_file($_FILES["photos"]["tmp_name"][$key], $targetFile)) {
                // Generate the thumbnail
                $imagick = new \Imagick(realpath($targetFile));
                $imagick->thumbnailImage(600, 300, true, true);
                $imagick->writeImage($thumbnailFile);
                
                $thumbnails[] = './' . $thumbnailFile;  // Ensure the path is correct
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Some files could not be uploaded.';
            }
        }
    }
    $response['thumbnails'] = $thumbnails;
}

echo json_encode($response);
?>
