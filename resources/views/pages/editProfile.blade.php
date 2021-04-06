@extends('layouts.layout')

@section('keywords') Travel blog, blog, edit profile, Your informations @endsection
@section('description') Hi, You want to change you informations, let's do it! @endsection

@section('content')
    <div id="naslov"><h1>Edit profile</h1></div>
    <div id="userEdit">
        <div id="userInfo">

        </div>
        <div id="editForm">
            <form id="editUserform">
                @csrf
                <input type="text" id="userName" placeholder="First Name">
                <p id="errorEditFname"></p>
                <input type="text" id="userLname" placeholder="Last Name">
                <p id="errorEditLname"></p>
                <input type="text" id="userEmail" placeholder="E-mail">
                <p id="errorEditEmail"></p>
                <input type="password" id="newPass" placeholder="New password">
                <p id="errorEditPass"></p>
                <input type="button" value="Edit" id="btnEditUser"/>
                <p id="errorEdit"></p>
            </form>
        </div>
    </div>
@endsection
