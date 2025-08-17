<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard with statistics (RF07)
     */
    public function index()
    {
        // Estatísticas gerais
        $stats = [
            'total_trips' => Trip::count(),
            'active_trips' => Trip::whereIn('status', ['scheduled', 'in_progress'])->count(),
            'total_vehicles' => Vehicle::count(),
            'available_vehicles' => Vehicle::where('status', 'available')->count(),
            'total_drivers' => Driver::count(),
            'active_drivers' => Driver::where('status', 'active')->count(),
            'total_users' => User::count(),
        ];

        // Próximas viagens
        $upcoming_trips = Trip::with(['vehicle', 'driver'])
            ->where('departure_time', '>', now())
            ->orderBy('departure_time', 'asc')
            ->take(5)
            ->get();

        // Viagens recentes
        $recent_trips = Trip::with(['vehicle', 'driver'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'upcoming_trips', 'recent_trips'));
    }
}
