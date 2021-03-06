@extends('layouts.backend.app')

@section('title','Post')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.btn {
  background-color: DodgerBlue;
  border: none;
  color: white;
  padding: 7px 30px;
  cursor: pointer;
  font-size: 15px;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
} 
</style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <a href="{{ route('author.post.index') }}" class="btn btn-danger waves-effect">BACK</a>
        @if($post->is_approved == false)
            <button type="button" class="btn btn-danger waves-effect pull-right" disabled>
                <span>Pending</span>
            </button>
        @else
            <button type="button" class="btn btn-success waves-effect pull-right" disabled>
                <i class="material-icons">done</i>
                <span>Approved</span>
            </button>
        @endif
        <br>
        <br>
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              {{ $post->title }}
                                <small>Posted By <strong> <a href="">{{ $post->user->name }}</a></strong> on {{ $post->created_at->toFormattedDateString() }}</small>
                            </h2>
                        </div>
                        <div class="body">
                            {!! $post->body !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">

                    <!-- <div class="card">
                        <div class="header bg-cyan">
                            <h2>
                                Categoryies
                            </h2>
                        </div>
                        <div class="body">
                            @foreach($post->categories as $category)
                                <span class="label bg-cyan">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div> -->
<!-- 
                    <div class="card">
                        <div class="header bg-green">
                            <h2>
                                Tags
                            </h2>
                        </div>
                        <div class="body">
                            @foreach($post->tags as $tag)
                                <span class="label bg-green">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div> -->

                    <div class="card">
                        <div class="header bg-amber">
                            <h2>
                                before Image
                            </h2>
                        </div>
                        <div class="body">
                        <!-- {{$post->user_id}}
                        {{$post->id}} -->
                        <!-- <button onclick="{{route('author.s3image',$post->user_id)}}">사진보기</button> -->
                        <a href="{{route('author.s3image',$post->id)}}">사진크게보기</a><br/>
                        <img src="{{$bpath}}" style="width:60%"><br/><br/>

                        <button class="btn" style="width:100%" onclick="location.href='{{route('author.s3imagedownbe',$post->id)}}'"><i class="fa fa-download"></i> Download</button>
                       

                        </div>
                    </div>

                    <div class="card">
                        <div class="header bg-amber">
                            <h2>
                                after Image
                            </h2>
                        </div>
                        <div class="body">
                        <!-- {{$post->user_id}}
                        {{$post->id}} -->
                        <!-- <button onclick="{{route('author.s3image',$post->user_id)}}">사진보기</button> -->
                       
                        
                        <a href="{{route('author.s3image',$post->id)}}">사진크게보기</a><br/>
                        <img src="{{$apath}}" style="width:60%"><br/><br/>

                        <button class="btn" style="width:100%" onclick="location.href='{{route('author.s3imagedownaf',$post->id)}}'"><i class="fa fa-download"></i> Download</button>
                       
                        

                        </div>
                    </div>


                </div>
            </div>
    </div>
@endsection

@push('js')
    <!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <!-- TinyMCE -->
    <script src="{{ asset('assets/backend/plugins/tinymce/tinymce.js') }}"></script>
    <script>
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('assets/backend/plugins/tinymce') }}';
        });
    </script>

@endpush