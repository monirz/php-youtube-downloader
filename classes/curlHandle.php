<?php



class curlHandler
{
    
    private $fileSize = array();

    public function Data($url)
    {
     
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOPROGRESS, 0);
        curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, "progress");
        
        curl_setopt($ch, CURLOPT_SSLVERSION,3);
        $data = curl_exec ($ch);
        //$error = curl_error($ch);
        curl_close ($ch);

        return $data;
    }

    public function progress($resource, $download_size, $downloaded, $upload_size, $uploaded)
    {

        foreach ($download_size as $size){
            $this->fileSize = $size;
        }
    }
    
    public function getSize()
    {
        foreach ($this->fileSize as $size){
            echo $size."<br/>";
        }
    }

}
