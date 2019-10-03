<?php

namespace App\Http\Controllers;

use App\Items;
use App\YmlFileHelper;

/**
 * Класс вывода списка товаров и одного товара
 *
 * Class ItemsController
 * @package App\Http\Controllers
 */
class ItemsController extends Controller
{
    /**
     * Главная страница
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function items()
    {
        $data = Items::limit(20)->orderByRaw("RAND()")->get();
        return view('items', compact(['data']));
    }

    /**
     * Вид одного товара
     *
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function item($id)
    {
        $data = Items::select("id", "name", "price", "description", "url", "picture")
            ->where("id", "=", "{$id}")
            ->first();
        return view('item', compact(['data']));
    }

}
