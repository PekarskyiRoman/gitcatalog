<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Git Repo Catalog</title>
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
            <a class="nav-link" href="{{ route('my-favorites') }}">
                <span class="menu-title">My Favorites</span>
            </a>
        </li>
        <div class="container">
            <form action="/search" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="Search repos">
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        search
                    </button>
                </span>
                </div>
            </form>

            @if(isset($details))
                <p> The Search results for your query <b> {{ $query }} </b> are :</p>
                <h2>Repositories details</h2>
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
                        <tr>
                            <td>{{$detail['name']}}</td>
                            <td>{{$detail['html_url']}}</td>
                            <td>{{$detail['description']}}</td>
                            <td>{{$detail['owner']}}</td>
                            <td>{{$detail['stargazers_count']}}</td>
                            <td>
                                @if(array_search($detail['git_id'], $favorites) !== false)
                                    <a href="/remove-favorite" class="btn btn-danger js-remove-favorite" data-data="{{json_encode($detail)}}">Remove</a>
                                @else
                                    <a href="/add-favorite" class="btn btn-success js-add-favorite" data-data="{{json_encode($detail)}}">Add</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <script type="text/javascript">
            $(document).delegate('.js-add-favorite', 'click', function(e) {
                e.preventDefault();
                let $this = $(this);
                $.ajax({
                    type : 'post',
                    url : $this.attr('href'),
                    data: $this.data('data'),
                    success:function(data) {
                        let $parent = $this.parent();
                        $parent.children().remove();
                        $parent.append(data);
                    }
                });
            });

            $(document).delegate('.js-remove-favorite', 'click', function(e) {
                e.preventDefault();
                let $this = $(this);
                $.ajax({
                    type : 'post',
                    url : $this.attr('href'),
                    data: $this.data('data'),
                    success:function(data) {
                        let $parent = $this.parent();
                        $parent.children().remove();
                        $parent.append(data);
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
