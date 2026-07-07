<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Jobs\SendOfferEmail;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function index(){
        $offers=Offer::latest()->paginate(8);
        return view('admin.offers.index',compact('offers'));
    }

    public function create(){
        $coupons=Coupon::where('is_active',true)->get();
        return view('admin.offers.create',compact('coupons'));
    }

    public function store(OfferRequest $request){
        $validated = $request->validated();

        if($request->has("image")){
            $validated['image']=$request->file('image')
                ->store('offers','public');
        }

        Offer::create($validated);
        return redirect()
            ->route('admin.offers.index')
                ->with('success', __('Offer created successfully'));
    }

    public function show(Offer $offer)
    {
        return view('admin.offers.show', compact('offer'));
    }

    public function send(Offer $offer){
        if($offer->is_sent){
            return back()->with('error', __('This offer has already been sent'));
        }
        $users=User::whereNotNull('email_verified_at')
            ->whereDoesntHave('roles',fn($q)=>$q->where('name','admin'))
                ->get();

                foreach($users as $user){
                    SendOfferEmail::dispatch($offer,$user);
                }
                $offer->update([
                    'status'           => 'sent',
                    'sent_at'          => now(),
                    'recipients_count' => $users->count(),
                ]);
        return redirect()
            ->route('admin.offers.index')
                ->with('success', __(
                    'Offer is being sent to :count users',
                    ['count' => $users->count()]
                ));
    }

    public function destroy(Offer $offer)
    {
        if ($offer->image) {
            Storage::disk('public')->delete($offer->image);
        }

        $offer->delete();

        return redirect()
            ->route('admin.offers.index')
            ->with('success', __('Offer deleted successfully'));
    }
}
