<?php

require_once 'vendor/autoload.php';
require_once('bootstrap.php');

use YoutubeScraper\YoutubeScraper;

Flight::map('download', function($file, $filename='', $mime='application/octet-stream'){
		if(!$filename && !file_exists($file)) throw new DomainException('Filename must be provided to download raw data');
		if(!$filename) $filename = basename($file);

		header('Content-Disposition: Attachment;filename='.$filename);
		header('Content-type: '.$mime);
		if(file_exists($file)){
			header('Content-length: '.filesize($file));
			readfile($file);
		}else{
			header('Content-length: '.strlen($file));
			echo $file;
		}
	});

// url-to-mp3
Flight::route("GET /api/youtube2mp3", function(){
	try{
		$yt = new yt_downloader(Flight::request()->query->url, true);
		$video = new Video($yt->video);
		$mp3 = $video->createMP3();
		Flight::json(["video_id" => $yt->videoID, "url" => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/api/mp3/'.$mp3]);
	}catch(Exception $e){
				//throw $e;
		Flight::notFound();
	}
	});

Flight::route('GET /api/mp3/@mp3', function($mp3){
		$dir = Video::$audio_dir;
		$file = $dir.DIRECTORY_SEPARATOR.$mp3;
		if(!file_exists($file)) Flight::notFound();
		Flight::download($file);
	});

Flight::start();
