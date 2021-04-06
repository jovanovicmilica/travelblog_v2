@extends('layouts.layout')

@section('keywords') Travel blog, blog, one post, trips, {{$post->title}}, comment, like @endsection
@section('description') Hi, read more about {{$post->title}}. @endsection
@section('content')
    <div id="naslov"><h1>{{$post->title}}</h1></div>
    <div id="onePost">
        <div id="slikaPost">
            @foreach($images as $im)
                <div><img src="{{asset("assets/images/".$im->src)}}" alt="{{$post->title}}"></div>
            @endforeach
        </div>
        <div id="textPost">
            {{--@foreach(explode("\r\n\r\n",$post->text) as $p)
                <p>{{$p}}</p>
            @endforeach--}}
            {!!    html_entity_decode($post->text) !!}
        </div>
        <div class="blogAuthor">
            <p>Author: {{$post->firstName}}  {{$post->lastName}}</p>
        </div>
        @if(session()->has("user") && session()->get("user")->idUser==$post->idUser)
            <div class="blogAuthor">
                <a href="{{route("post.edit",$post->id)}}">Edit post</a>
            </div>
        @endif
    </div>
    <div id="comments">
        <div id="likes">
            <a href="#" id="like"></a>
            <span id="likeError"></span>
            <span id="countLikes"></span>
        </div>
        <h2>Comments</h2>
        <p id="noComments"></p>
        <div id="commentsDiv"></div>
        @if(session()->has('user'))
            <form action="#">
                @csrf
                <textarea placeholder="Your comment" id="commentText"></textarea>
                <p id="errorComment"></p>
                <input type="button" value="Post comment" id="btnComment">
            </form>
        @else
            <p>Log in to post comments!</p>
        @endif
    </div>
@endsection
