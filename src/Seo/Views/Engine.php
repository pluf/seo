<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
Pluf::loadFunction('Seo_Shortcuts_GetEngineOr404');

/**
 *
 * @author maso <mostafa.barmsohry@dpq.co.ir>
 *        
 */
class Seo_Views_Engine
{

    /**
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function find($request, $match)
    {
        // XXX: maso, 1395:
        $items = Seo_Service::engines();
        $page = array(
            'items' => $items,
            'counts' => count($items),
            'current_page' => 0,
            'items_per_page' => count($items),
            'page_number' => 1
        );
        return new Pluf_HTTP_Response_Json($page);
    }

    /**
     *
     * پارامترهایی که در این نمایش به عنوان ورودی در نظر گرفته می‌شوند عبارتند
     * از:
     *
     * <ul>
     * <li>type: نوع متور جستجو را تعیین می‌کند</li>
     * </ul>
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function get($request, $match)
    {
        $engine = Seo_Shortcuts_GetEngineOr404($match['type']);
        return $engine->getParameters();
    }

    // /**
    // *
    // * @param Pluf_HTTP_Request $request
    // * @param array $match
    // */
    // public function createParameter ($request, $match)
    // {
    // $type = 'not set';
    // if (array_key_exists('type', $request->REQUEST)) {
    // $type = $request->REQUEST['type'];
    // }else if(array_key_exists('type', $match)){
    // $type = $match['type'];
    // }
    // $engine = Seo_Shortcuts_GetEngineOr404($type);
    // return $engine->getParameters();
    // }
}
