<?php
namespace App;

use Exception;

/**
 * Класс для скачивания yml
 *
 * @author 4everjf
 * @date 02.10.2019 23.48
 */
class YmlFileHelper
{

    private static $local_xml_live_time = 43200; // 12 часов

    /**
     * скачиваем yml только если файла еще нет, или он устарел
     *
     * @param string $url
     * @return string
     * @throws Exception
     */
    public static function getYmlFile($url)
    {
        $sha = sha1($url);
        $file_path = storage_path('/app/' . $sha . '.xml');
        if(!file_exists($file_path) || filemtime($file_path) < (time() - self::$local_xml_live_time)){
            self::downloadFromUrlToDestination($url, $file_path);
        }

        return $file_path;
    }

    /**
     *  скачивание файла по url в казанное местоположегие
     *
     * @param string $url
     * @param string $dest
     * @throws Exception
     */
    private static function downloadFromUrlToDestination($url, $dest)
    {
        if(file_exists($dest) && is_writable($dest)){
            file_put_contents($dest, '');
        }
        $write_handle = fopen($dest, "wb");
        if(!$write_handle){
            Throw new Exception('Can\'t open destination file: ' . $dest . ' for writing!');
        }
        $read_handle = fopen($url, "rb");
        if(!$read_handle){
            Throw new Exception('Can\'t open source url: ' . $url . ' for reading!');
        }

        while (($line = fgets($read_handle)) !== false) {
            fwrite($write_handle, $line);
        }

        fclose($write_handle);
        fclose($read_handle);
    }
}

