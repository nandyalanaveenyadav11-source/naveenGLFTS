<?php

namespace App\Services;

use App\Models\Shipment;
use Exception;

class ShipmentService
{
    /**
     * Update the status of a shipment following the state machine rules.
     * Pending → Loading → In_Transit → Delivered
     * 
     * @param Shipment $shipment
     * @param string $newStatus
     * @throws Exception
     */
    public function updateStatus(Shipment $shipment, string $newStatus)
    {
        $validTransitions = [
            'Pending' => ['Loading'],
            'Loading' => ['In_Transit'],
            'In_Transit' => ['Delivered'],
            'Delivered' => [],
        ];

        $currentStatus = $shipment->status;

        if (!in_array($newStatus, $validTransitions[$currentStatus] ?? [])) {
            throw new Exception("Invalid status transition from {$currentStatus} to {$newStatus}. Shipment cannot skip phases.");
        }

        $shipment->status = $newStatus;
        $shipment->save();

        return $shipment;
    }
}
