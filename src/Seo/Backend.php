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
Pluf::loadFunction('Seo_Shortcuts_GetEngineOr404');

class Seo_Backend extends Pluf_Model
{

    public $data = array();

    public $touched = false;

    /**
     * @brief مدل داده‌ای را بارگذاری می‌کند.
     *
     * تمام فیلدهای مورد نیاز برای این مدل داده‌ای در این متد تعیین شده و به
     * صورت کامل ساختار دهی می‌شود.
     *
     * @see Pluf_Model::init()
     */
    function init ()
    {
        $this->_a['table'] = 'seo_backend';
        $this->_a['cols'] = array(
                'id' => array(
                        'type' => 'Pluf_DB_Field_Sequence',
                        'blank' => true,
                        'verbose' => 'unique and no repreducable id fro reception'
                ),
                'title' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => false,
                        'size' => 50
                ),
                'description' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => true,
                        'size' => 200
                ),
                'symbol' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => false,
                        'size' => 50
                ),
                'enable' => array(
                        'type' => 'Pluf_DB_Field_Boolean',
                        'blank' => false,
                        'size' => 50
                ),
                'home' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => true,
                        'size' => 50
                ),
                'meta' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => false,
                        'secure' => true,
                        'size' => 3000,
                        'editable' => false,
                        'readable' => false
                ),
                'engine' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => false,
                        'size' => 50
                ),
                
                'creation_dtime' => array(
                        'type' => 'Pluf_DB_Field_Datetime',
                        'blank' => true,
                        'verbose' => 'creation date'
                ),
                'modif_dtime' => array(
                        'type' => 'Pluf_DB_Field_Datetime',
                        'blank' => true,
                        'verbose' => 'modification date'
                )
        );
        $this->_a['views'] = array();
    }

    /*
     * @see Pluf_Model::preSave()
     */
    function preSave ($create = false)
    {
        $this->meta = serialize($this->data);
        if ($this->id == '') {
            $this->creation_dtime = gmdate('Y-m-d H:i:s');
        }
        $this->modif_dtime = gmdate('Y-m-d H:i:s');
    }

    /**
     * داده‌های ذخیره شده را بازیابی می‌کند
     *
     * تمام داده‌هایی که با کلید payMeta ذخیره شده را بازیابی می‌کند.
     */
    public function restore ()
    {
        $this->data = unserialize($this->meta);
    }

    /**
     * تمام داده‌های موجود در نشت را پاک می‌کند.
     *
     * تمام داده‌های ذخیره شده در نشست را پاک می‌کند.
     */
    public function clear ()
    {
        $this->data = array();
        $this->touched = true;
    }

    /**
     * تعیین یک داده در نشست
     *
     * با استفاده از این فراخوانی می‌توان یک داده با کلید جدید در نشست ایجاد
     * کرد. این کلید برای دستیابی‌های
     * بعد مورد استفاده قرار خواهد گرفت.
     *
     * @param
     *            کلید داده
     * @param
     *            داده مورد نظر. در صورتی که مقدار آن تهی باشد به معنی
     *            حذف است.
     */
    public function setMeta ($key, $value = null)
    {
        if (is_null($value)) {
            unset($this->data[$key]);
        } else {
            $this->data[$key] = $value;
        }
        $this->touched = true;
    }

    /**
     * داده معادل با کلید تعیین شده را برمی‌گرداند
     *
     * در صورتی که داده تعیین نشده بود مقدار پیش فرض تعیین شده به عنوان نتیجه
     * این فراخوانی
     * برگردانده خواهد شد.
     */
    public function getMeta ($key = null, $default = '')
    {
        if (is_null($key)) {
            return parent::getData();
        }
        if (isset($this->data[$key])) {
            return $this->data[$key];
        } else {
            return $default;
        }
    }

    /**
     *
     * @return Seo_Engine
     */
    public function get_engine ()
    {
        if (! isset($this->engine)) {
            $this->engine = Seo_Shortcuts_GetEngineOr404($this->engine);
        }
        return $this->engine;
    }

    /**
     * 
     * @param unknown $request
     * @return unknown
     */
    public function render ($request)
    {
        $engine = $this->get_engine();
        $request->backend = $this;
        return $engine->render($request);
    }
}