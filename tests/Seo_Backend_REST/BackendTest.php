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
use PHPUnit\Framework\IncompleteTestError;
require_once 'Pluf.php';

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/../Base/');

/**
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class Seo_Backend_REST_BackendTest extends AbstractBasicTest
{

    private static $client = null;

    private static $ownerClient = null;

    /**
     *
     * @beforeClass
     */
    public static function installApps()
    {
        parent::installApps();

        // Anonymouse client
        self::$client = new Test_Client(array(
            array(
                'app' => 'Seo',
                'regex' => '#^/api/v2/seo#',
                'base' => '',
                'sub' => include 'Seo/urls-v2.php'
            ),
            array(
                'app' => 'User',
                'regex' => '#^/api/v2/user#',
                'base' => '',
                'sub' => include 'User/urls-v2.php'
            )
        ));
        // Owner client
        self::$ownerClient = new Test_Client(array(
            array(
                'app' => 'Seo',
                'regex' => '#^/api/v2/seo#',
                'base' => '',
                'sub' => include 'Seo/urls-v2.php'
            ),
            array(
                'app' => 'User',
                'regex' => '#^/api/v2/user#',
                'base' => '',
                'sub' => include 'User/urls-v2.php'
            )
        ));
        // Login
        $response = self::$ownerClient->post('/api/v2/user/login', array(
            'login' => 'test',
            'password' => 'test'
        ));
        Test_Assert::assertNotNull($response);
        Test_Assert::assertEquals($response->status_code, 200);
    }

    /**
     * Getting list of Seo-Backends
     *
     * @test
     */
    public function listSeoBackendsRestTest()
    {
        // Add a seo backend manually
        $backend = new Seo_Backend();
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol = 'http://www.example.com';
        $backend->home = 'http://www.example.com';
        $backend->enable = true;
        $backend->engine = 'weekly';
        $backend->setMeta('test', 'test');
        $backend->create(); // get list (owner access)
        $response = self::$ownerClient->get('/api/v2/seo/backends');
        Test_Assert::assertResponseNotNull($response, 'Find result is empty');
        Test_Assert::assertResponseStatusCode($response, 200, 'Find status code is not 200');
        Test_Assert::assertResponsePaginateList($response, 'Find result is not JSON paginated list');
    }

    /**
     *
     * @test
     */
    public function createSeoBackendsRestTest()
    {
        // Add a link
        $backend = new Seo_Backend();
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol = 'http://www.example.com';
        $backend->home = 'http://www.example.com';
        $backend->enable = true;
        $backend->engine = 'fake';
        $backend->setMeta('test', 'test');
        $backend->create(); // Create
        $response = self::$ownerClient->post('/api/v2/seo/backends', array(
            'title' => 'title',
            'description' => 'description',
            'symbol' => 'http://www.example.com',
            'home' => 'http://www.example.com',
            'enable' => 1,
            'type' => 'fake',
            'test' => 'test'
        ));
        Test_Assert::assertResponseNotNull($response, 'Find result is empty');
        Test_Assert::assertResponseStatusCode($response, 200, 'Find status code is not 200');
    }

    /**
     *
     * @test
     */
    public function createSeoBackendsRestTest2bool()
    {
        // Add a link
        $backend = new Seo_Backend();
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol = 'http://www.example.com';
        $backend->home = 'http://www.example.com';
        $backend->enable = true;
        $backend->engine = 'fake';
        $backend->setMeta('test', 'test');
        $backend->create();

        // Create Link
        $response = self::$ownerClient->post('/api/v2/seo/backends', array(
            'title' => 'title',
            'description' => 'description',
            'symbol' => 'http://www.example.com',
            'home' => 'http://www.example.com',
            'enable' => 'true',
            'type' => 'fake',
            'test' => 'test'
        ));
        Test_Assert::assertResponseNotNull($response, 'Find result is empty');
        Test_Assert::assertResponseStatusCode($response, 200, 'Find status code is not 200');
    }
}



