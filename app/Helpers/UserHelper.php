<?php
// File: app/Helpers/UserHelper.php

if (!function_exists('formatUserName')) {
    /**
     * Format user name with appropriate prefix based on role
     *
     * @param \App\Models\User|string|null $user
     * @return string
     */
    function formatUserName($user)
    {
        if (!$user) {
            return '';
        }
        
        if (is_string($user)) {
            return $user;
        }
        
        if (is_object($user) && isset($user->name)) {
            if (isset($user->role) && $user->role === 'ustad') {
                return 'Ustad ' . $user->name;
            }
            
            return $user->name;
        }
        
        return '';
    }
}

if (!function_exists('getUserNameWithPrefix')) {
    /**
     * Alias for formatUserName function
     *
     * @param \App\Models\User|string|null $user
     * @return string
     */
    function getUserNameWithPrefix($user)
    {
        return formatUserName($user);
    }
}