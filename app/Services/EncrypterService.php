<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class EncrypterService
{
    public static function encrypt(int $id): string
    {
        return Crypt::encrypt($id);
    }

    public static function decrypt(string $id)
    {
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect('/');
        }
    }
}
