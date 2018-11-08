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
class Seo_SiteMap_REST_XmlTest extends TestCase
{

    private static $client = null;

    private static $user = null;

    /**
     * @beforeClass
     */
    public static function createDataBase()
    {
        Pluf::start(array(
            'general_domain' => 'localhost',
            'general_admin_email' => array(
                'root@localhost'
            ),
            'general_from_email' => 'test@localhost',
            'middleware_classes' => array(
                'Pluf_Middleware_Session'
            ),
            'debug' => true,
            'test_unit' => true,
            'languages' => array(
                'fa',
                'en'
            ),
            'tmp_folder' => dirname(__FILE__) . '/../tmp',
            'template_folders' => array(
                dirname(__FILE__) . '/../templates',
                dirname(__FILE__) . '/../../src/Seo/templates'
            ),
            'template_tags' => array(
                'now' => 'Pluf_Template_Tag_Now',
                'cfg' => 'Pluf_Template_Tag_Cfg'
            ),
            'upload_path' => dirname(__FILE__) . '/../tmp',
            'time_zone' => 'Asia/Tehran',
            'encoding' => 'UTF-8',
            
            'secret_key' => '5a8d7e0f2aad8bdab8f6eef725412850',
            'user_signup_active' => true,
            'user_avatra_max_size' => 2097152,
            'db_engine' => 'MySQL',
            'db_version' => '5.5.33',
            'db_login' => 'root',
            'db_password' => '',
            'db_server' => 'localhost',
            'db_database' => 'test',
            'db_table_prefix' => '_test_spa_rest_',
            
            'mail_backend' => 'mail',
            'user_avatar_default' => dirname(__FILE__) . '/../conf/avatar.svg'
        ));
        $m = new Pluf_Migration(array(
            'Pluf',
            'User',
            'Seo'
        ));
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
     * @afterClass
     */
    public static function removeDatabses()
    {
        $m = new Pluf_Migration(array(
            'Pluf',
            'User',
            'Seo'
        ));
        $m->unInstall();
    }

    /**
     * @test
     */
    public function listSapsRestTest()
    {
        // Add a link
        $link = new Seo_SitemapLink();
        $link->title = 'title';
        $link->description = 'description';
        $link->loc = 'http://www.example.com';
        $link->lastmod = gmdate('Y-m-d H:i:s');
        $link->changefreq = 'weekly';
        $link->priority = 0.6;
        $link->create();
        
        // get list
        $response = self::$client->get('/api/v2/seo/sitemap/sitemap.xml');
        Test_Assert::assertResponseNotNull($response, 'Find result is empty');
        Test_Assert::assertResponseStatusCode($response, 200, 'Find status code is not 200');
        Test_Assert::assertTrue(preg_match('/http:\/\/www\.example\.com/', $response->content) === 1, 'Link must exist in the generated site map');
    }
}



