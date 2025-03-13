<?php

namespace App\Http\Controllers;

use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Http\Request;
use AshAllenDesign\ShortURL\Classes\Builder;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = ShortURL::where('created_by', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('url.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('url.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'original_url' => 'required|url',
            'utm_source' => 'nullable|string',
            'utm_medium' => 'nullable|string',
            'utm_campaign' => 'nullable|string',
            'utm_term' => 'nullable|string',
            'utm_content' => 'nullable|string',
        ]);

        // Extract base URL (remove any existing UTM parameters)
        $baseUrl = preg_replace('/\?.*/', '', $request->original_url);

        // Build the UTM parameters array
        $utmParams = array_filter([
            'utm_source' => $request->utm_source,
            'utm_medium' => $request->utm_medium,
            'utm_campaign' => $request->utm_campaign,
            'utm_term' => $request->utm_term,
            'utm_content' => $request->utm_content,
        ]);

        // Build the URL with UTM parameters
        $urlToShorten = !empty($utmParams)
            ? $baseUrl . '?' . http_build_query($utmParams)
            : $baseUrl;

        // Create the short URL
        $shortURLObject = app(Builder::class)
            ->destinationUrl($urlToShorten)
            ->make();

        $shortURL = $shortURLObject->default_short_url;

        return redirect()->route('url.create')->with(
            'success',
            "<a target='_blank' href='$shortURL' class='text-blue-500 ml-2'>$shortURL</a>"
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
