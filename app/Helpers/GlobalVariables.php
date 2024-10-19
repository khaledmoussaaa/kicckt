<?php

// Auth User
if (!function_exists('auth_user')) {
    function auth_user()
    {
        return auth()->user();
    }
}

// Auth ID
if (!function_exists('auth_id')) {
    function auth_id()
    {
        return auth()->id();
    }
}
