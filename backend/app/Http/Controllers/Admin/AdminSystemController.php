<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class AdminSystemController extends Controller
{
    public function clearCache()
    {
        Artisan::call('optimize:clear');
        return response()->json(['message' => 'Cache cleared successfully.']);
    }

    public function logs()
    {
        $logFile = storage_path('logs/laravel.log');
        if (!File::exists($logFile)) {
            return response()->json(['logs' => '']);
        }
        $content = File::get($logFile);
        $lines = array_reverse(explode("\n", $content));
        $errors = array_filter($lines, fn($line) => str_contains($line, 'ERROR'));
        $recent = array_slice($errors, 0, 100);
        return response()->json(['logs' => $recent]);
    }
}