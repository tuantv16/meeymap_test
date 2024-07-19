@extends('welcome')
@section('title_meta')
<meta name="robots" content="noindex,nofollow">
<title>test abc</title>
@endsection


@section('css')

@endsection

@section('main')
<article>
    <top-page-component />
</article>
@endsection

@section('js')
@vite(['resources/js/manage/test.js'])
@endsection