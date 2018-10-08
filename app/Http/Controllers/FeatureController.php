<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feature;
use Session;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $features  = Feature::orderby('id', 'desc')->get();

      return view('features.index')->withFeatures($features);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validate
        $this->validate($request, array(
          'name' => 'required|max:255'
        ));

        $feature = new Feature;
        $feature->name = filter_var($request->name, FILTER_SANITIZE_STRING);

        if($feature->save()){
          Session::flash('success', 'Dodano nową właściwość');
          return redirect()->route('features.index');
        }else{
          return Redirect::back()->withErrors(['error', 'Nie można utworzyć właściwości.']);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $feature = Feature::find($id);

        return view('features.edit')->withFeature($feature);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // Validate
      $this->validate($request, array(
        'name' => 'required|max:255'
      ));

      $feature = Feature::find($id);
      $feature->name = filter_var($request->name, FILTER_SANITIZE_STRING);

      if($feature->save()){
        Session::flash('success', 'Dodano nową właściwość');
        return redirect()->route('features.index');
      }else{
        return Redirect::back()->withErrors(['error', 'Nie można aktualizować właściwości.']);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feature = Feature::find($id);
        if ($feature->room()->count() > 0) {
          $feature->room()->detach();
        }

        if ($feature->delete()) {
          Session::flash('success', 'Obrazek usunięty');
          return redirect()->route('feature.index');
        }else{
          return Redirect::back()->withErrors(['error', 'Nie można usunąć właściwości']);
        }
    }
}
