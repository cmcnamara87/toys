<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ToyFuel</title>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css"
          integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">

    
    <style>
        @media (min-width: 75em) {
            .container {
                /*width: 800px;*/
            }
        }
    </style>
    <style>
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }
        .pagination > li {
            display: inline;
        }
        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            z-index: 2;
            color: #23527c;
            background-color: #eee;
            border-color: #ddd;
        }
        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }
        .pagination > .disabled > span,
        .pagination > .disabled > span:hover,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > a,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }
        .pagination-lg > li > a,
        .pagination-lg > li > span {
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.3333333;
        }
        .pagination-lg > li:first-child > a,
        .pagination-lg > li:first-child > span {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }
        .pagination-lg > li:last-child > a,
        .pagination-lg > li:last-child > span {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }
        .pagination-sm > li > a,
        .pagination-sm > li > span {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
        }
        .pagination-sm > li:first-child > a,
        .pagination-sm > li:first-child > span {
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
        }
        .pagination-sm > li:last-child > a,
        .pagination-sm > li:last-child > span {
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark navbar-full bg-primary m-b-3">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">ToyFuel</a>
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('/') }}">
                    <i class="fa fa-line-chart"></i> Trending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('bargain-bin') }}">
                    <i class="fa fa-dollar"></i> Bargain Bin
                </a>
            </li>
        </ul>
        <ul class="nav navbar-nav pull-xs-right">
            {{--<li class="nav-item active">--}}
            {{--<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
            {{--</li>--}}
            <li class="nav-item">
                <a class="nav-link" href="http://twitter.com/cmcnamara87">Tweet Me</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="mailto:cmcnamara87@gmail.com">Email Feedback</a>
            </li>
        </ul>
        {{--<form class="form-inline pull-xs-right">--}}
        {{--<input class="form-control" type="text" placeholder="Search">--}}
        {{--<button class="btn btn-success-outline" type="submit">Search</button>--}}
        {{--</form>--}}
    </div>
</nav>

<div class="container">
    @foreach($cluster->items->chunk(4) as $row)
        <div class="row m-b-3">
            @foreach($row as $item)

                <div class="col-sm-3">
                    <div class="card">
                        <div style="height:400px;background-color: white;position:relative;text-align: center;overflow: hidden;;">
                            <img src="{{ $item->gallery_plus_url }}" alt="Card image cap" style="width: 120%;height:100%;/* max-width:100%; */display:block;margin:auto;position: absolute;top:0%;filter: blur(10px) !important;-webkit-filter: blur(10px);-moz-filter: blur(5px);-o-filter: blur(5px);-ms-filter: blur(5px);filter: blur(5px);-webkit-filter: blur(100);left: -10%;right: -10%;width: 120%;/* bottom: -10px; */opacity: 0.7;">

                                <a href="{{ $item->view_item_url }}" target="_blank">
                                    <img src="{{ $item->gallery_plus_url }}"
                                         alt="Card image cap"
                                         style="padding:10px; position:absolute;top:20px;bottom:20px;left:0;right:0;max-height:100%;max-width:100%;display:block;margin:auto;">
                                </a>
                        </div>


                        <div class="card-block">
                            <p class="card-title">

                                    <a href="{{ $item->view_item_url }}" target="_blank"><strong>{{ $item->title }}</strong></a>
                                    <small class="text-muted">{{ $item->year }}</small></p>

                            <div style="position:absolute;top:5px;right:5px;padding:5px 14px;background-color:#FFF700;border-radius:1px;">
                                @if($item->currency_id != 'USD')
                                    {{ $item->currency_id }}
                                @endif
                                ${{ $item->currency_value }}
                            </div>

                            <p class="card-text">
                                <span class="text-muted">Ends: {{ $item->endsIn() }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js"
        integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7"
        crossorigin="anonymous"></script>
@include('includes.analyticstracking')
</body>
</html>