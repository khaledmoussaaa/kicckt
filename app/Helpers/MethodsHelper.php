<?php
// For Auth Response
if (!function_exists('add_media')) {
    function add_media($model, $request, $collection)
    {
        if ($request->hasFile('media')) {
            $model->addMediaFromRequest('media')->toMediaCollection($collection);
        }
    }
}
