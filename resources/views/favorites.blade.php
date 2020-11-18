<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>My Favorite Repositories</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    </head>
    <body>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                <span class="menu-title">Logout</span>
            </a>
            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="menu-title">Search Page</span>
            </a>
        </li>
        <div class="container">
            @if(isset($details))
                <h2>Favorite Repositories</h2>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Repo name</th>
                        <th>Html url</th>
                        <th>Description</th>
                        <th>Owner</th>
                        <th>Repo stars</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($details as $detail)
                        <tr id="row-{{$detail->id}}">
                            <td>{{$detail->name}}</td>
                            <td>{{$detail->html_url}}</td>
                            <td>{{$detail->description}}</td>
                            <td>{{$detail->owner_login}}</td>
                            <td>{{$detail->stargazers_count}}</td>
                            <td>
                                <a href="/remove-favorite-repo" class="btn btn-danger js-remove-favorite" data-data="{{$detail->id}}">Remove</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <script type="text/javascript">
            $('.js-remove-favorite').on('click', function(e) {
                e.preventDefault();
                let $this = $(this),
                    $id = $this.data('data');
                $.ajax({
                    type : 'post',
                    url : $this.attr('href'),
                    data: {
                        'id': $id
                    },
                    success:function(data) {
                        $('#row-'+$id).remove();
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </body>
</html>
