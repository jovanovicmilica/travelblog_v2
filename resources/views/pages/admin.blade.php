<!doctype html>
<html lang="en">
@include('fixed.head')
<body>


<div id="adminDiv">

    <div id="navAdmin">
        <p id="adminSite">Travell blog</p>
        @csrf
        <a href="{{route("index")}}" id="home">Home</a>
        <ul>
            <li>
                <p><i class="fas fa-chart-line"></i> Activity</p>
            </li>
            <li>
                <a href="" id="activity">All activity</a>
            </li>
            <li>
                <p><i class="fas fa-camera"></i> Posts</p>
            </li>
            <li>
                <a href="" id="allPostsAdmin">All Posts</a>
            </li>
            <li>
                <p><i class="fas fa-ad"></i> Sponsors</p>
            </li>
            <li>
                <a href="" id="allSponsors">All sponsors</a>
            </li>
            <li>
                <a href="" id="addSponsor">Add sponsor</a>
            </li>
            <li>
                <p><i class="fas fa-share-alt"></i> Networks</p>
            </li>
            <li>
                <a href="" id="allNetworks">All networks</a>
            </li>
            <li>
                <a href="" id="addNetwork">Add network</a>
            </li>
            <li>
                <p><i class="fas fa-hashtag"></i> Hastags</p>
            </li>
            <li>
                <a href="" id="allHashtags">All hastags</a>
            </li>
            <li>
                <a href="" id="addHashtag">Add hastag</a>
            </li>

            <li>
                <p><i class="fas fa-users"></i> Users</p>
            </li>
            <li>
                <a href="" id="allUsers">All users</a>
            </li><li>
                <p><i class="fas fa-envelope"></i> Messages</p>
            </li>
            <li>
                <a href="" id="allMessages">All messages</a>
            </li>
            <li>
                <p><i class="fas fa-comments"></i> Comments</p>
            </li>
            <li>
                <a href="" id="allComments">All comments</a>
            </li>
        </ul>
    </div>
    <div id="mainAdmin">
            <h1> Hi, {{session()->get("user")->firstName}}</h1>
        <h2>Welcome to admin panel</h2>
    </div>
</div>

@include('fixed.scripts')

</body>
</html>
