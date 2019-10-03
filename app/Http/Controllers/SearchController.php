<?php

namespace App\Http\Controllers;

use App\Items;
use Illuminate\Http\Request;

/**
 * Класс для реализации живого поиска на главной странице
 *
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{

    /**
     * Автокомплитер для поиска
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sAutocomplete(Request $request)
    {
        $data = Items::select('id', 'name')
            ->where("name", "LIKE", "%{$request->input('term')}%")
            ->limit(20)->orderByRaw("RAND()")->get();
        return response()->json($data);
    }
}
