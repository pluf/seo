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
class Seo_MiddlewareResourceTest extends TestCase
{

    /**
     * @before
     */
    public function setUpTest()
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
    protected function tearDownTest()
    {
        $db = Pluf::db();
        $schema = Pluf::factory('Pluf_DB_Schema', $db);
        $m1 = new Seo_Backend();
        $schema->model = $m1;
        $schema->dropTables();
    }

    /**
     * Test non-bot requests
     *
     * @test
     */
    public function shouldNotRenderCssFroCommonAgent()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';

        $middleware = new Seo_Middleware_Render();
        $queries = [
            '/example/resource.css',
            '/example/resource.png',
            '/resource.gif',
            '/fonts/fonts.ttf'
        ];
        foreach ($queries as $query) {
            $request = new Pluf_HTTP_Request($query);
            $request->tenant = new Pluf_Tenant();
            $request->view = array(
                'ctrl' => array()
            );
            $response = $middleware->process_request($request);
            Test_Assert::assertFalse($response, 'Resource is renderd');
        }
    }

    /**
     * Test empty backend
     *
     * @test
     */
    public function shouldNotRenderResourceFroAjaxProtocol()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';

        $middleware = new Seo_Middleware_Render();

        $queries = [
            '/example/resource.css',
            '/example/resource.png',
            '/resource.gif',
            '/fonts/fonts.ttf'
        ];
        foreach ($queries as $query) {
            $request = new Pluf_HTTP_Request($query);
            $request->tenant = new Pluf_Tenant();
            $request->view = array(
                'ctrl' => array()
            );
            $request->GET['_escaped_fragment_'] = '/home';
            $response = $middleware->process_request($request);
            Test_Assert::assertFalse($response, 'Resource is renderd');
        }
    }

    /**
     * Test empty backend
     *
     * @test
     */
    public function shouldSupportCommonBots()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';

        $middleware = new Seo_Middleware_Render();

        $agents = [
            'Mozilla/5.0 (compatible; Sosospider/2.0; +http://help.soso.com/webspider.htm)', // Sosospider
            'Mozilla/5.0 (seoanalyzer; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)' // Bing
        ];
        foreach ($agents as $agent) {
            $_SERVER['HTTP_USER_AGENT'] = $agent;
            $queries = [
                '/example/resource.css',
                '/example/resource.png',
                '/resource.gif',
                '/fonts/fonts.ttf'
            ];
            foreach ($queries as $query) {
                $request = new Pluf_HTTP_Request($query);
                $request->tenant = new Pluf_Tenant();
                $request->agent = $agent;
                $request->method = 'GET';
                $request->view = array(
                    'ctrl' => array()
                );
                $response = $middleware->process_request($request);
                Test_Assert::assertFalse($response, 'Resource is renderd');
            }
        }
    }

    /**
     * Test empty backend
     *
     * @test
     */
    public function shouldIgnoreCommonResources()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';

        $middleware = new Seo_Middleware_Render();

        $agents = [
            'Mozilla/5.0 (compatible; Sosospider/2.0; +http://help.soso.com/webspider.htm)', // Sosospider
            'Mozilla/5.0 (seoanalyzer; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)' // Bing
        ];
        foreach ($agents as $agent) {
            $_SERVER['HTTP_USER_AGENT'] = $agent;
            $queries = [
                '/scripts/vendor.js',
                '/scripts/scripts.js',
                '/style/vendor.css',
                '/style/main.css',
                '/manifest.appcache'
            ];
            foreach ($queries as $query) {
                $request = new Pluf_HTTP_Request($query);
                $request->tenant = new Pluf_Tenant();
                $request->view = array(
                    'ctrl' => array()
                );
                $request->agent = $agent;
                $request->method = 'GET';
                $response = $middleware->process_request($request);
                Test_Assert::assertFalse($response, 'Resource is renderd');
            }
        }
    }
}
