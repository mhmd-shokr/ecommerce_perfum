<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use App\Support\Governorates;
use Illuminate\Http\Request;

class ShippingZoneController extends Controller
{
    public function index(){
        $shippingZones=ShippingZone::orderBy('governorate')->paginate(15);
        return view('admin.shipping-zones.index',compact('shippingZones'));
    }

    public function create(){
        $governorates=collect(Governorates::all())
            ->diff(ShippingZone::pluck('governorate'))->values();
            return view('admin.shipping-zones.create', compact('governorates'));

    } 

    public function store(Request $request){
        $validated = $request->validate([
            'governorate' => ['required', 'string', 'in:' . implode(',', Governorates::all()), 'unique:shipping_zones,governorate'],
            'cost' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ]);
        ShippingZone::create($validated);
 
        return redirect()
            ->route('admin.shipping-zones.index')
            ->with('success', __('Shipping zone created successfully.'));
    }

    public function edit(ShippingZone $shippingZone){
        $governorates = collect(Governorates::all())
        ->diff(ShippingZone::where('id', '!=', $shippingZone->id)->pluck('governorate'))
        ->values();

    return view('admin.shipping-zones.edit', compact('shippingZone', 'governorates'));
    }

    public function update(Request $request, ShippingZone $shippingZone)
    {
        $validated = $request->validate([
            'governorate' => [
                'required',
                'string',
                'in:' . implode(',', Governorates::all()),
                'unique:shipping_zones,governorate,' . $shippingZone->id,
            ],
            'cost' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ]);
 
        $shippingZone->update($validated);
 
        return redirect()
            ->route('admin.shipping-zones.index')
            ->with('success', __('Shipping zone updated successfully.'));
    }

    public function destroy(ShippingZone $shippingZone)
    {
        $shippingZone->delete();
 
        return redirect()
            ->route('admin.shipping-zones.index')
            ->with('success', __('Shipping zone deleted successfully.'));
    }
}
