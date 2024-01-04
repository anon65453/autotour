----------------------------------------------------
----------------WHAT DOES THIS DO ?-----------------
----------------------------------------------------

-UPLOADS 360 PHOTOS TO "/photos" DIRECTORY
	CREATES THUMBNAILS FROM UPLOADS IN "/thumbnails" DIR FOR USE IN SPHERE VIEWER GALLERY PLUGIN
-AUTOTOUR WILL THEN CREATE A VIRTUAL TOUR FROM ALL OF THE PHOTOS THAT WERE UPLOADED
	GPS COORDINATES ARE TAKEN FROM PHOTO EXIF DATA AND ARROWS PLOTTED FOR LOCATION
	LOGO IS AUTOMATICALLY PLACED AT THE BOTTOM TO COVER TRIPOD
	GALLERY CONTAINS ALL UPLOADED PHOTOS & THUMBNAILS

----------------------------------------------------
-----------------------FILES------------------------
----------------------------------------------------

upload.html ( uploads file interface / displays uploaded photos when done )
upload.php ( uploads files / generates thumbnails for photo sphere gallery plugin ) 
	-SUBJECT TO PHP MAX CURRENTLY 40MB MAX / 3 FILES
autotour.php ( virtual tour assembled )
	-PHOTOSPHEREVIEWER, PLUGINS; MARKERS, GALLERY, VIRTUAL TOUR

----------------------------------------------------
--------------------FUTURE IDEAS--------------------
----------------------------------------------------

MAKE PHOTO NAME UNIQUE / HARD TO DOWNLOAD?

AJAX??
SETTINGS TO CHANGE VARIOUS SETTINGS AND PLUGIN SETTINGS

INTERFACE FOR EDITING
	REMOVE PHOTOS
	ADD MORE PHOTOS (upload.html)
	RENAME PHOTOS
	RE-ARANGE PHOTOS
	EDIT CAPTIONS
	SET INITIAL VIEW
CHANGE DROP SHADOW ON MOUSE HOVER
	

INTERFACE IDEA FROM HERE
https://bitfexl.github.io/photo-sphere-viewer-gen/

MY INTERFACE HERE TO CREATE THUMBNAILS
https://alexmrkts.com/360tours/proj/upload.html