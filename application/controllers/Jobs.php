<?php
//namespace App\Controllers;
use \GetId3\GetId3Core as GetId3;
use GetId3\Write\Tags;
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Home page
 */
class Jobs extends MY_Controller {

	public function index()
	{
		$this->render('home', 'full_width');
	}

	public function test(){
        $this->render('home', '3_column');
    }

    function mp3info($mp3File='')
    {
        //echo $mp3File;exit;
        if(!file_exists($mp3File)){
           die('File not exist.');
        }
        //$mp3File = 'E:\wamp64\www\phpstrom\zjmaza\uploads\mp3\aeeena_Badal Ki Tarah Jhoom Ke.mp3';
        $getId3 = new GetId3();
        $audio = $getId3
            ->setOptionMD5Data(true)
            ->setOptionMD5DataSource(true)
            ->setEncoding('UTF-8')
            ->analyze($mp3File);

        if (isset($audio['error'])) {
            throw new \RuntimeException(sprintf('Error at reading audio properties from "%s" with GetId3: %s.', $mp3File, $audio['error']));
        }
        //$this->setLength(isset($audio['playtime_seconds']) ? $audio['playtime_seconds'] : '');

        return $audio;
    }

    public function writeId3Tags($mp3File, $tagData = array())
        {
            if (!file_exists($mp3File)) {
                die('File not exist.');
            }
            // $mp3File = 'E:\wamp64\www\phpstrom\zjmaza\uploads\mp3\aeeena_Badal Ki Tarah Jhoom Ke.mp3';
            $tagwriter = new Tags();
            $tagwriter->filename = $mp3File;
            $tagwriter->tagformats = array('id3v1', 'id3v2.3');
            $tagwriter->overwrite_tags = true;
            $tagwriter->tag_encoding = 'UTF-8';
            $tagwriter->remove_other_tags = false;

            $hash = ' '.substr(md5(mt_rand()), 0, 8);
            /*$tagData = array(
                'title' => array('My Song'.$hash),
                'artist' => array('The Artist'.$hash),
                'album' => array('Greatest Hits'.$hash),
                'year' => array('1986'.$hash),
                'genre' => array('Electronic'.$hash),
                'comment' => array('excellent!'.$hash),
                'track' => array('04/16'.$hash),
            );*/
            $tagwriter->tag_data = $tagData;
            $tagwriter->WriteTags();


            return true;
        }






}
