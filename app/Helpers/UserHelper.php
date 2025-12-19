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

if (!function_exists('getUserInitials')) {
    /**
     * Get user initials from name
     *
     * @param string|null $name
     * @return string
     */
    function getUserInitials($name)
    {
        if (!$name) return '?';

        $nameParts = explode(' ', trim($name));
        $initials = '';

        // Ambil huruf pertama dari maksimal 2 kata
        $count = 0;
        foreach ($nameParts as $part) {
            if ($count >= 2) break;

            $initials .= strtoupper(substr($part, 0, 1));
            $count++;
        }

        // Jika hanya 1 kata, hanya ambil 1 huruf
        if (count($nameParts) === 1) {
            $initials = strtoupper(substr($nameParts[0], 0, 1));
        }

        return $initials;
    }
}