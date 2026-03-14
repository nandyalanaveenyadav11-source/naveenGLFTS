# GLFTS Project Testing & Explanation Guide

This document explains the architecture of the Global Logistics & Fleet Tracking System (GLFTS) and provides step-by-step instructions on how to test each feature.

---

## 🏗️ Architecture & Core Components

1. **Database Models & Relationships:**
   - **Vehicles & Shipments:** Connected through a Many-to-Many relationship (via `vehicle_shipment` table).
   - **Drivers & Shipments:** Connected via a One-to-Many relationship (each Shipment is assigned one Driver).
   - **Comments:** A Polymorphic table attached to both Drivers (for reviews) and Shipments (for notes).

2. **Core Business Logic:**
   - **ShipmentService (State Machine):** Prevents skipping statuses. A shipment must flow logically: `Pending` → `Loading` → `In_Transit` → `Delivered`.
   - **ShipmentObserver:** Listens for Shipment changes. When a Shipment is updated to `In_Transit`, it automatically sets the assigned Driver's `is_on_trip` status to `true`.
   - **CheckVehicleCapacity (Custom Rule):** Prevents assigning a shipment to a vehicle if the total loaded weight exceeds the vehicle's `capacity_kg`.
   - **CheckCertification (Middleware):** Intercepts requests. If a Shipment is marked `Hazardous`, it checks if the assigned Driver has the `Hazmat` certification level.

---

## 🧪 How to Test the Project

### Prerequisites
Make sure your development server is running via terminal:
```bash
php artisan serve
```
*(By default, this hosts your API at http://127.0.0.1:8000)*

---

### 1. Test the Live Dashboard Endpoint
- **URL:** `GET http://127.0.0.1:8000/api/dashboard`
- **What it does:** Returns a real-time count of vehicles currently in motion vs. idle vehicles.
- **How to test:** 
  - Open Postman or your browser and hit the URL above.
  - You should receive an immediate JSON response like `{"vehicles_in_motion": 3, "vehicles_idle": 7}`.

### 2. Test Geospatial Search
- **URL:** `GET http://127.0.0.1:8000/api/shipments?origin=CityName&destination=CityName`
- **What it does:** Filters all shipments by their origin or destination dynamically.
- **How to test:**
  - In Postman, hit `http://127.0.0.1:8000/api/shipments`. You will see all shipments.
  - Now add a query parameter to filter, for example: `http://127.0.0.1:8000/api/shipments?origin=New` to find all shipments starting in cities like New York.

### 3. Test Vehicle Remaining Capacity
- **URL:** `GET http://127.0.0.1:8000/api/vehicles/{id}/remaining-capacity`
- **What it does:** Dynamically calculates how much empty space a specific vehicle has based on shipments currently `Loading` or `In_Transit`.
- **How to test:**
  - First, find a valid Vehicle ID from your database (e.g., `1`).
  - Hit `http://127.0.0.1:8000/api/vehicles/1/remaining-capacity`.
  - It will return the total capacity, the current load from active shipments, and the remaining space available.

### 4. Test Automated Maintenance Alert
- **Command:** `php artisan fleet:maintenance-check`
- **What it does:** Identifies vehicles that haven't received maintenance in the last 6 months.
- **How to test:** 
  - Open your terminal in the `glfts` folder.
  - Run `php artisan fleet:maintenance-check`.
  - The script will scan the database and print out the vehicles requiring maintenance directly in the terminal window.

### 5. Check API Documentation
- **URL:** `http://127.0.0.1:8000/docs`
- **What it does:** Displays the auto-generated Swagger-style documentation using Scribe. You can view all endpoints and their parameters visually here.

### 6. Run the Automated Feature Tests
- **Command:** `php artisan test`
- **What it does:** Runs the specific PHPUnit/Pest tests inside `tests/Feature/GlftsFeatureTest.php`.
- **How to test:**
  - Open your terminal in the `glfts` folder and run `php artisan test`.
  - **It will automatically verify that:**
    - Code correctly throws an error when a Vehicle is overloaded.
    - Code correctly throws a 403 Forbidden error if a Driver tries to take Hazardous cargo without certification.
    - The Shipment Status State Machine forbids skipping the "Loading" phase.
  - You should see `PASS` indicating all backend logic is robust and functioning as expected.
