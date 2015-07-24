<?php

//require './autoload.php';

/**
 * Class to fetch the data from the url and format it to get video info and 
 * video download url 
 * @author moniruzzaman
 */
Class Fetcher
{

    /**
     *
     * @var  array $data
     */
    private $data = array();

    /**
     *
     * @var string $title 
     */
    private $title;

    /**
     * set  the video id to the info url & pass the url to fetch data 
     * @param string $id adding the video id to the url
     */
    public function setId($id)
    {
        $url = "http://www.youtube.com/get_video_info?video_id=$id&el=embedded&ps=default&eurl=&gl=US&hl=en";
        //passing the url to fetch data in curl
        $html = $this->_getData($url);
        //passing the fetched data from curl to the formatUrl property to format the data 
        $this->formatUrl($html);
    }

    /**
     * 
     * @param string $url fetch data from the given url 
     * @return string
     */
    private function _getData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        //curl_setopt($ch, CURLOPT_TIMEOUT, 25);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * format the string that fetched by the curl Handler and store it into the $data property
     * @param string $data parse the url string from setId method and format it
     */
    public function formatUrl($data)
    {
        //split the url
        $splits = explode("&", $data);

        foreach ($splits as $split) {
            $c = explode("=", $split);
            $key = $c[0];
            $values = $c[1];
            $parsed[$key] = $values;
        }
        //get the video title and store it in $title property 
        $this->title = $parsed['title'];

        $streams = explode(',', urldecode($parsed['url_encoded_fmt_stream_map']));
        foreach ($streams as $value) {

            $splits = explode("&", $value);
            foreach ($splits as $split) {
                $c = explode("=", $split);
                $key = $c[0];
                $values = $c[1];

                $format[$key] = urldecode($values);
            }

            $formatted[] = $format;
        }

        foreach ($formatted as $val) {
            $newArr[$val['type']] = $val;
        }
        $array = array_values($newArr);
        //storing array in $data property
        Filesize::setUrls($array);
        $this->data = $array;
    }
    

    /**
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

}
