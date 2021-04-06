@extends('layouts.layout')

@section('keywords') Travel blog, blog, all posts, best destinations, best places @endsection
@section('description') All posts from my trips. Find tips, fun facts, recommendations for travel, hotel or something else. @endsection
@section('content')
    <div id="naslov">
        <h1>Blog</h1>
    </div>
    <div id="searchDiv">
        <div>
            <form action="#">
                <input type="text" placeholder="Search name or hastag" id="searchKey" name="searchKey"/>
                <input type="button" value="Search" id="btnSearch"/>
            </form>
        </div>
        <div id="hashtags">
        </div>
    </div>
    <div id="featuredPost">

    </div>
    <div id="pagination">

    </div>
@endsection
