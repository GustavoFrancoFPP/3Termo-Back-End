<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\Student;
use App\Models\SafeNotification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Exibir dashboard principal
     */
    public function index()
    {
        $stats = [
            'pending_authorizations' => Authorization::where('status', 'pending')->count(),
            'authorized_today' => Authorization::where('status', 'used')
                ->whereDate('validated_at', today())
                ->count(),
            'total_entries_today' => Authorization::where('status', 'used')
                ->where('type', 'entry')
                ->whereDate('validated_at', today())
                ->count(),
            'total_exits_today' => Authorization::where('status', 'used')
                ->where('type', 'exit')
                ->whereDate('validated_at', today())
                ->count(),
        ];

        $recent_authorizations = Authorization::with(['student', 'guardian'])
            ->latest('validated_at')
            ->take(10)
            ->get();

        $notifications_status = [
            'sent' => SafeNotification::where('status', 'sent')->count(),
            'failed' => SafeNotification::where('status', 'failed')->count(),
            'pending' => SafeNotification::where('status', 'pending')->count(),
        ];

        return view('dashboard', compact('stats', 'recent_authorizations', 'notifications_status'));
    }

    /**
     * Exportar relatório
     */
    public function report(Request $request)
    {
        $startDate = $request->input('start_date', today());
        $endDate = $request->input('end_date', today());

        $authorizations = Authorization::whereBetween('validated_at', [$startDate, $endDate])
            ->where('status', 'used')
            ->with(['student', 'guardian'])
            ->get();

        return response()->json($authorizations);
    }
}
