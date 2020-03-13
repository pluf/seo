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
 * Render engine to render pages
 *
 * @author maso<mostafa.barmshory@dpq.co.ir>
 *        
 */
class Seo_Request
{

    /**
     * Render backend
     *
     * @var Seo_Backend
     */
    var $backend;

    /**
     * Base request
     *
     * @var Pluf_HTTP_Request
     */
    var $request;

    /**
     * Creates new instance of this class
     *
     * @param Pluf_HTTP_Request $request
     */
    function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get meta datea
     *
     * @param string $key
     *            of the meta data
     * @param string $default
     *            value of the meta data
     * @return string current value
     */
    public function get_meta($key, $default)
    {
        return $this->backend->getMeta($key, $default);
    }

    /**
     * Gets base URL
     *
     * @return string
     */
    public function get_base()
    {
        return ($this->request->https ? "https" : "http") . "://" . $this->request->http_host . $this->request->uri;
    }

    /**
     * Gets fragment
     *
     * @return string
     */
    public function get_fragment()
    {
        return $this->request->REQUEST['_escaped_fragment_'];
    }

    /**
     *
     * @return array
     */
    public function get_headers()
    {
        return $this->request->HEADERS;
    }

    /**
     * List of request parameters
     */
    public function get_parameters()
    {
        return $this->request->REQUEST;
    }
}