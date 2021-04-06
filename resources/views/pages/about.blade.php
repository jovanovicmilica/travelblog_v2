@extends('layouts.layout')

@section('keywords') Travel blog, blog, about me, Kiki, California @endsection
@section('description') Hi, I’m Kiki, a California native, who left my career in corporate wealth management six years ago to embark on a summer of soul searching that would change the course of my life forever. @endsection
@section('content')
    <div id="naslov"><h1>About me</h1></div>
    <div id="aboutMe">
        <div id="hi">
            <p>Hi, I’m Kiki, a California native, who left my career in corporate wealth management six years ago to embark on a summer of soul searching that would change the course of my life forever.</p>
        </div>
        <div id="aboutImg">
            <img src="{{asset("assets/images/about.jpg")}}">
        </div>
        <div id="image">
            <img src="{{asset("assets/images/beach.jpg")}}">
        </div>
        <div id="about2">
            <img src="{{asset("assets/images/about2.jpg")}}">
        </div>
        <div id="text2">
            <p>
                Like many people, I was taught to go to college, get a job, get married, have kids and live happily ever after. Not once did I consider that chasing the societal idea of “success” would lead me to an unfulfilling and unhappy life. Back in 2011, I took a hiatus from my career and spent 3 months traveling through Australia, Thailand, Cambodia, Vietnam, Bali and New Zealand and experienced the empowerment of solo travel for the first time.
            </p>

            {{--<p>
            Since embarking on that first world tour, I've spent the past decade sharing my personal journey and travel
            tips on this website with women around the world. I have traveled to over 70 countries, lived in Cape Town,
            South Africa, and have settled down in California—and I'm not stopping there! READ MY FULL STORY
        </p>--}}
        </div>
    </div>
@endsection
