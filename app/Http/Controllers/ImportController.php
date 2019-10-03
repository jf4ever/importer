<?php

namespace App\Http\Controllers;

use App\YmlParser;
use Illuminate\Support\Facades\Config;

/**
 * Контроллер для импорта
 *
 * Class ImportController
 * @package App\Http\Controllers
 */
class ImportController extends Controller
{
    /**
     * Страница с кнопкой запустить импорт
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('import.index');
    }

    /**
     * Запустить импорт
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importStart()
    {
        $result = [];
        /** получаем список адресов для парсинга из конфига */
        $import_urls = Config::get('import_urls');
        foreach($import_urls as $import_url){
            /** запускаем испорт по каждому Url */
            $result[$import_url] = YmlParser::getOffers($import_url);
        }

        /** views/imports/result.blade.php */
        return view('import.result', ['result' => $result]);
    }
}
