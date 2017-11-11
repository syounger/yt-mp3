<?php

require_once('youtube-dl.config.php');

class Video{


	public $name;
	public $dir = cnfg::Download_Folder;
	public static $audio_dir = 'MP3';
	private $path;

	public function __construct($name){
		$this->name = $name;
		$this->path = $this->dir.DIRECTORY_SEPARATOR.$this->name;
	}

	/**
	 * @brief create mp3 from video
	 * @return string path to mp3 file
	 * @throws Exception if mp3 not created
	 */	
	public function createMP3(){
		$mp3 = str_replace('mp4', 'mp3', $this->name);
		$mp3 = substr($this->name, 0, -3).'mp3';
		$mp3_path = self::$audio_dir.DIRECTORY_SEPARATOR.$mp3;
		`ffmpeg -i {$this->path} {$mp3_path}`;
		if(!file_exists($mp3_path)) throw new Exception('failed to generate mp3 file');
		return $mp3;
	}


}
