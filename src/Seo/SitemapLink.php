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
 * # Properties
 *
 * Main properites of a link is fully described here. The others are used
 * in view and other part of the system.
 *
 * ## loc
 *
 * URL of the page. This URL must begin with the protocol (such as http)
 * and end with a trailing slash, if your web server requires it. This
 * value must be less than 2,048 characters.
 *
 * ## lastmod
 *
 * The date of last modification of the file. This date should be in W3C
 * Datetime format. This format allows you to omit the time portion, if
 * desired, and use YYYY-MM-DD.
 *
 * ## changefreq
 *
 * How frequently the page is likely to change. This value provides general
 * information to search engines and may not correlate exactly to how often
 * they crawl the page. Valid values are:
 *
 * - always
 * - hourly
 * - daily
 * - weekly
 * - monthly
 * - yearly
 * - never
 *
 *
 * The value "always" should be used to describe documents that change each time
 * they are accessed. The value "never" should be used to describe archived URLs.
 *
 * ## priority
 *
 * The priority of this URL relative to other URLs on your site. Valid values
 * range from 0.0 to 1.0. This value does not affect how your pages are
 * ompared to pages on other sites—it only lets the search engines know
 * which pages you deem most important for the crawlers.
 * The default priority of a page is 0.5.
 *
 * @see https://www.sitemaps.org/protocol.html
 *
 * @author Mostafa Barmshori<mostafa.barmshory@dpq.co.ir>
 *        
 */
class Seo_SitemapLink extends Pluf_Model
{

    /**
     *
     * @see Pluf_Model::init()
     */
    function init()
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
                'blank' => false,
                'size' => 2048,
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
                'blank' => true,
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
//             'creation_dtime' => array(
//                 'type' => 'Pluf_DB_Field_Datetime',
//                 'blank' => true,
//                 'verbose' => 'creation date',
//                 'editable' => false,
//                 'readable' => true
//             ),
//             'modif_dtime' => array(
//                 'type' => 'Pluf_DB_Field_Datetime',
//                 'blank' => true,
//                 'verbose' => 'modification date',
//                 'editable' => false,
//                 'readable' => true
//             )
        );
    }

//     /*
//      * @see Pluf_Model::preSave()
//      */
//     function preSave($create = false)
//     {
//         if ($this->id == '') {
//             $this->creation_dtime = gmdate('Y-m-d H:i:s');
//         }
//         $this->modif_dtime = gmdate('Y-m-d H:i:s');
//     }
}

