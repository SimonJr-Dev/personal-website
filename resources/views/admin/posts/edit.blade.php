@extends('admin.layout')

@section('title', 'Edit post')
@section('heading', 'Edit post')
@section('subheading', $post->title)

@section('content')
    @include('admin.posts.form', ['post' => $post])
@endsection
