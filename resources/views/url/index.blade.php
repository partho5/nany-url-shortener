@extends('layouts.app')

@section('content')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css"
          rel="stylesheet">

    <div class="max-w-6xl mx-auto p-6 mt-8 bg-white shadow-lg rounded-xl">
        <h2 class="text-3xl font-bold text-center mb-4">Shortened URLs</h2>

        @include('url.partial.basic-nav')

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg">
                <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Original URL</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Short URL</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Created</th>
                </tr>
                </thead>
                <tbody>
                @foreach($urls as $url)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $url->id }}</td>
                        <td class="px-6 py-4 text-sm text-blue-600 truncate max-w-xs">
                            <a href="{{ $url->destination_url }}" target="_blank" class="hover:underline">
                                {{ Str::limit($url->destination_url, 50, '...') }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-green-600">
                            <a href="{{ $url->default_short_url }}" target="_blank" class="hover:underline">
                                {{ $url->default_short_url }}
                            </a>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-500">{{ $url->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $urls->links() }}
        </div>
    </div>
@endsection
