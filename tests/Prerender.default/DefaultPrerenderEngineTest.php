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
class DefaultPrerenderGlobalEngineTest extends TestCase
{

    private static $client = null;

    /**
     *
     * @beforeClass
     */
    public static function createDataBase()
    {
        $cfg = include(__DIR__ . '/../conf/config.php');
        $cfg['seo.prerender.default.engine'] = 'global';
        $cfg['seo.prerender.default.enable'] = true;
        $cfg['seo.prerender.default.period'] = '+7 days';
        $cfg['seo.prerender.default.pattern'] = '.*';
        
        Pluf::start($cfg);
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
     * Test non-bot requests
     *
     * @test
     */
    public function nonBotRequest()
    {
        $query = '/example/resource';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.89 Safari/537.36';
        $middleware = new Seo_Middleware_Render();
        $request = new Pluf_HTTP_Request($query);
        $request->tenant = new Pluf_Tenant();
        $request->REQUEST = array();
        
        // empty view
        $request->view = array(
            'ctrl' => array()
        );
        
        $response = $middleware->process_request($request);
        Test_Assert::assertFalse($response, 'Test result must be false for non bot');
    }
    
    /**
     * Test empty backend
     *
     * @test
     */
    public function botRequest()
    {
        $query = '/example/resource';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.89 Safari/537.36';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';
        $_GET['_escaped_fragment_'] = '/home';
        $_REQUEST['_escaped_fragment_'] = '/home';
        
        $middleware = new Seo_Middleware_Render();
        $request = new Pluf_HTTP_Request($query);
        $request->tenant = new Pluf_Tenant();
        
        // empty view
        $request->view = array(
            'ctrl' => array()
        );
        
        $response = $middleware->process_request($request);
        Test_Assert::assertNotNull($response);
        Test_Assert::assertNotEquals(false, $response, 'Response must not be false for bot');
    }
    
}
