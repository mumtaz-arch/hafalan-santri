<?php

namespace App\Traits;

trait PasswordValidationRules
{
    /**
     * Get the password validation rules for registration and updates
     */
    protected function passwordValidationRules()
    {
        return [
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * Get the change password validation rules
     */
    protected function changePasswordValidationRules()
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * Get the password validation messages
     */
    protected function passwordValidationMessages()
    {
        return [
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai',
        ];
    }
}