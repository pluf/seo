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

/**
 * Find an engine.
 *
 * @param string $type
 * @throws Bank_Exception_EngineNotFound
 * @return unknown
 */
function Seo_Shortcuts_GetEngineOr404($type)
{
    $items = Seo_Service::engines();
    foreach ($items as $item) {
        if ($item->getType() === $type) {
            return $item;
        }
    }
    throw new Seo_Exception_EngineNotFound("Engine not found:" . $type);
}

/**
 * Find a backend
 *
 * @param string $id
 * @throws Pluf_HTTP_Error404
 * @return Seo_Backend
 */
function Seo_Shortcuts_GetBackendOr404($id)
{
    $item = new Seo_Backend($id);
    if ((int) $id > 0 && $item->id == $id) {
        return $item;
    }
    throw new Pluf_HTTP_Error404("Backend not found (" . $id . ")");
}

/**
 * Checks given URL to be unique and not registered before.
 *
 * It is used in the forms.
 *
 * @param string $url
 * @throws Pluf_Exception
 * @return string
 */
function Seo_Shortcuts_CleanUrl($url)
{
    $q = new Pluf_SQL('url=%s', array(
        $url
    ));
    $items = Pluf::factory('Seo_Content')->getList(array(
        'filter' => $q->gen()
    ));
    if (! isset($items) || $items->count() == 0) {
        return $url;
    }
    throw new Pluf_Exception(sprintf(__('An seo-content with the same URL exist (URL: %s'), $url));
}

/**
 * Get content based on name
 *
 * @param string $name
 * @throws Pluf_Exception_DoesNotExist
 * @return ArrayObject
 */
function Seo_Shortcuts_GetSeoContentByUrlOr404($url)
{
    $q = new Pluf_SQL('url=%s', array(
        $url
    ));
    $item = new Seo_Content();
    $item = $item->getList(array(
        'filter' => $q->gen()
    ));
    if (isset($item) && $item->count() == 1) {
        return $item[0];
    }
    if ($item->count() > 1) {
        Pluf_Log::error(sprintf('more than one content exist with the URL $s', $url));
        return $item[0];
    }
    throw new Pluf_Exception_DoesNotExist("Seo content not found (Content URL:" . $url . ")");
}