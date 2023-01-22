<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all listings
    public function index(){
        return view('listing.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
    ]);
    }

    // Show single listing
    public function show(Listing $listing){
        return view('listing.show', [
            'listing' => $listing
        ]);
    }

    // Show create form
    public function create(){
        return view('listing.create');
    }

    // Store new listing
    public function store(Request $request){
        $formFeilds = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')){
            $formFeilds['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFeilds['user_id'] = auth()->id();

        Listing::create($formFeilds);

        return redirect('/')->with('message', 'listing created successfully');
    }

    // Show edit form
    public function edit(Listing $listing){
        return view('listing.edit', [
            'listing' => $listing
        ]);
    }

    // Update lisiting
    public function update(Request $request, Listing $listing)
    {
        if($listing->user_id != auth()->id()){
            abort(403, 'Unathorized action');
        }

        $formFeilds = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFeilds['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFeilds);

        return back()->with('message', 'listing updated successfully');
    }

    // Delete listing
    public function destroy(Listing $listing){

        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unathorized action');
        }

        $listing->delete();
        return redirect('/')->with('message', 'listing deleted successfully');
    }

    // Manage listing
    public function manage(){
        return view('listing.manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
