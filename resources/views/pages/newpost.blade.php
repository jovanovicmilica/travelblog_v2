@extends('layouts.layout')

@section('keywords') Travel blog, blog, all posts, best destinations, best places @endsection
@section('description') All posts from my trips. Find tips, fun facts, recommendations for travel, hotel or something else. @endsection
@section('content')
    <div id="naslov">
        <h1>Add post</h1>
    </div>
    <div id="mainAdmin" class="formAddPostUser">
        <form enctype="multipart/form-data">
            @csrf
            <input type="text" placeholder="Title" id="title">
            <p id="errorTitle"></p>
            <textarea id="summernote" name="editordata"></textarea>
            <p id="errorText"></p>
            <p>Thumbnail photo</p>
            <input type="file" id="thumbnail">
            <p id="errorThumbnail"></p>
            <p>Other photos</p>
            <input type="file" multiple id="photos">
            <p id="errorPhotos"></p>
            <div>
                @foreach($hashtags as $h)
                <input type="checkbox" value="{{$h->idHashtag}}" name="chbHash"><span> {{$h->hashtag}} </span>
                @endforeach
            </div>
            <input type="button" value="Add post" id="addNewPost"/>
            </form>
        <p id="errorInsert"></p>
    </div>
@endsection
