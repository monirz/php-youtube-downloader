#!/usr/bin/php
<?php
/**
 * PHP CLI Youtube Downloader Package
 * @author Moniruzzaman Monir <monir.smith@gmail.com>
 * 
 */

require 'autoload.php';

fwrite(STDOUT, "Please enter video id : ");
$id = trim(fgets(STDIN));

$fetcher = new Fetcher();
$fetcher->setId($id);

$array = $fetcher->getData();
$get_title = $fetcher->getTitle();
$file_size = Filesize::getFilesize();

$title = urldecode($get_title);

foreach ($array as $item => $value) {

    $format = explode(";", $value['type']);
    $url_part[] = $array[$item]['url'] . '&title=' . $get_title;
    $format_title[] = $format[0];
}


foreach ($url_part as $key => $url_p) {

    echo "key [$key]  " . $format_title[$key] . "(" . Converter::megaByte($file_size[$key]) . "mb)\n";

    if (preg_match('/(flv|mp4|webm|3gpp)$/', $format_title[$key], $matches)) {

        $extension[] = $matches[0];
    }
}

fwrite(STDOUT, "Please enter video format key : ");
$video_key = trim(fgets(STDIN));
$video_get = $url_part[$video_key];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $video_get);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_NOPROGRESS, 0);
curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, "progress");
curl_setopt($ch, CURLOPT_SSLVERSION, 3);

$data = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

function progress($resource, $download_size, $downloaded, $upload_size, $uploaded)
{

    $size = Converter::megaByte($download_size);
    $downloaded_size = Converter::megaByte($downloaded);
    if ($downloaded_size > 0) {

        $progress = round($downloaded_size * 100 / $size);

        for ($i = 0; $i <= $progress; $i ++) {

            fwrite(STDOUT, $progress . "\033[0G [ " . str_repeat("=", $progress) . ">".str_repeat(' ', 50 - $progress) . " ]$progress% $downloaded_size/$size mb");
            sleep(1);
        }
    }
}

echo "saving file....\n";
$destination = "./$title.$extension[$video_key]";
$file = fopen($destination, "w+");
fputs($file, $data);
fclose($file);
