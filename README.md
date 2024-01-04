# Autotour

## IDEA

The goal of this project was to create a "one-stop-shop" web app that would allow the creation of a virtual tour seamlessly, simply by supplying equirectangular photographs.

Currently, the process of creating a virtual tour is time-consuming and lengthy, requiring each scene to be manually assembled. Markers, arrows, and placements need to be linked to other scenes and hand-placed in order for the virtual tour to be navigable. There is not a single off-the-shelf product that can be considered an "all-in-one" solution. Marzipano can be extremely time-consuming for virtual tours with more than 25 scenes.

## HOW IT WORKS

Users will access `/upload.html`, which allows equirectangular photos to be uploaded to the `dir /photos` and a logo of 500px x 500px to the location `/assets/logo.png`. At the same time, when photos are uploaded, thumbnails will be created and sent to the `dir /thumbnails`. When the upload is complete, the uploaded photos will be displayed. (You will be limited to the PHP variables on your server; `post_max_size`, `upload_max_filesize`, and `timeout`, so be sure to adjust if using multiple files as you will most likely hit this limit.)

Once the photos are uploaded, you then access `/autotour.php`. This will take all the photos that were uploaded in the previous step and assemble them into a virtual tour with the following considerations:
- A NADIR logo will automatically be applied to the bottom of each 360-degree photograph. This logo should be 500px square and is supplied on the `upload.html` page.
- The logo is an overlay on top of the scene, so it will stay properly oriented during the movement of the scene.
- Thumbnails that were generated will be assigned to each scene, named, and made navigable on the bottom gallery bar.
- GPS coordinates extracted from the photos and corresponding arrow markers will be automatically added to each scene for navigation.
- Each scene is linked to the corresponding arrow via these markers.

`Autotour.php` is meant to be the final product and nothing more needs to be done. At this point, the virtual tour is assembled.

## FEATURES

- Upload form for logo and 360 photos.
- Auto-creation of thumbnails from supplied equirectangular photos.
- Auto-creation of gallery & named photos.
- GPS information extracted.
- Arrow markers applied to each scene in relation to the extracted GPS coordinates.
- Each scene linked to another scene using arrows and GPS data.
- NADIR logo applied to the bottom to cover the tripod.

## REQUIREMENTS

- Apache, PHP.
- Equirectangular photos with GPS data.
  - Do not use dual fisheye or 360; must be equirectangular.
- Upload photos in order of appearance.

## FUTURE IDEAS

- Allow change of various settings and plugin settings.
- Interface for editing:
  - Remove photos.
  - Add more photos (`upload.html`).
  - Rename photos.
  - Rearrange photos.
  - Edit captions.
  - Set initial view.
  - Change navbar logo.

## CREDITS

This application is custom-written on top of using the framework @photo-sphere-viewer.
