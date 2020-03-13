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
 * @author maso <mostafa.barmshory@dpq.co.ir>
 *        
 */
class Seo_Form_BackendUpdate extends Pluf_Form
{

    /**
     *
     * @var Seo_Backend
     */
    var $backend;

    /*
     *
     */
    public function initFields($extra = array())
    {
        $this->backend = $extra['backend'];

        $engin = $this->backend->get_engine();
        $params = $engin->getParameters();
        $options = array(
            'required' => false
        );
        foreach ($params['children'] as $param) {
            $field = null;
            // TODO: maso, 2019: add validators
            switch ($param['type']) {
                case 'Integer':
                    $field = new Pluf_Form_Field_Integer($options);
                    break;
                case 'String':
                    $field = new Pluf_Form_Field_Varchar($options);
                    break;
                case 'Boolean':
                    $field = new Pluf_Form_Field_Boolean($options);
                    break;
            }
            $this->fields[$param['name']] = $field;
        }
    }

    /**
     *
     * @param string $commit
     * @throws Pluf_Exception
     */
    function update($commit = true)
    {
        if (! $this->isValid()) {
            // TODO: maso, 1395: باید از خطای مدل فرم استفاده شود.
            throw new Pluf_Exception(__('Cannot save the backend from an invalid form.'));
        }
        // Set attributes
        $this->backend->setFromFormData($this->cleaned_data);
        $params = $this->backend->get_engine()->getParameters();
        foreach ($params['children'] as $param) {
            if (array_key_exists($param['name'], $this->backend->_a['cols'])) {
                continue;
            }
            if (array_key_exists($param['name'], $this->cleaned_data)) {
                $this->backend->setMeta($param['name'], $this->cleaned_data[$param['name']]);
            }
        }
        if ($commit) {
            if (! $this->backend->update()) {
                throw new Pluf_Exception(__('Fail to create the backend.'));
            }
        }
        return $this->backend;
    }
}

