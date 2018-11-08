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
    // Module information
    array(
        'regex' => '#^/$#',
        'model' => 'Seo_Views_Main',
        'method' => 'module',
        'http-method' => array(
            'GET'
        )
    ),
    /**
     * ********************************************************************
     * Engine
     * ********************************************************************
     */
    array(
        'regex' => '#^/engines$#',
        'model' => 'Seo_Views_Engine',
        'method' => 'find',
        'http-method' => array(
            'GET'
        )
    ),
    array(
        'regex' => '#^/engines/(?P<type>[^/]+)$#',
        'model' => 'Seo_Views_Engine',
        'method' => 'get',
        'http-method' => array(
            'GET'
        )
    ),
    array(
        'regex' => '#^/engines/(?P<type>[^/]+)/properties$#',
        'model' => 'Seo_Views_Engine',
        'method' => 'createParameter',
        'http-method' => array(
            'GET'
        )
    ),

    /**
     * ********************************************************************
     * Backend
     * ********************************************************************
     */
    array( // List
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
    array( // Create
        'regex' => '#^/backends$#',
        'model' => 'Seo_Views_Backend',
        'method' => 'create',
        'http-method' => array(
            'PUT',
            'POST'
        )
    ),
    array( // Read
        'regex' => '#^/backends/(?P<id>\d+)$#',
        'model' => 'Seo_Views_Backend',
        'method' => 'get',
        'http-method' => array(
            'GET'
        )
    ),
    array( // Update
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
     * Seo Content
     * ********************************************************************
     */
    array( // Create
        'regex' => '#^/contents$#',
        'model' => 'Seo_Views_Content',
        'method' => 'createOrUpdate',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read (list)
        'regex' => '#^/contents$#',
        'model' => 'Seo_Views_Content',
        'method' => 'find',
        'http-method' => 'GET'
    ),
    array( // Read
        'regex' => '#^/contents/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'Seo_Content'
        )
    ),
    array( // Update
        'regex' => '#^/contents/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'updateObject',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        ),
        'params' => array(
            'model' => 'Seo_Content'
        )
    ),
    array( // Delete
        'regex' => '#^/contents/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'deleteObject',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::ownerRequired'
        ),
        'params' => array(
            'model' => 'Seo_Content'
        )
    ),
    // Binary content of Seo_Content
    array( // Read
        'regex' => '#^/contents/(?P<modelId>\d+)/content$#',
        'model' => 'Seo_Views_Content',
        'method' => 'download',
        'http-method' => 'GET',
        // Cache param
        'cacheable' => true,
        'revalidate' => true,
        'intermediate_cache' => true,
        'max_age' => 25000
    ),
    array( // Update
        'regex' => '#^/contents/(?P<modelId>\d+)/content$#',
        'model' => 'Seo_Views_Content',
        'method' => 'updateFile',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::loginRequired'
        )
    ),

    // Note: Should be the last url in the contents
    array( // Read (by url)
        'regex' => '#^/contents/(?P<url>.+)$#',
        'model' => 'Seo_Views_Content',
        'method' => 'get',
        'http-method' => 'GET'
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