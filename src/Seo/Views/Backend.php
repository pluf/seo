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
class Seo_Views_Backend
{

    /**
     * یک نمونه جدید از متور پرداخت ایجاد می‌کند.
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     */
    public function create ($request, $match)
    {
        $type = 'not set';
        if (array_key_exists('type', $request->REQUEST)) {
            $type = $request->REQUEST['type'];
        }
        $engine = Seo_Shortcuts_GetEngineOr404($type);
        $params = array(
                'engine' => $engine
        );
        // Save meta
        $form = new Seo_Form_BackendNew($request->REQUEST, $params);
        $backend = $form->save();
        return $backend;
    }

    /**
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     */
    public function get ($request, $match)
    {
        $backend = Seo_Shortcuts_GetBackendOr404($match['id']);
        return $backend;
    }

    /**
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     */
    public function delete ($request, $match)
    {
        $backend = Seo_Shortcuts_GetBackendOr404($match['id']);
        $backend->delete();
        return $backend;
    }

    /**
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     */
    public function update ($request, $match)
    {
        $backend = Seo_Shortcuts_GetBackendOr404($match['id']);
        $params = array(
                'backend' => $backend
        );
        $form = new Seo_Form_BackendUpdate($request->REQUEST, $params);
        $backend = $form->update();
        return $backend;
    }
}
