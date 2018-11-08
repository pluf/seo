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
 * Cached Content data model for SEO usage
 *
 * @author hadi <mohammad.hadi.mansouri@dpq.co.ir>
 * @author maso <mostafa.barmshory@dpq.co.ir>
 *        
 */
class Seo_Content extends Pluf_Model
{

    /**
     * مدل داده‌ای را بارگذاری می‌کند.
     *
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'seo_contents';
        $this->_a['cols'] = array(
            // ID
            'id' => array(
                'type' => 'Pluf_DB_Field_Sequence',
                'blank' => false,
                'verbose' => 'first name',
                'help_text' => 'id',
                'editable' => false
            ),
            // Fields
            'url' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => false,
                'is_null' => false,
                'size' => 2000,
                // 'unique' => true,
                'verbose' => 'URL of cached content',
                'help_text' => 'URL which cached content will be shown from that',
                'editable' => true
            ),
            'url_id' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => false,
                'is_null' => false,
                'unique' => true,
                'size' => 150,
                'help_text' => 'Unique identifier for URL, Format: [algo]:[hash]',
                'editable' => false,
                'readable' => false
            ),
            'title' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => true,
                'size' => 250,
                'default' => 'no title',
                'verbose' => 'title',
                'help_text' => 'content title',
                'editable' => true
            ),
            'description' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => true,
                'size' => 2048,
                'default' => 'auto created content',
                'verbose' => 'description',
                'help_text' => 'content description',
                'editable' => true
            ),
            'mime_type' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => true,
                'size' => 64,
                'default' => 'application/octet-stream',
                'verbose' => 'mime type',
                'help_text' => 'content mime type',
                'editable' => true
            ),
            'media_type' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => true,
                'size' => 64,
                'default' => 'application/octet-stream',
                'verbose' => 'Media type',
                'help_text' => 'This types allow you to category contents',
                'editable' => true
            ),
            'file_path' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => false,
                'size' => 250,
                'verbose' => 'File path',
                'help_text' => 'Content file path',
                'editable' => false,
                'readable' => false
            ),
            'file_name' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => false,
                'size' => 250,
                'default' => 'unknown',
                'verbose' => 'file name',
                'help_text' => 'Content file name',
                'editable' => false
            ),
            'file_size' => array(
                'type' => 'Pluf_DB_Field_Integer',
                'blank' => false,
                'default' => 'no title',
                'verbose' => 'file size',
                'help_text' => 'content file size',
                'editable' => false
            ),
            'downloads' => array(
                'type' => 'Pluf_DB_Field_Integer',
                'blank' => false,
                'default' => 0,
                'default' => 'no title',
                'verbose' => 'downloads',
                'help_text' => 'content downloads number',
                'editable' => false
            ),
            'creation_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'blank' => true,
                'verbose' => 'creation',
                'help_text' => 'content creation time',
                'editable' => false
            ),
            'modif_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'blank' => true,
                'verbose' => 'modification',
                'help_text' => 'content modification time',
                'editable' => false
            ),
            'expire_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'blank' => true,
                'is_null' => true,
                'verbose' => 'expired',
                'help_text' => 'content expiration time',
                'editable' => false
            )
        );
    }

    /**
     * پیش ذخیره را انجام می‌دهد
     *
     * @param boolean $create
     *            حالت
     *            ساخت یا به روز رسانی را تعیین می‌کند
     */
    function preSave($create = false)
    {
        if ($this->id == '') {
            $this->creation_dtime = gmdate('Y-m-d H:i:s');
        }
        $this->modif_dtime = gmdate('Y-m-d H:i:s');
        $this->url_id = sha1($this->url);
        // File path
        $path = $this->getAbsloutPath();
        // file size
        if (!empty($this->file_path) && file_exists($path)) {
            $this->file_size = filesize($path);
        } else {
            $this->file_size = 0;
        }
        // mime type (based on file name)
        $mime_type = $this->mime_type;
        if (! isset($mime_type) || $mime_type === 'application/octet-stream') {
            $fileInfo = Pluf_FileUtil::getMimeType($this->file_name);
            $this->mime_type = $fileInfo[0];
        }
    }

    /**
     * Checks if given URL is registered already.
     *
     * @param string $url
     * @return boolean
     */
    public static function isRegistered($url)
    {
        $content = Seo_Content::getContent($url);
        return $content !== null;
    }

    /**
     * Returns the seo-content with given URL if such content is exist, else returns null.
     *
     * @param string $url
     * @return Seo_Content|NULL
     */
    public static function getContent($url)
    {
        $q = new Pluf_SQL('url_id=%s', array(
            sha1($url)
        ));
        $contents = Pluf::factory('Seo_Content')->getList(array(
            'filter' => $q->gen()
        ));
        if ($contents === false or count($contents) === 0) {
            return null;
        }
        return $contents[0];
    }

    /**
     * حالت کار ایجاد شده را به روز می‌کند
     *
     * @see Pluf_Model::postSave()
     */
    function postSave($create = false)
    {
        //
    }

    /**
     * \brief عملیاتی که قبل از پاک شدن است انجام می‌شود
     *
     * عملیاتی که قبل از پاک شدن است انجام می‌شود
     * در این متد فایل مربوط به است حذف می شود. این عملیات قابل بازگشت نیست
     */
    function preDelete()
    {
        // remove related file
        $filename = $this->file_path . '/' . $this->id;
        if (is_file($filename)) {
            unlink($filename);
        }
    }

    /**
     * مسیر کامل محتوی را تعیین می‌کند.
     *
     * @return string
     */
    public function getAbsloutPath()
    {
        return $this->file_path . '/' . $this->id;
    }

    /**
     * Checks if the content is expired
     *
     * If there is a date in expire_dtime and it is passed then the content
     * is expired.
     *
     * @return boolean
     */
    public function isExpired()
    {
        $exp = $this->expire_dtime;
        return $exp == null || date("Y-m-d H:i:s") > $exp;
    }
}