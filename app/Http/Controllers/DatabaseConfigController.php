<?php

namespace App\Http\Controllers;

use App\Models\DatabaseConfig;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DatabaseConfigController extends Controller
{
    public function index()
    {
        $configs = DatabaseConfig::all();
        return Inertia::render('DatabaseConfigs/Index', [
            'configs' => $configs
        ]);
    }

    public function create()
    {
        return Inertia::render('DatabaseConfigs/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'host' => 'required|string',
            'port' => 'required|integer',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        DatabaseConfig::create($validated);

        return redirect()->route('database-configs.index')->with('success', 'Configuration created successfully.');
    }

    public function edit(DatabaseConfig $databaseConfig)
    {
        return Inertia::render('DatabaseConfigs/Edit', [
            'config' => $databaseConfig
        ]);
    }

    public function update(Request $request, DatabaseConfig $databaseConfig)
    {
        $validated = $request->validate([
            'host' => 'required|string',
            'port' => 'required|integer',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string', // Allow nullable if not changing
            'is_active' => 'boolean'
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $databaseConfig->update($validated);

        return redirect()->route('database-configs.index')->with('success', 'Configuration updated successfully.');
    }

    public function destroy(DatabaseConfig $databaseConfig)
    {
        $databaseConfig->delete();
        return redirect()->route('database-configs.index')->with('success', 'Configuration deleted successfully.');
    }

    public function testConnection(Request $request)
    {
        $validated = $request->validate([
            'host' => 'required|string',
            'port' => 'required|integer',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
        ]);

        try {
            // Create a temporary connection configuration
            $config = [
                'driver' => 'mysql',
                'host' => $validated['host'],
                'port' => $validated['port'],
                'database' => $validated['database'],
                'username' => $validated['username'],
                'password' => $validated['password'],
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ];

            // Set the temporary connection
            \Config::set('database.connections.temp_test', $config);

            // Attempt to connect
            \DB::connection('temp_test')->getPdo();

            return response()->json(['message' => 'Connection successful!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Connection failed: ' . $e->getMessage()], 400);
        }
    }
}
