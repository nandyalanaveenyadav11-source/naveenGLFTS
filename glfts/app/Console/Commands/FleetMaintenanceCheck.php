<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;
use Carbon\Carbon;

class FleetMaintenanceCheck extends Command
{
    protected $signature = 'fleet:maintenance-check';

    protected $description = 'List vehicles that have not had maintenance in the last 6 months';

    public function handle()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        $vehicles = Vehicle::whereDoesntHave('maintenanceLogs', function ($query) use ($sixMonthsAgo) {
            $query->where('date_of_service', '>=', $sixMonthsAgo);
        })->get();

        if ($vehicles->isEmpty()) {
            $this->info('All vehicles have been maintained in the last 6 months.');
            return;
        }

        $this->info("Vehicles requiring maintenance (no service in last 6 months):");
        foreach ($vehicles as $vehicle) {
            $this->line(" - Vehicle ID: {$vehicle->id} | VIN: {$vehicle->vin_number} | License: {$vehicle->license_plate}");
        }
    }
}
