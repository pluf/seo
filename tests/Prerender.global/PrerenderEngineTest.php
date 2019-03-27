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
class PrerenderGlobalEngineTest extends TestCase
{

    private static $client = null;

    /**
     *
     * @beforeClass
     */
    public static function createDataBase()
    {
        Pluf::start(__DIR__ . '/../conf/config.php');
        $m = new Pluf_Migration(Pluf::f('installed_apps'));
        $m->install();

        // Test user
        $user = new User_Account();
        $user->login = 'test';
        $user->is_active = true;
        if (true !== $user->create()) {
            throw new Exception();
        }
        // Credential of user
        $credit = new User_Credential();
        $credit->setFromFormData(array(
            'account_id' => $user->id
        ));
        $credit->setPassword('test');
        if (true !== $credit->create()) {
            throw new Exception();
        }

        $per = User_Role::getFromString('tenant.owner');
        $user->setAssoc($per);

        // Owner client
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
    }

    /**
     *
     * @afterClass
     */
    public static function removeDatabses()
    {
        $m = new Pluf_Migration(Pluf::f('installed_apps'));
        $m->unInstall();
    }

    /**
     * @test
     */
    public function testClass ()
    {
        $engine = new Seo_Engine_Global();
        $this->assertNotNull($engine);
    }

    /**
     * @test
     */
    public function testRenderPage ()
    {
        $backend = new Seo_Backend();
        // fill
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol = 'symbol';
        $backend->enable = true;
        $backend->home = 'home';
        $backend->engine = 'global';

        // Set meta
        $backend->setMeta('relative', '+2 days');
        $backend->setMeta('pattern', '.*');
        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);

        // http request
        $query = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['SERVER_PROTOCOL'] = 'http';
        $_SERVER['HTTP_HOST'] = 'localhost.com';
        $GLOBALS['_PX_uniqid'] = 'example';

        $request = new Pluf_HTTP_Request($query);
        $request->tenant = new Pluf_Tenant();
        $request->REQUEST['_escaped_fragment_'] = '/submit/2/11';

        // empty view
        $request->view = array(
                'ctrl' => array()
        );

        $seoRequest = new Seo_Request($request);
        $seoRequest->request = $request;
        $page = $backend->render($seoRequest);
        $this->assertNotNull($page);
    }



    /**
     * @test
     */
    public function testRenderPageNotMatchPattern ()
    {
        $backend = new Seo_Backend();
        // fill
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol = 'symbol';
        $backend->enable = true;
        $backend->home = 'home';
        $backend->engine = 'global';

        // Set meta
        $backend->setMeta('relative', '+2 days');
        $backend->setMeta('pattern', '.*random_pattern_address.*');
        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);

        // http request
        $query = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/random_pattern/_address/toThe/Request/'. rand();
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['SERVER_PROTOCOL'] = 'http';
        $_SERVER['HTTP_HOST'] = 'localhost.com';
        $GLOBALS['_PX_uniqid'] = 'example';

        $request = new Pluf_HTTP_Request($query);
        $request->tenant = new Pluf_Tenant();
        $request->REQUEST['_escaped_fragment_'] = '/submit/2/11';

        // empty view
        $request->view = array(
            'ctrl' => array()
        );

        $seoRequest = new Seo_Request($request);
        $seoRequest->request = $request;
        $page = $backend->render($seoRequest);
        $this->assertNotNull($page);
        $this->assertFalse($page);

        $this->assertFalse(Seo_Content::isRegistered($_SERVER['SERVER_PROTOCOL']. '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
    }



    /**
     * @test
     */
    public function testRenderPageMatchPattern ()
    {
        $backend = new Seo_Backend();
        // fill
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol = 'symbol';
        $backend->enable = true;
        $backend->home = 'home';
        $backend->engine = 'global';

        // Set meta
        $backend->setMeta('relative', '+2 days');
        $backend->setMeta('pattern', '.*random_pattern_address.*');
        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);

        // http request
        $query = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/random_pattern_address/toThe/Request/'.rand();
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['SERVER_PROTOCOL'] = 'http';
        $_SERVER['HTTP_HOST'] = 'localhost.com';
        $GLOBALS['_PX_uniqid'] = 'example';

        $request = new Pluf_HTTP_Request($query);
        $request->tenant = new Pluf_Tenant();
        $request->REQUEST['_escaped_fragment_'] = '/submit/2/11';

        // empty view
        $request->view = array(
            'ctrl' => array()
        );

        $seoRequest = new Seo_Request($request);
        $seoRequest->request = $request;
        $page = $backend->render($seoRequest);
        $this->assertNotNull($page);
        $this->assertTrue($page !== false);
        $this->assertTrue(Seo_Content::isRegistered($_SERVER['SERVER_PROTOCOL']. '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
    }
}

