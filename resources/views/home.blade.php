@extends('app')

@section('content')
    <div class="container">
    <div class="row">
        <div class="d-flex justify-content-center"><img src="{{url('storage/imdb-logo.png')}}" class="img-fluid" style="max-width:300px"></div>
        <form id="frm_search" method="POST" action="{{url('search')}}">
            <div class="d-flex justify-content-center">
                    <input required type="text" class="form-control" id="search" name="search" placeholder="Enter at least 4 characters to search movie" />
            </div>
            <br/>
            <div class="d-flex justify-content-center">
                <button type="submit" id="submit" class="btn btn-primary mb-3">Search</button>
            </div>
        </form>
        <br>
        <div id="result"></div>
    </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#search').autocomplete({
                source: '{{url("autocomplete")}}',
                minLength: 4
            }).data('ui-autocomplete')._renderItem = function(ul, item){
                return $("<li class='ui-autocomplete-row'></li>")
                    .data("item.autocomplete", item)
                    .append(item.label)
                    .appendTo(ul);
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#frm_search").submit(function(e) {
                e.preventDefault();
                var search = $("input#search").val();
                $.ajax({
                    type: "POST",
                    url: "{{url("search")}}",
                    data: $(this).serialize(),
                    success: function(data) {
                        var resp=JSON.parse(data.data).result;
                        console.log(resp);
                        var result='<h4>Results for "'+search+'"</h4><br><br>';
                        result+='<table class="table">\n' +
                            '  <thead>' +
                            '    <tr>' +
                            '      <th scope="col"></th>' +
                            '      <th scope="col">Title</th>' +
                            '      <th scope="col">Year</th>' +
                            '      <th scope="col"> - </th>' +
                            '    </tr>' +
                            '  </thead><tbody>';
                        $.each(resp, function(index, value) {

                                result+='<tr><td><img src="'+value.Poster+'" class="img-fluid" style="max-width:100px"></td>' +
                                '<td>'+value.Title+'</td>' +
                                '<td>'+value.Year+'</td>' +
                                '<td><input onClick="window.location=\'{{url('title/')}}/'+value.imdbID+'\'" type="button" class="btn btn-primary" value="Details"></td></tr>'
                        });
                        result+="</tbody></table>";

                        $("#result").html(result);
                    }
                });
            });
        });

        function viewAll(){
            $("#submit").trigger('click');
        }
    </script>

@endsection
