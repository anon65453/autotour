<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>AutoTour - Automatic Virtual Tour Demo</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/core@5.4.4/index.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/gallery-plugin@5.4.4/index.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/virtual-tour-plugin@5.4.4/index.min.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/markers-plugin@5.4.4/index.min.css" />
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <div id="photosphere"></div>

        <script type="importmap">
            {
                "imports": {

                    "@photo-sphere-viewer/core": "https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/core@5.4.4/+esm",
                    "@photo-sphere-viewer/gallery-plugin": "https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/gallery-plugin@5.4.4/+esm",
                    "@photo-sphere-viewer/virtual-tour-plugin": "https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/virtual-tour-plugin@5.4.4/+esm",
					"@photo-sphere-viewer/markers-plugin": "https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/markers-plugin@5.4.4/+esm"
                }
            }
        </script>
        
        <script type="module">
            import { Viewer } from '@photo-sphere-viewer/core';
            import { GalleryPlugin } from '@photo-sphere-viewer/gallery-plugin';
            import { VirtualTourPlugin } from '@photo-sphere-viewer/virtual-tour-plugin';
            import { MarkersPlugin } from '@photo-sphere-viewer/markers-plugin';

            const baseUrl = '';
            const caption = '';

            const nodes = [
    <?php
                    $folder = 'photos';
                    $files = array_diff(scandir($folder), ['.', '..']);
                    $id = 1;
                    $nodeArray = [];
					$totalFiles = count($files);
					
                    foreach($files as $file) {
                        $photoPath = $folder . '/' . $file;
						$thumbnailPath = 'thumbnails/' . $file; // Corrected path for the thumbnail
						
						// Read EXIF data from the image
						$exif = exif_read_data($photoPath);

						// Extract GPS data from EXIF
						if ($exif && isset($exif['GPSLatitude'], $exif['GPSLongitude'])) {
							$lat = gps($exif['GPSLatitude'], $exif['GPSLatitudeRef']);
							$lon = gps($exif['GPSLongitude'], $exif['GPSLongitudeRef']);
							$alt = isset($exif['GPSAltitude']) ? altitude($exif['GPSAltitude']) : 0;  // defaulting altitude to 0 if not present
						} else {
							
						// Default GPS values if not found in EXIF
						$lat = 0;
						$lon = 0;
						$alt = 0;
								}

						
                        $englishNumber = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                        $name = ucfirst($englishNumber->format($id));
                        $nextId = ($id == $totalFiles) ? ($id - 1) : ($id + 1); // Increment ID count except last is -1

                        $nodeArray[] = "{
                            id: '{$id}',
                            panorama: '{$photoPath}',
							thumbnail: '{$thumbnailPath}',
                            name: '{$name}',
                            caption: '[{$id}] {$caption}',
							markers: [
										{
								id: 'image',
								image: 'assets/logo.png',
								size: { width: 300, height: 300 },
								position: { yaw: '0deg', pitch: '-90deg' },
								                    anchor: 'center center',
                    scale: [0.6, 1.7],
								tooltip: 'AlexMrkts.com'
										},
										                {
                    // circle marker
                    id: 'circle',
                    circle: 20,
                    position: { textureX: 2500, textureY: 1200 },
                    tooltip: 'A circle marker',
                },
										                
									],
                            links: [{ nodeId: '{$nextId}' }],
                            gps: [{$lat}, {$lon}, {$alt}],
                            panoData: { poseHeading: 327 }
                        }";
                        $id++;
                    }
                    echo implode(",\n", $nodeArray);
					// Function to handle GPS data
					function gps($coordinate, $hemisphere) {
					for ($i = 0; $i < 3; $i++) {
						$part = explode('/', $coordinate[$i]);
					if (count($part) == 1) {
						$coordinate[$i] = $part[0];
					} else if (count($part) == 2) {
						$coordinate[$i] = floatval($part[0])/floatval($part[1]);
					} else {
						$coordinate[$i] = 0;
							}
					}
					list($degrees, $minutes, $seconds) = $coordinate;
					$sign = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
					return $sign * ($degrees + $minutes/60 + $seconds/3600);
					}

					// Function to handle altitude data
					function altitude($coordinate) {
					$part = explode('/', $coordinate);
					if (count($part) == 1) {
					return $part[0];
					} else if (count($part) == 2) {
					return floatval($part[0])/floatval($part[1]);
					}
					return 0;}
    ?>
            ];
            
            const nodesById = {};
            nodes.forEach((node) => (nodesById[node.id] = node));

            const viewer = new Viewer({
                container: 'photosphere',
                loadingImg: 'assets/loader.gif',
                defaultYaw: '100deg',
				navbar: [
			{
            id: 'my-button',
            content: '<a href="https://alexmrkts.com/"><img src="assets/navbarlogoblack.png" alt="AlexMrkts Logo" height="20" style="float: right;"></a>',
            title: 'AlexMrkts Home',
            className: 'custom-button',
            onClick: (viewer) => {
            },
			},
			'fullscreen',
			'zoom',
			'gallery',
			],
            plugins: 
                [
				MarkersPlugin,
                [GalleryPlugin, {
				}],
                [VirtualTourPlugin, {
                        positionMode: 'gps',
                        renderMode: '3d',
                        startNodeId: nodes[1].id,
                        preload: true,
                        arrowPosition: 'bottom',
                        dataMode: 'client',
                        nodes: nodes,
				}],
                ],
            });

            const virtualTour = viewer.getPlugin(VirtualTourPlugin);
            window.viewer = viewer;
        </script>
    </body>
</html>
