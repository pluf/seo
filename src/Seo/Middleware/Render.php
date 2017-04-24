<?php

/**
 * SEO middleware
 * 
 * 
 * @author maso <mostafa.barmshory@dpq.co.ir>
 *        
 */
class Seo_Middleware_Render
{

    
    /**
     * Check request to detect bot
     * 
     * @param Pluf_HTTP_Request $request
     */
    function process_request (&$request)
    {
        // در صورتی که درخواست مربوط به seo باشد
        if (array_key_exists('_escaped_fragment_', $request->GET)) {
            return $this->prerenderResponse($request);
        }
        return false;
    }
    
    /**
     * بر اساس تقاضا یک نتیجه مناسب برای جستجوی گوگل ایجاد می‌کند.
     *
     * @param Pluf_HTTP_Request $request
     */
    function prerenderResponse($request)
    {
        $backend = new Seo_Backend();
        $backends = $backend->getList(array(
                'filter' => 'enable=1'
        ));
        $renderRequest = new Seo_Request($request);
        foreach ($backends as $backend){
            try{
                $response = $backend->render($renderRequest);
                if($response){
                    return $response;
                }
            } catch (Exception $error){
                // TODO: maso, 2014: log the error
            }
        }
        $context = new Pluf_Template_Context(array(
                'tenant' => $request->tenant
        ));
        $tmpl = new Pluf_Template('seo.template');
        return new Pluf_HTTP_Response($tmpl->render($context));
    }
    
}
