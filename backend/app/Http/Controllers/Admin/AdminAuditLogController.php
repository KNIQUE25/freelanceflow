<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminAuditLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuditLog::with('user')
            ->when($request->action, fn($q, $action) => $q->where('action', $action))
            ->when($request->user_id, fn($q, $userId) => $q->where('user_id', $userId))
            ->latest()
            ->paginate(50);
        return response()->json($logs);
    }
}