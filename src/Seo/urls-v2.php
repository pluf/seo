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
return array(
    // اطلاعات بسته
    array(
        'regex' => '#^/$#',
        'model' => 'Seo_Views_Main',
        'method' => 'module',
        'http-method' => array(
            'GET'
        )
    ),
    array(
        'regex' => '#^/engines$#',
        'model' => 'Seo_Views_Engine',
        'method' => 'find',
        'http-method' => array(
            'GET'
        )
    ),
    array(
        'regex' => '#^/engines/(?P<type>.+)$#',
        'model' => 'Seo_Views_Engine',
        'method' => 'get',
        'http-method' => array(
            'GET'
        )
    ),

    /**
     * ********************************************************************
     * SitemapLink
     * ********************************************************************
     */
    array( // Find
        'regex' => '#^/backends$#',
        'model' => 'Pluf_Views',
        'method' => 'findObject',
        'http-method' => 'GET',
        'precond' => array(
            'User_Precondition::ownerRequired'
        ),
        'params' => array(
            'model' => 'Seo_Backend'
        )
    ),
    array(
        'regex' => '#^/backends/(?P<type>[^/]+)/properties$#',
        'model' => 'Seo_Views_Backend',
        'method' => 'createParameter',
        'http-method' => array(
            'GET'
        )
    ),
    array(
        'regex' => '#^/backends$#',
        'model' => 'Seo_Views_Backend',
        'method' => 'create',
        'http-method' => array(
            'PUT',
            'POST'
        )
    ),
    array(
        'regex' => '#^/backends/(?P<id>\d+)$#',
        'model' => 'Seo_Views_Backend',
        'method' => 'get',
        'http-method' => array(
            'GET'
        )
    ),
    array(
        'regex' => '#^/backends/(?P<id>\d+)$#',
        'model' => 'Seo_Views_Backend',
        'method' => 'update',
        'http-method' => array(
            'POST'
        )
    ),
    array( // Delete
        'regex' => '#^/backends/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'deleteObject',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::ownerRequired'
        ),
        'params' => array(
            'model' => 'Seo_Backend',
            'permanently' => true
        )
    ),

    /**
     * ********************************************************************
     * SitemapLink
     * ********************************************************************
     */
    array( // Find
        'regex' => '#^/links$#',
        'model' => 'Pluf_Views',
        'method' => 'findObject',
        'http-method' => 'GET',
        'precond' => array(
            'User_Precondition::ownerRequired'
        ),
        'params' => array(
            'model' => 'Seo_SitemapLink'
        )
    ),
    array( // Create
        'regex' => '#^/links$#',
        'model' => 'Pluf_Views',
        'method' => 'createObject',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        ),
        'params' => array(
            'model' => 'Seo_SitemapLink'
        )
    ),
    array( // Get info
        'regex' => '#^/links/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getObject',
        'http-method' => 'GET',
        'precond' => array(
            'User_Precondition::ownerRequired'
        ),
        'params' => array(
            'model' => 'Seo_SitemapLink'
        )
    ),
    array( // Delete
        'regex' => '#^/links/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'deleteObject',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::ownerRequired'
        ),
        'params' => array(
            'model' => 'Seo_SitemapLink',
            'permanently' => true
        )
    ),
    array( // Update
        'regex' => '#^/links/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'updateObject',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        ),
        'params' => array(
            'model' => 'Seo_SitemapLink'
        )
    ),
    /**
     * ********************************************************************
     * Sitemap
     * ********************************************************************
     */
    array(
        'regex' => '#^/sitemap/sitemap.xml$#',
        'model' => 'Seo_Views_Sitemap',
        'method' => 'get',
        'http-method' => 'GET',
        'precond' => array()
    ),
    array(
        'regex' => '#^/xsl/(?P<style>[^/]+).xsl$#',
        'model' => 'Seo_Views_Xsl',
        'method' => 'get',
        'http-method' => 'GET',
        'precond' => array()
    )
);