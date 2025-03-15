@extends('layouts.app')

@section('content')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css"
          rel="stylesheet">

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header with gradient background -->
                <div class="bg-gray-500 px-6 py-2 pt-6 sm:px-10">
                    <h2 class="text-3xl font-bold text-white text-center">Nany URL Shortener</h2>
                    <p class="text-indigo-100 text-center mt-2">With UTM Tracking</p>
                    @include('url.partial.basic-nav')
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mt-6">
                        <div class="rounded-md bg-green-50 p-4 border border-green-200">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">URL Successfully Shortened</h3>
                                    <div class="mt-2 text-sm text-green-700 flex items-center">
                                        <p>{!! session('success') !!}</p>
                                        <button id="copyBtn" class="ml-2 p-1 bg-gray-100 rounded hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="copyToClipboard()" title="Copy URL">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                                <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            @endif

                <!-- Form Container -->
                <div class="px-6 py-8 sm:px-10">
                    <form action="{{ route('url.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Original URL Input -->
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-indigo-500">
                            <label for="original_url" class="block font-medium text-gray-900 mb-1">URL to Shorten</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" />
                                    </svg>
                                </div>
                                <input
                                        type="url"
                                        name="original_url"
                                        id="original_url"
                                        required
                                        placeholder="https://example.com/your-long-url"
                                        value="{{ old('original_url') ?? "https://article.nanybot.com" }}"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-3 sm:text-sm border-gray-300 rounded-md"
                                />
                            </div>
                        </div>

                        <!-- UTM Parameters Section -->
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                            <h3 class="text-center underline text-lg font-medium text-gray-400 mb-4">Tracking Data</h3>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- utm_source -->
                                <div class="col-span-1">
                                    <label for="utm_source" class="block font-medium text-gray-700">
                                        Source <span class="text-indigo-600">*</span>
                                    </label>
                                    <div class="mt-1">
                                        <input
                                                type="text"
                                                name="utm_source"
                                                required
                                                id="utm_source"
                                                placeholder="Your affiliate username"
                                                value="{{ old('utm_source') }}"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-2"
                                        />
                                    </div>
                                    <p class="mt-1 text-xs text-gray-400">Identifies who referred the traffic</p>
                                </div>

                                <!-- utm_medium -->
                                <div class="col-span-1">
                                    <label for="utm_medium" class="block font-medium text-gray-700">
                                        Medium <span class="text-indigo-600">*</span>
                                    </label>
                                    <div class="mt-1">
                                        <select
                                                name="utm_medium"
                                                required
                                                id="utm_medium"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-2 px-4"
                                        >
                                            <option value="" disabled selected>Select a medium</option>
                                            <option value="facebook" {{ old('utm_medium') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                                            <option value="twitter" {{ old('utm_medium') == 'twitter' ? 'selected' : '' }}>Twitter/X</option>
                                            <option value="instagram" {{ old('utm_medium') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                                            <option value="linkedin" {{ old('utm_medium') == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                            <option value="reddit" {{ old('utm_medium') == 'reddit' ? 'selected' : '' }}>Reddit</option>
                                            <option value="pinterest" {{ old('utm_medium') == 'pinterest' ? 'selected' : '' }}>Pinterest</option>
                                            <option value="quora" {{ old('utm_medium') == 'quora' ? 'selected' : '' }}>Quora</option>
                                            <option value="medium_dot_com" {{ old('utm_medium') == 'medium_dot_com' ? 'selected' : '' }}>Medium.com</option>
                                            <option value="googleAds" {{ old('utm_medium') == 'google' ? 'selected' : '' }}>Google Ads</option>
                                            <option value="googleSearch" {{ old('utm_medium') == 'google' ? 'selected' : '' }}>Google Search</option>
                                            <option value="youtube" {{ old('utm_medium') == 'social' ? 'selected' : '' }}>YouTube</option>

                                            <option value="email" {{ old('utm_medium') == 'email' ? 'selected' : '' }}>Email Marketing</option>
                                            <option value="referral" {{ old('utm_medium') == 'referral' ? 'selected' : '' }}>Referral</option>
                                            <option value="display" {{ old('utm_medium') == 'display' ? 'selected' : '' }}>Display Ads</option>
                                            <option value="organic" {{ old('utm_medium') == 'organic' ? 'selected' : '' }}>Organic</option>
                                            <option value="cpc" {{ old('utm_medium') == 'cpc' ? 'selected' : '' }}>Paid Search (CPC)</option>
                                            <option value="other" {{ old('utm_medium') == 'organic' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-400">Marketing medium: social media, email etc.</p>
                                </div>

                                <!-- utm_campaign -->
                                <div class="col-span-1">
                                    <label for="utm_campaign" class="block font-medium text-gray-700">
                                        Campaign Name <span class="text-indigo-600">*</span>
                                    </label>
                                    <div class="mt-1">
                                        <input
                                                type="text"
                                                name="utm_campaign"
                                                id="utm_campaign"
                                                placeholder="e.g., spring_sale, product_launch"
                                                value="{{ old('utm_campaign') ?? 'General' }}"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-2"
                                        />
                                    </div>
                                    <p class="mt-1 text-xs text-gray-400">Name of your specific marketing campaign</p>
                                </div>

                                <!-- utm_term -->
                                <div class="col-span-1">
                                    <label for="utm_term" class="block font-medium text-gray-700">
                                        Keywords <span class="text-gray-400">(Optional)</span>
                                    </label>
                                    <div class="mt-1">
                                        <input
                                                type="text"
                                                name="utm_term"
                                                id="utm_term"
                                                placeholder="e.g., SEO article, AI article etc."
                                                value="{{ old('utm_term') }}"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-2"
                                        />
                                    </div>
                                    <p class="mt-1 text-xs text-gray-400">Paid search keywords</p>
                                </div>

                                <!-- utm_content -->
                                <div class="col-span-1 md:col-span-2">
                                    <label for="utm_content" class="block font-medium text-gray-700">
                                        Content <span class="text-gray-400">(Optional)</span>
                                    </label>
                                    <div class="mt-1">
                                        <input
                                                type="text"
                                                name="utm_content"
                                                id="utm_content"
                                                placeholder="e.g., logolink, textlink, blue_banner"
                                                value="{{ old('utm_content') }}"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-2"
                                        />
                                    </div>
                                    <p class="mt-1 text-xs text-gray-400">Used to differentiate similar content or links within the same ad</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button
                                    type="submit"
                                    class="inline-flex items-center px-8 py-4 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150"
                            >
                                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                Generate Short URL
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-6 text-center text-xs text-gray-500">
                <p>Track your marketing campaigns effectively with custom UTM parameters</p>
            </div>
        </div>
    </div>

@endsection