<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Show all listings
    public function index(){
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(2)
        ]);
    }

    // Show Create listing form
    
    public function create(){
        return view('listings.create');
    }

    // Store new listing
    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'description' => 'required', 
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();
        Listing::create($formFields);
        return redirect('/')->with('message', 'New Listing Created.');
    }

    // show listing Edit form 

    public function edit(Listing $listing){
        return view('listings.edit', ['listing' => $listing]);
    }
    
    // Update listing
    public function update(Request $request, Listing $listing){
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'description' => 'required', 
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);
        return back()->with('message', 'Listing Updated Successfull.');
    }
    // Delete listing
    public function destroy(Listing $listing){
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing Deleted Successfully');
    }

    // Manage Listing
    public function manage(){
        return view('listings.manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
    // Show single listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
}