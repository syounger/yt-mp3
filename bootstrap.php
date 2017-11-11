<?php

// moved here from youtube-dl.class.php
// Include the config interface.
require('lib/youtube-dl.config.php');
// Include helper functions for usort.
require('lib/comparisonfunctions.usort.php');

require_once 'lib/youtube-dl.class.php'; // this is an old script, not properly packaged, and it needed a minor fix, so I did not include it with composer

require_once 'lib/video.php'; // not worth writing an autoloader for one class

// youtube-dl class creates video directory. so we do not have to do that here
if(!file_exists(Video::$audio_dir)){
echo getcwd();
	mkdir(Video::$audio_dir);
}
