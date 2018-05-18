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
 * Render engine to render pages
 *
 * @author maso<mostafa.barmshory@dpq.co.ir>
 *
 */
class Seo_Engine implements JsonSerializable
{
    
    const ENGINE_PREFIX = 'seo_engine_';
    
    /**
     *
     * @return string
     */
    public function getType ()
    {
        $name = strtolower(get_class($this));
        // NOTE: maso, 1395: تمام متورهای پرداخت باید در پوشه تعیین شده قرار
        // بگیرند
        if (strpos($name, self::ENGINE_PREFIX) !== 0) {
            throw new Seo_Exception_EngineLoad(
                    'Engine class must be placed in engine package.');
        }
        return substr($name, strlen(self::ENGINE_PREFIX));
    }
    
    /**
     *
     * @return string
     */
    public function getSymbol ()
    {
        return $this->getType();
    }
    
    /**
     *
     * @return string
     */
    public function getTitle ()
    {
        return '';
    }
    
    /**
     *
     * @return string
     */
    public function getDescription ()
    {
        return '';
    }
        
    /**
     * (non-PHPdoc)
     *
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize ()
    {
        $coded = array(
                'type' => $this->getType(),
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
                'symbol' => $this->getSymbol()
        );
        return $coded;
    }
    
    /**
     * فهرستی از پارامترهای موتور پرداخت را تعیین می‌کند
     *
     * هر موتور پرداخت به دسته‌ای از پارامترها نیازمند است که باید توسط کاربر
     * تعیین شود. این فراخوانی پارامترهایی را تعیین می‌کند که برای استفاده از
     * این متور پرداخت باید تعیین کرد.
     *
     * خروجی این فراخوانی یک فهرست است توصیف خصوصیت‌ها است.
     */
    public function getParameters ()
    {
        $param = array(
                'id' => $this->getType(),
                'name' => $this->getType(),
                'type' => 'struct',
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
                'editable' => true,
                'visible' => true,
                'priority' => 5,
                'symbol' => $this->getSymbol(),
                'children' => []
        );
        $general = $this->getGeneralParam();
        foreach ($general as $gp) {
            $param['children'][] = $gp;
        }
        
        $extra = $this->getExtraParam();
        foreach ($extra as $ep) {
            $param['children'][] = $ep;
        }
        return $param;
    }
    
    /**
     * Get list of general properties.
     *
     * @return array of general properties
     */
    public function getGeneralParam ()
    {
        $params = array();
        $params[] = array(
                'name' => 'title',
                'type' => 'String',
                'unit' => 'none',
                'title' => 'title',
                'description' => 'beackend title',
                'editable' => true,
                'visible' => true,
                'priority' => 5,
                'symbol' => 'title',
                'defaultValue' => 'no title',
                'validators' => [
                        'NotNull',
                        'NotEmpty'
                ]
        );
        $params[] = array(
                'name' => 'description',
                'type' => 'String',
                'unit' => 'none',
                'title' => 'description',
                'description' => 'beackend description',
                'editable' => true,
                'visible' => true,
                'priority' => 5,
                'symbol' => 'title',
                'defaultValue' => 'description',
                'validators' => []
        );
        $params[] = array(
                'name' => 'symbol',
                'type' => 'String',
                'unit' => 'none',
                'title' => 'Symbol',
                'description' => 'beackend symbol',
                'editable' => true,
                'visible' => true,
                'priority' => 5,
                'symbol' => 'icon',
                'defaultValue' => '',
                'validators' => []
        );
        $params[] = array(
                'name' => 'enable',
                'type' => 'Boolean',
                'unit' => 'none',
                'title' => 'Enable',
                'description' => 'enable beackend',
                'editable' => true,
                'visible' => true,
                'priority' => 5,
                'symbol' => 'icon',
                'defaultValue' => '',
                'validators' => []
        );
        return $params;
    }
    
    /**
     * Get extra properties of the engine
     * 
     * @return array of properties descriptors
     */
    public function getExtraParam ()
    {
        // TODO: maso, 1395: فرض شده که این فراخوانی توسط پیاده‌سازی‌ها بازنویسی
        // شود
        return array();
    }
    
    /**
     * Renders a request
     *
     * @param Seo_Request $request
     */
    public function render ($request)
    {
        // XXX: maso, 1395: ایجاد یک پرداخت
    }
    
}