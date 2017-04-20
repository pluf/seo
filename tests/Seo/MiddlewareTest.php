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
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\IncompleteTestError;

require_once 'Pluf.php';

/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class MiddlewareTest extends TestCase
{
    
    /**
     * @before
     */
    public function setUp ()
    {
        Pluf::start(dirname(__FILE__) . '/config.php');
        $m = require dirname(__FILE__) . '/../../src/Seo/relations.php';
        $GLOBALS['_PX_models'] = array_merge($m, $GLOBALS['_PX_models']);
        $GLOBALS['_PX_config']['pluf_use_rowpermission'] = false;
        $db = Pluf::db();
        $schema = Pluf::factory('Pluf_DB_Schema', $db);
        $m1 = new Seo_Backend();
        $schema->model = $m1;
        $schema->dropTables();
        $schema->createTables();
    }
    
    /**
     * Delete all tables
     *
     * @after
     */
    protected function tearDown ()
    {
        $db = Pluf::db();
        $schema = Pluf::factory('Pluf_DB_Schema', $db);
        $m1 = new Seo_Backend();
        $schema->model = $m1;
        $schema->dropTables();
    }
    
    /**
     * Test middleware class exist
     * 
     * @test
     */
    public function testClass ()
    {
        $middleware = new Seo_Middleware_Render();
        $this->assertNotNull($middleware);
    }
    
    /**
     * Test non-bot requests
     *
     * @test
     */
    public function nonBotRequest ()
    {
        $query = '/example/resource';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';
        
        $middleware = new Seo_Middleware_Render();
        $request = new Pluf_HTTP_Request($query);
        $request->tenant = new Pluf_Tenant();
        
        // empty view
        $request->view = array(
                'ctrl' => array()
        );
        
        $response = $middleware->process_request($request);
        $this->assertFalse($response);
    }
    
    /**
     * Test empty backend
     *
     * @test
     */
    public function botRequest ()
    {
        $query = '/example/resource';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';
        
        $middleware = new Seo_Middleware_Render();
        $request = new Pluf_HTTP_Request($query);
        $request->tenant = new Pluf_Tenant();
        $request->GET['_escaped_fragment_'] = '/home';
        
        // empty view
        $request->view = array(
                'ctrl' => array()
        );
        
        $response = $middleware->process_request($request);
        $this->assertNotNull($response);
    }
    
}

