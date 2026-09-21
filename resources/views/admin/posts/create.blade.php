@extends('admin.layout')

@section('title', 'New post')
@section('heading', 'New post')
@section('subheading', 'Write a post for the blog.')

@section('content')
    @include('admin.posts.form', ['post' => $post])
@endsection
