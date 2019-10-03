<?php

namespace App;

use App\Items;
use App\YmlFileHelper;
use Illuminate\Support\Facades\DB;

/**
 * Класс для получения данных из xml и записи / обновления в БД
 *
 * Class YmlParser
 * @package App
 */
class YmlParser
{
    /**
     * При включении
     * - рандомные записи будут менять свою цену при каждом запуске
     * - рандомные записи не будут добавлятся, если их нет в БД
     */
    const TEST = false;

    /**
     * Поля связки YML и БД
     * @var array
     */
    private static $offer_fields = [
        'name' => 'name',
        'url' => 'url',
        'price' => 'price',
        'currency' => 'currencyid',
        'picture' => 'picture',
        'delivery' => 'delivery',
        'description' => 'description',
    ];

    /**
     * Получение товаром по url
     *
     * @param string $url
     * @return array
     */
    public static function getOffers($url)
    {
        $result = [
            'success' => 'OK',
            'message' => '',
            'added' => 0,
            'updated' => 0,
            'missed' => 0
        ];
        $existsItemsShaArr = [];
        $existsItemsSha = Items::select("sha", "sha_global")->get();
        foreach($existsItemsSha as $existsItemsShaRow){
            $existsItemsShaArr[$existsItemsShaRow->sha] = $existsItemsShaRow->sha_global;
        }
        unset($existsItemsSha);

        try {
            $local_xml = YmlFileHelper::getYmlFile($url);

            $parser = new \YMLParser\YMLParser(new \YMLParser\Driver\XMLReader);  // throws \Exception if $filename doesn't exist or empty
            $parser->open($local_xml);
            foreach($parser->getOffers() as $offer){ // YMLParser::getOffers() returns \Generator
                if(!$offer){
                    continue;
                }

                /** Магия тестирования */
                if(self::TEST){
                    if(rand(0,3) === 1){
                        $offer['price'] = time()/100;
                    }
                }
                /** Вот и вся магия */

                $sha = sha1($url.$offer['id']);
                $sha_global = self::getOfferGlobalSha($offer);

                /** если записи нет в БД */
                if(!isset($existsItemsShaArr[$sha])){
                    /** Магия тестирования */
                    if(self::TEST) {
                        if (rand(0, 1) === 1) {
                            DB::table('items')->insert(self::getOfferArray($offer, $sha, $sha_global));
                            $result['added']++;
                        }
                    } else {
                        DB::table('items')->insert(self::getOfferArray($offer, $sha, $sha_global));
                        $result['added']++;
                    }
                    /** Вот и вся магия */
                /** если запись в БД есть, но данные изменились */
                } else if ($existsItemsShaArr[$sha] !== $sha_global){
                    DB::table('items')
                        ->where('sha', $sha)
                        ->update(self::getOfferArray($offer, $sha_global));
                    $result['updated']++;
                /** если записи в БД есть, и не изменилась */
                } else {
                    $result['missed']++;
                }
            }
        } catch (\Exception $e){
            $result['success'] = 'FAIL';
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * Получить массив данных по товару для БД
     *
     * @param array $offer
     * @param null | string $sha
     * @param null | string $sha_global
     * @return array
     */
    private static function getOfferArray($offer, $sha = null, $sha_global = null)
    {
        $arr = [];
        foreach(self::$offer_fields as $row => $field){
            if($row === 'price'){
                $offer[$field] = $offer[$field] ?? 0;
                $price = str_replace(',', '.', $offer[$field]);
                $price_parts = explode('.', $price);
                $arr['price_main'] = $price_parts[0] ?? 0;
                $arr['price_rest'] = $price_parts[1] ?? 0;
            }
            $arr[$row] = $offer[$field] ?? '';
        }

        if(!is_null($sha)){
            $arr['sha'] = $sha;
        }

        if(!is_null($sha_global)){
            $arr['sha_global'] = $sha_global;
        }

        return $arr;
    }

    /**
     * Получить sha1 всех данных товара
     *
     * @param array $offer
     * @return string
     */
    private static function getOfferGlobalSha($offer)
    {
        return sha1(serialize(self::getOfferArray($offer)));
    }
}
