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
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');

/**
 * Content model
 *
 * @author hadi
 */
class Seo_Views_Content
{

    /**
     * If content with given URL in the request exist before it updates it else creates a new content.
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return Pluf_HTTP_Response_Json
     */
    public function createOrUpdate($request, $match){
        $content = Seo_Content::getContent($request->REQUEST['url']);
        if ($content === null) {
            return $this->create($request, $match);
        }
        $match['modelId'] = $content->id;
        return $this->update($request, $match);

    }
    /**
     * Creates new content
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @throws Pluf_Exception
     * @return Pluf_HTTP_Response_Json
     */
    public function create($request, $match)
    {
        // initial content data
        $extra = array(
            'user' => $request->user,
            'model' => new Seo_Content()
        );

//         $exist = Seo_Content::isRegistered($request->REQUEST['url']);
//         if ($exist) {
//             throw new Pluf_Exception('URL is registered already.', 400);
//         }

        // Create content and get its ID
        $form = new Seo_Form_ContentCreate($request->REQUEST, $extra);

        // Upload content file and extract information about it (by updating
        // content)
        $extra['model'] = $form->save();
        $form = new Seo_Form_ContentUpdate(array_merge($request->REQUEST, $request->FILES), $extra);
        try {
            $content = $form->save();
        } catch (Pluf_Exception $e) {
            $content = $extra['model'];
            $content->delete();
            throw $e;
        }
        return $content;
    }

    /**
     * Gets content meta information
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return Pluf_HTTP_Response_Json
     */
    public function get($request, $match)
    {
        // تعیین داده‌ها
        if (array_key_exists('id', $match)) {
            $content = Pluf_Shortcuts_GetObjectOr404('Seo_Content', $match['id']);
        } else {
            Pluf::loadFunction('Seo_Shortcuts_GetSeoContentByUrlOr404');
            $content = Seo_Shortcuts_GetSeoContentByUrlOr404($match['url']);
        }
        // اجرای درخواست
        return $content;
    }

    /**
     * Update content meta information
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return Pluf_HTTP_Response_Json
     */
    public function update($request, $match)
    {
        // تعیین داده‌ها
        $content = Pluf_Shortcuts_GetObjectOr404('Seo_Content', $match['modelId']);
        // اجرای درخواست
        $extra = array(
            'model' => $content
        );
        $form = new Seo_Form_ContentUpdate(array_merge($request->REQUEST, $request->FILES), $extra);
        $content = $form->save();
        return $content;
    }

    /**
     * Finds contents
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return Pluf_HTTP_Response_Json
     */
    public function find($request, $match)
    {
        $builder = new Pluf_Paginator_Builder(new Seo_Content());
        return $builder->setRequest($request)
            ->build()
            ->render_object();
    }

    /**
     * Download a content
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return Pluf_HTTP_Response_File
     */
    public function download($request, $match)
    {
        // GET data
        $content = Pluf_Shortcuts_GetObjectOr404('Seo_Content', $match['modelId']);
        // Do
        $content->downloads += 1;
        $content->update();
        $response = new Pluf_HTTP_Response_File($content->getAbsloutPath(), $content->mime_type);
        $response->headers['Content-Disposition'] = sprintf('attachment; filename="%s"', $content->file_name);
        return $response;
    }

    /**
     * Upload a file as content
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return Pluf_HTTP_Response_Json|object
     */
    public function updateFile($request, $match)
    {
        // GET data
        $content = Pluf_Shortcuts_GetObjectOr404('Seo_Content', $match['modelId']);
        if (array_key_exists('file', $request->FILES)) {
            Pluf::loadFunction('Pluf_Form_Field_File_moveToUploadFolder');
            Pluf_Form_Field_File_moveToUploadFolder($request->FILES['file'], array(
                'upload_path' => $content->file_path,
                'file_name' => $content->id,
                'upload_path_create' => true,
                'upload_overwrite' => true
            ));
            $fileInfo = Pluf_FileUtil::getMimeType($request->FILES['file']['name']);
            $content->file_name = $request->FILES['file']['name'];
            $content->mime_type = $fileInfo[0];
        } else {
            // Do
            $content->writeValue(file_get_contents('php://input', 'r'));
        }
        // Update file info in presave
        $content->update();
        return $content;
    }

}