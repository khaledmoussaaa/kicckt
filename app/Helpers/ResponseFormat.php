<?php

// For Auth Response
if (!function_exists('authResponse')) {
    function authResponse($token = null, $message = 'success', $success = true, $status = 200)
    {
        return response()->json([
            'user_id' => auth_id(),
            'token' => $token,
            'role' => auth_user()->roles[0]->name ?? 'user',
            'isNew' => auth()->user()->wasRecentlyCreated,
            'success' => $success,
            'message' => $message,
            'status' => $status,
            'expire_in' => auth()->factory()->getTTL(),
        ], $status);
    }
}

// For Content Response
if (!function_exists('contentResponse')) {
    function contentResponse($content, $message = 'success', $success = true, $status = 200)
    {
        $response = [
            'content' => $content,
            'success' => $success,
            'message' => $message,
            'status' => $status,
        ];

        // If pagination data is passed, include it in the response
        if ($content instanceof \Illuminate\Pagination\LengthAwarePaginator || $content instanceof \Illuminate\Pagination\Paginator) {
            $response['content'] = $content->items();

            $response['pagination'] = [
                'total_rows' => $content->total(),
                'per_page' => $content->perPage(),
                'current_page' => $content->currentPage(),
                'last_page' => $content->lastPage(),
                'from' => $content->firstItem(),
                'to' => $content->lastItem(),
                'first_page_url' => $content->url(1),
                'next_page_url' => $content->nextPageUrl(),
                'pervious_page_url' => $content->previousPageUrl(1),
            ];
        }

        return response()->json($response, $status);
    }
}

// For Success Response
if (!function_exists('messageResponse')) {
    function messageResponse($message = 'success', $success = true, $status = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'status' => $status,
        ], $status);
    }
}
