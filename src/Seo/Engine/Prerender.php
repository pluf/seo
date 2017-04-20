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

/**
 *
 * @author maso<mostafa.barmshory@dpq.co.ir>
 *        
 */
class Seo_Engine_Prerender extends Seo_Engine
{

    /*
     *
     */
    public function getTitle ()
    {
        return 'Prerender.io';
    }

    /*
     *
     */
    public function getDescription ()
    {
        return 'Engine of Prerender.io like services.';
    }

    /*
     * @see Seo_Engine#getExtraParam()
     */
    public function getExtraParam ()
    {
        return array(
                array(
                        'name' => 'token',
                        'type' => 'String',
                        'unit' => 'none',
                        'title' => 'Token',
                        'description' => 'Prerender.io token of a user.',
                        'editable' => true,
                        'visible' => true,
                        'priority' => 5,
                        'symbol' => 'key',
                        'defaultValue' => 'xxx',
                        'validators' => [
                                'NotNull',
                                'NotEmpty'
                        ]
                ),
                array(
                        'name' => 'url',
                        'type' => 'String',
                        'unit' => 'none',
                        'title' => 'Service URL',
                        'description' => 'URL of the Prerender.io link.',
                        'editable' => true,
                        'visible' => true,
                        'priority' => 10,
                        'symbol' => 'key',
                        'defaultValue' => 'http://service.prerender.io',
                        'validators' => [
                                'NotNull',
                                'NotEmpty'
                        ]
                )
        );
    }

    /**
     */
    public function render ($receipt)
    {
        // XXX: maso, 1395: ایجاد یک پرداخت
    }
}
