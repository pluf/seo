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
class Seo_Engine_Fake extends Seo_Engine
{

    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::getTitle()
     */
    public function getTitle ()
    {
        return 'Fake render';
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::getDescription()
     */
    public function getDescription ()
    {
        return 'Engine to generate empty page.';
    }


    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::render()
     */
    public function render ($request)
    {
        return "<h1>Bot are not allowd</h1>";
    }
}
