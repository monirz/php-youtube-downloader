<?php

class Filesize
{

    public static $fileSizes = array();

    public static function remotefileSize($url)
    {
       $ch = curl_init($url);
	curl_setopt($ch, CURLOPT_NOBODY, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
	curl_exec($ch);
	$filesize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
	curl_close($ch);
        if ($filesize) {
            self::$fileSizes[] = $filesize;
        }
    }

    public static function setUrls($data)
    {
        foreach ($data as $item => $value) {

            $urls[] = $data[$item]['url'];
        }


        foreach ($urls as $url) {
            self::remotefileSize($url);
        }
    }

    public static function getFilesize()
    {
        return self::$fileSizes;
    }

}
