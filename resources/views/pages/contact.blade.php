@extends('layouts.layout')

@section('keywords') Travel blog, blog, question, ask me, contact form @endsection
@section('description') on't see travel tips for a destination you're traveling to? Want a guide for a destination I've shared on my Instagram? Test me! @endsection
@section('content')
@section('content')
    <div id="naslov"><h1>Contact</h1></div>
    </div>
    <div id="contactContainer">
        <div id="textContact">
            <h2>Contact me</h2>
            <p>Don't see travel tips for a destination you're traveling to? Want a guide for a destination I've shared on my Instagram? Your wish is my command! I share 5 blog posts every week and will do my best to create one based on your request! Please Note: Because I get hundreds of requests, you will not get a response unless I create the post!</p>
        </div>
        <div id="contactForm">
            <form action="#">
                <input type="text" placeholder="First Name" id="firstName"/>
                <p id="errorFName"></p>
                <input type="text" placeholder="Last Name" id="lastName"/>
                <p id="errorLName"></p>
                <input type="text" placeholder="E-mail" id="email"/>
                <p id="errorEmailMessage"></p>
                <input type="text" placeholder="Subject" id="subject"/>
                <p id="errorSubject"></p>
                <textarea placeholder="Message" id="message"></textarea>
                <p id="errorMessage"></p>
                <input type="button" value="Send" id="btnSendMessage">
                <p id="messageMessage"></p>
            </form>
        </div>
    </div>
@endsection
