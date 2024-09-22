@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">
        <div class="flex">
            <h1 class="text-2xl mb-4">
                Seus relatórios
            </h1> 
        </div>
		@foreach ($reports as $report)
			<h1 class="text-1xl mb-4 mt-4">
                {{$report['title']}}
            </h1>
			<div class="mb-12">
				@include('components.simple-table', [
					'header' => $report['aliases'],
					'content' => $report['results'],
				])
			</div>
		@endforeach
    </div>
@endsection
