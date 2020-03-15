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

require_once 'Pluf.php';

/**
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class Seo_SiteMap_ModelTest extends TestCase
{

    /**
     *
     * @before
     */
    public function setUpTest()
    {
        Pluf::start(__DIR__ . '/../../conf/config.php');
        $m = new Pluf_Migration();
        $m->install();
        $m->init();
    }

    /**
     * Delete all tables
     *
     * @after
     */
    protected function tearDownTest()
    {
        $m = new Pluf_Migration();
        $m->uninstall();
    }

    /**
     * Creates a class
     *
     * @test
     */
    public function testClass()
    {
        $link = new Seo_SitemapLink();
        $this->assertNotNull($link);
    }

    /**
     * Create new and store
     *
     * @test
     */
    public function createLinkTest()
    {
        $link = new Seo_SitemapLink();
        // fill
        $link->title = 'title';
        $link->description = 'description';
        $link->loc = 'http://www.example.com';
        $link->lastmod = gmdate('Y-m-d H:i:s');
        $link->changefreq = 'weekly';
        $link->priority = 0.6;

        $this->assertTrue($link->create());
        $this->assertNotNull($link);
    }

    /**
     * Create and delete a link
     *
     * @test
     */
    public function createDeleteLinkTest()
    {
        $link = new Seo_SitemapLink();
        // fill
        $link->title = 'title';
        $link->description = 'description';
        $link->loc = 'http://www.example.com';
        $link->lastmod = gmdate('Y-m-d H:i:s');
        $link->changefreq = 'weekly';
        $link->priority = 0.6;

        $this->assertTrue($link->create());
        $this->assertNotNull($link);
        $this->assertTrue($link->delete());
    }
}

