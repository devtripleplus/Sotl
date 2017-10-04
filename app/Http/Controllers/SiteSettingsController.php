<?php

namespace App\Http\Controllers;

use App\SiteSettings;
use Illuminate\Http\Request;
use \Session;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
    }

    //admin setting url
    public function adminSettingsUrl()
    {
        $urls = SiteSettings::get()->toArray()[0];
        return view('admin.editsiteSettings', compact('urls'));
    }

     //get settings data
    public function getSettingsData()
    {
        $urlsss = SiteSettings::get()->toArray()[0];
        return $urlsss;
    }

    //admin setting url
    public function updateSettingsUrl(Request $request)
    {
        $this->validate(request(),[
            'theater_url' => 'required',
            'wp_url' => "required",
            'max_file_size_in_gb' => 'required'
        ]);
        if(SiteSettings::count() >= 1){
            $url = SiteSettings::find(1);
            $url->theater_url = request('theater_url');
            $url->wp_url = request('wp_url');
            $url->max_file_size_in_gb = request('max_file_size_in_gb');
            if($url->save()){
                Session::flash('message', 'Settings updated successfully');
                return back();
            }
        }
        else{
            $urls = SiteSettings::create([
            'theater_url' => request('theater_url'),
            'wp_url' => request('wp_url')
            ]);
           if($urls){
            Session::flash('message', 'Settings updated successfully');
            return back();
           }
        }
       Session::flash('message', 'Some error occurred');
       return back();
    }

    //admin setting url
    public function getSettingsUrl(Request $request)
    {
        return request();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SiteSettings  $siteSettings
     * @return \Illuminate\Http\Response
     */
    public function show(SiteSettings $siteSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SiteSettings  $siteSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSettings $siteSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SiteSettings  $siteSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteSettings $siteSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SiteSettings  $siteSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSettings $siteSettings)
    {
        //
    }
}
