<?php

namespace App\Http\Controllers;

use App\Models\SafeNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Listar todas as notificações
     */
    public function index(Request $request)
    {
        $query = SafeNotification::with(['guardian', 'authorization.student']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->channel) {
            $query->where('channel', $request->channel);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $notifications = $query->latest()->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Exibir detalhes da notificação
     */
    public function show(SafeNotification $notification)
    {
        $notification->load(['authorization.student', 'guardian']);
        return view('notifications.show', compact('notification'));
    }

    /**
     * Obter estatísticas de notificações
     */
    public function stats()
    {
        $stats = [
            'total' => SafeNotification::count(),
            'sent' => SafeNotification::where('status', 'sent')->count(),
            'failed' => SafeNotification::where('status', 'failed')->count(),
            'pending' => SafeNotification::where('status', 'pending')->count(),
            'by_channel' => SafeNotification::selectRaw('channel, count(*) as count')
                ->groupBy('channel')
                ->get()
                ->pluck('count', 'channel'),
            'by_type' => SafeNotification::selectRaw('type, count(*) as count')
                ->groupBy('type')
                ->get()
                ->pluck('count', 'type'),
        ];

        return response()->json($stats);
    }
}
