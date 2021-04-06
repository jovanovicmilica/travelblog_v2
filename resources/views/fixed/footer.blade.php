<footer>
    <div id="footerContent">
        <a href="{{route('index')}}">Travel blog</a>
        <p> “The use of traveling is to regulate imagination with reality, and instead of thinking of how things may be, see them as they are.” – Samuel Johnson</p>
        <ul>
            @foreach($networks as $network)
                <li><a href="{{$network->link}}" target="_blank"><i class="{{$network->icon}}"></i></a></li>
            @endforeach
        </ul>
        <a class="linkAutor" href="{{route("author")}}">Author</a>
    </div>
</footer>
