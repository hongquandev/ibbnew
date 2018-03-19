<?php

class ShortUrl extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'short_url';
        $this->id = 'id';
        $this->fields = array('id' => 0,
            'short_url' => '',
            'long_url' => '',
            'date_creation' => '0000-00-00 00:00:0');
    }

    public function addShortUrl($long_url = "")
    {
        if(strlen($long_url) > 0){
            $short_url = '/lnk/'.$this->randomString();
            $data = array('short_url' => $short_url,'long_url' => $long_url,'date_creation' => date('Y-m-d H:i:s'));
            $row = $this->getRow('long_url="'.$long_url.'"');
            if(is_array($row) && count($row) > 0){
                $this->update($data,'id='.$row['id']);
            }else{
                $this->insert($data);
            }
            return $short_url;
        }
        return $long_url;
    }
    public function randomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring .= $characters[rand(0, strlen($characters)-1)];
        }
        return $randstring;
    }
    public function getLongUrl($url = ''){
        $short_url = '/lnk/'.$url;
        $row = $this->getRow('short_url="'.$short_url.'"');
        if(is_array($row) && count($row) > 0){
            return $row['long_url'];
        }
        return '';
    }
}
if (!isset($shortUrl_cls) || !($shortUrl_cls instanceof ShortUrl)) {
    $shortUrl_cls = new ShortUrl();
}