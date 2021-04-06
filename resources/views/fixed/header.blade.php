<header>
    <nav>
        <ul>
            @foreach($menu as $m)
                @if(session()->has("user"))
                    @if(session()->get("user")->role=="admin")
                        @if($m->preview==0 || $m->preview==3 || $m->preview==2)
                            @if($m->route=="logout")
                                <li><a href id="{{$m->route}}">{{$m->name}}</a></li>
                            @else
                                <li><a href="{{route($m->route)}}" id="{{$m->route}}">{{$m->name}}</a></li>
                            @endif
                        @endif
                    @else
                        @if($m->preview==0 || $m->preview==3 || $m->preview==4)
                            @if($m->route=="logout")
                                <li><a href id="{{$m->route}}">{{$m->name}}</a></li>
                            @else
                                <li><a href="{{route($m->route)}}" id="{{$m->route}}">{{$m->name}}</a></li>
                            @endif
                        @endif
                    @endif
                @else
                    @if($m->preview==0 || $m->preview==1)
                        @if($m->route=="login")
                            <li><a href id="{{$m->route}}">{{$m->name}}</a></li>
                        @else
                            <li><a href="{{route($m->route)}}" id="{{$m->route}}">{{$m->name}}</a></li>
                        @endif
                    @endif
                @endif
            @endforeach
        </ul>
    </nav>
    <div id="network">
        <ul>
            @foreach($networks as $network)
                <li><a href="{{$network->link}}" target="_blank"><i class="{{$network->icon}}"></i></a></li>
            @endforeach
        </ul>
    </div>
</header>
