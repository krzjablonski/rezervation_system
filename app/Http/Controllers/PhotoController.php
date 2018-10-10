<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Album;
use Image;
use Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::orderBy('id', 'dsc')->paginate(10);

        return view('photos.index')->withPhotos($photos);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Validate input
      $this->validate($request, array(
        'image' => 'required|file|image',
        'photo_alt' => 'required'
      ));

      // Create path to file like: 2018/08 based on current timestamp;
      $path = date('Y/m', time());

      // Get image from $request
      $image = $request->file('image');

      // Get full name of file with extension
      $imgOriginalName = strtolower($image->getClientOriginalName());

      // Get file name without extension.
      $fileName = substr($imgOriginalName, 0, strrpos($imgOriginalName, '.' ));

      // Strip all spaces
      $fileName = str_replace(' ', '', $fileName);

      // Add current timestamp to file name, and original extension
      $fileName .= '-'.time().'.'.$image->getClientOriginalExtension();
      $thumbName = 'thumbnail-'.$fileName.'-'.time().'.'.$image->getClientOriginalExtension();

      // Create new Photo
      $photo = new Photo;
      $photo->photo_name = $fileName;
      $photo->photo_thumbnail = $thumbName;
      $photo->photo_path = $path;
      $photo->photo_alt = filter_var($request->photo_alt, FILTER_SANITIZE_STRING);

      // Save photo to database and if success upload the file
      if($photo->save()){

        // Check if path exists. If not create it. Photos are stored in uploads/year/month ex. uploads/2018/08
        if(!file_exists(public_path('uploads/'.$photo->photo_path.'/'))){
          if(!mkdir(public_path('uploads/'.$photo->photo_path.'/'), 0755, true)){
            $photo->delete();
            return Redirect::back()->withErrors(['error', 'Nie można utworzyć lokalizacji dla pliku.']);
          };
        }

        // Create location paths
        $location = public_path('uploads/'.$path.'/'.$photo->photo_name);
        $thubLocation = public_path('uploads/'.$path.'/'.$photo->photo_thumbnail);

        // Upload full size image
        Image::make(file_get_contents($image))->resize(1200, null, function($constraint){
          // prevent image aspect ratio and disabel upscaleing
          $constraint->aspectRatio();
          $constraint->upsize();
        })->save($location);

        // Upload thumbnail
        Image::make(file_get_contents($image))->fit(300, 300, function($constraint){
          // prevent image aspect ratio and disabel upscaleing
          $constraint->aspectRatio();
          $constraint->upsize();
        })->save($thubLocation);

      }

      return redirect()->route('photos.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $photo = Photo::find($id);

        return view('photos.show')->withPhoto($photo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $photo = Photo::find($id);

        return view('photos.edit')->withPhoto($photo);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::find($id);
        $photoPath = $photo->photo_path.'/'.$photo->photo_name;
        $thumbnailPath = $photo->photo_path.'/'.$photo->photo_thumbnail;

        // Detach all connection between photos and albums. If success delete photo from database
        if($photo->albums()->count() > 0){
          $photo->albums()->detach();
        }
        if($photo->delete()){
          Storage::disk('uploads')->delete([$photoPath, $thumbnailPath]);
        }

        return redirect()->route('photos.index');
    }
}
