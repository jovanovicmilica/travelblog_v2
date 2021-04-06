@extends('layouts.layout')

@section('keywords') Travel blog, blog, all posts, best destinations, best places @endsection
@section('description') All posts from my trips. Find tips, fun facts, recommendations for travel, hotel or something else. @endsection
@section('content')
    <div id="naslov">
        <h1>Edit post</h1>
    </div>
    <div id="mainAdmin" class="formAddPostUser">
        <form enctype="multipart/form-data">
            @csrf
            <input type="text" placeholder="Title" value="{{$post->title}}" id="title">
            <p id="errorTitle"></p>
            <textarea id="summernote" name="editordata">{{$post->text}}</textarea>
            <p id="errorText"></p>
            <p>Thumbnail photo</p>
            <input type="file" id="thumbnail">
            <p id="errorThumbnail"></p>
            <p>Other photos</p>
            <input type="file" multiple id="photos">
            <p id="errorPhotos"></p>
            <div>

                @foreach($hashtags as $h)
                    <input type="checkbox" value="{{$h->idHashtag}}"
                           @if(in_array($h->idHashtag,$hashtag->pluck('idHashtag')->toArray()))
                               checked="true"
                               @endif
                           name="chbHash"><span> {{$h->hashtag}} </span>
                @endforeach
            </div>
            <input type="button" value="Edit post" id="editPost"/>
        </form>
        <input type="hidden" value="{{$post->id}}" id="idPostHidden">
        <p id="errorInsert"></p>
    </div>
@endsection
