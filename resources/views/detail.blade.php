@extends('app')

@section('content')
    <div class="container">
    <div class="row">
        <div class="d-flex justify-content-center"><img src="{{url('storage/imdb-logo.png')}}" class="img-fluid" style="max-width:200px"></div>
    </div>

        <br/>

        <div class="row">
            <div class="col-md-2"><img src="{{$details->result->Poster}}" class="img-fluid" style="max-width:150px"></div>
            <div class="col-md-5"><h1>{{$details->result->Title}}</h1>
                {{$details->result->Year}} . {{$details->result->Rated}} . {{$details->result->Runtime}}
                <br/>
                {{$details->result->Genre}}
                <br/>
                Director: {{$details->result->Director}}
                <br/>
                Writer: {{$details->result->Writer}}
                <br/>
                Stars: {{$details->result->Actors}}
                <br/>
                Country: {{$details->result->Country}}
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-4">
                <b>IMDb Rating:</b> <br/>
                {{$details->result->imdbRating}}/10
                    </div>
                    <div class="col-8">
                        <b>Our Rating:</b> <br/>
                        @if($movieRating)
                            {{$movieRating}}/10
                        @else
                            N/A
                        @endif
                    </div>
                </div>
            <br/>
                <div class="row">
                <div class="col-4">
                <b>Your Vote:</b>
                    <div id="divYourVote">
                        @if($userRating)
                            {{$userRating}}/10
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <ul id='stars'>
                        @for($i = 1; $i <= 10; $i++)
                            <li class='star @if($i<=$userRating) selected @endif' title='{{ $i }}' data-value='{{ $i }}'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                        @endfor
                    </ul>
                </div>
                </div>
            </div>

        </div>

<br/>
        <div class="row">
            {{$details->result->Plot}}
        </div>


    </div>

    <script>
        $(document).ready(function(){
            /* Hover code */
            $('#stars li')
                .on('mouseover', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
                    $(this).parent().children('li.star').each(function(e){
                        if (e < onStar) {
                            $(this).addClass('hover');
                        }
                        else {
                            $(this).removeClass('hover');
                        }
                    });
                }).on('mouseout', function(){
                $(this).parent().children('li.star').each(function(e){
                    $(this).removeClass('hover');
                });
            });

            /* click code */
            $('#stars li')
                .on('click', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                    var stars = $(this).parent().children('li.star');

                    for (i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('selected');
                    }

                    for (i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('selected');
                    }

                    $.ajax({
                        type: "GET",
                        url: "{{url("rate/$movieId")}}/"+i,
                        success: function(data) {
                            $("#divYourVote").html(i+'/10');
                        }
                    });

                });
        });
    </script>

@endsection
