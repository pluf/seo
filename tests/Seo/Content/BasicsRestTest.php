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
use Pluf\Test\Client;
require_once 'Pluf.php';

/**
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class Seo_Content_REST_BasicsTest extends TestCase
{

    /**
     *
     * @beforeClass
     */
    public static function createDataBase()
    {
        Pluf::start(__DIR__ . '/../../conf/config.php');
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
     *
     * @test
     */
    public function listUsersRestTest()
    {
        $client = new Client();
        $response = $client->get('/seo/contents');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function loginRestTest()
    {
        $client = new Client();

        // login
        $response = $client->post('/user/login', array(
            'login' => 'test',
            'password' => 'test'
        ));
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);

        // create
        $form = array(
            'url' => 'www.test.com/test/url-' . rand(),
            'title' => 'test content',
            'description' => 'This is a simple content is used int test process',
            'mime_type' => 'text/html'
        );
        $response = $client->post('/seo/contents', $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);

        // Get by id
        $content = new Seo_Content();
        $content->name = 'test content' . rand();
        $content->mime_type = 'text/html';
        $content->create();

        $response = $client->get('/seo/contents/' . $content->id);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);

        // Update by id
        $response = $client->post('/seo/contents/' . $content->id, array(
            'title' => 'new title'
        ));
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);

        // delete by id
        $response = $client->delete('/seo/contents/' . $content->id);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test if the link is added automatically
     *
     * @test
     */
    public function registerUnknownContent()
    {
        // Add a backend
        $backend = new Seo_Backend();
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol = 'http://www.example.com';
        $backend->home = 'http://www.example.com';
        $backend->enable = true;
        $backend->engine = 'manual';
        $backend->setMeta('autoRegister', 'true');
        $backend->create();

        // call to get a link with crawler
        $pageAddress = '/random/page/test-page-' . rand();
        $client = new Client();
        $client->get($pageAddress);

        // Check if link is registered
        $url = "http://localhost" . $pageAddress;
        $this->assertTrue(Seo_Content::isRegistered($url), 'Page is not registred');

        $content = Seo_Content::getContent($url);
        $this->assertNotNull($content, 'Page not found');
        $this->assertTrue($content->isExpired(), 'Page is not expired');

        $backend->delete();
        $content->delete();
    }
}



