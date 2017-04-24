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
class Seo_SitemapLink extends Pluf_Model
{

    /**
     *
     * @see Pluf_Model::init()
     */
    function init ()
    {
        $this->_a['table'] = 'seo_sitemap_link';
        $this->_a['cols'] = array(
                'id' => array(
                        'type' => 'Pluf_DB_Field_Sequence',
                        'blank' => true,
                        'verbose' => 'unique and no repreducable id fro reception'
                ),
                'title' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => true,
                        'size' => 50,
                        'editable' => true,
                        'readable' => true
                ),
                'description' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => true,
                        'size' => 200,
                        'editable' => true,
                        'readable' => true
                ),
                'loc' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => true,
                        'size' => 50,
                        'editable' => true,
                        'readable' => true
                ),
                'lastmod' => array(
                        'type' => 'Pluf_DB_Field_Datetime',
                        'blank' => true,
                        'verbose' => 'last modification date',
                        'editable' => true,
                        'readable' => true
                ),
                'changefreq' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => false,
                        'size' => 16,
                        'editable' => true,
                        'readable' => true
                ),
                'priority' => array(
                        'type' => 'Pluf_DB_Field_Float',
                        'blank' => true,
                        'editable' => true,
                        'readable' => true
                ),
                
                'creation_dtime' => array(
                        'type' => 'Pluf_DB_Field_Datetime',
                        'blank' => true,
                        'verbose' => 'creation date',
                        'editable' => false,
                        'readable' => true
                ),
                'modif_dtime' => array(
                        'type' => 'Pluf_DB_Field_Datetime',
                        'blank' => true,
                        'verbose' => 'modification date',
                        'editable' => false,
                        'readable' => true
                )
        );
    }
    
    
    /*
     * @see Pluf_Model::preSave()
     */
    function preSave ($create = false)
    {
        if ($this->id == '') {
            $this->creation_dtime = gmdate('Y-m-d H:i:s');
        }
        $this->modif_dtime = gmdate('Y-m-d H:i:s');
    }
}

