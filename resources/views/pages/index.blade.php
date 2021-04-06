@extends('layouts.layout')

@section('keywords') Travel blog, blog, travel, trips, tips @endsection
@section('description') The Blonde Abroad is an award-winning solo female travel blog featuring travel tips, packing guides, videos and photography from around the world. @endsection
@section('content')
    <div id="naslov">
        <a href="{{route("index")}}"> <h1>Travel blog</h1></a>
    </div>
    <div id="slika">
        <img src="{{asset("assets/images/homepage.jpg")}}" alt="Homepage image"/>
    </div>
    <div id="featured">
        <h2>Featured from the blog</h2>
        <div id="featuredPost">

        </div>
    </div>
    <div id="seeON">
        <h2>Featured by</h2>
        <div id="featuredBy">


            @foreach($sponsors as $sponsor)
                <div><img src="{{asset("assets/images/".$sponsor->img)}}" alt="{{$sponsor->name}}"></div>
            @endforeach
        </div>
    </div>
    <div id="pictures">
        <div><img src="{{asset("assets/images/slika3.jpg")}}"/></div>
        <div><img src="{{asset("assets/images/slika4.jpg")}}"/></div>
        <div><img src="{{asset("assets/images/slika2.jpg")}}"/></div>
        <div><img src="{{asset("assets/images/slika1.jpg")}}"/></div>
    </div>



@endsection
