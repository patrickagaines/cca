<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreServiceRequest;
use App\Http\Requests\Dashboard\UpdateServiceRequest;
use App\Models\Service;

class ServiceController extends Controller
{
    public function __construct(
        private readonly Service $service
    )
    {
    }

    public function index()
    {
        $services = $this->service
            ->select(['id', 'name', 'created_at', 'updated_at'])
            ->orderBy('name')
            ->paginate(20);

        return view('dashboard.services.index', ['services' => $services]);
    }

    public function create()
    {
        return view('dashboard.services.create');
    }

    public function store(StoreServiceRequest $request)
    {
        $validated = $request->validated();

        $service = $this->service->create([
            'name'        => $validated['name'],
            'description' => $validated['description']
        ]);

        return redirect()->route('dashboard.services.show', ['service' => $service]);
    }

    public function show(Service $service)
    {
        return view('dashboard.services.show', ['service' => $service]);
    }

    public function edit(Service $service)
    {
        return view('dashboard.services.edit', ['service' => $service]);
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $validated = $request->validated();

        $service->name        = $validated['name'];
        $service->description = $validated['description'];
        $service->save();

        return redirect()->route('dashboard.services.show', ['service' => $service])
                         ->with('success', 'Service successfully updated.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('dashboard.services.index')
                         ->with('success', 'Service successfully deleted.');
    }
}
