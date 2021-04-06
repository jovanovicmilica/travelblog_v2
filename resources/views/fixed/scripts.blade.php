
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

@if(request()->routeIs("admin") || request()->routeIs("addPost") || request()->routeIs("post.edit"))
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endif


<script>
    const BASE_URL="{{url('/')}}"
    const STRANA="{{\Request::path()}}"
</script>
<script src="{{asset("assets/js/main.js")}}" type="text/javascript"></script>


