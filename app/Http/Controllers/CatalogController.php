<?php

namespace App\Http\Controllers;


use App\Services\FavoriteService;
use App\Services\GitApiService;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    protected $gitService;
    protected $favoriteService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->gitService = new GitApiService();
        $this->favoriteService = new FavoriteService();
    }

    public function search(Request $request)
    {
        $q = $request->get('q');
        $repos = [];
        $favorites = $this->favoriteService->getUserFavoritesGitId();
        if (!empty($q)) {
            $repos = $this->gitService->getSearchRepos($q);
        }
        if (count ( $repos ) > 0) {
            return view('search')->with([
                'details' => $repos,
                'query' => $q,
                'favorites' => $favorites
            ]);
        } else {
            return view('search')->withMessage('No repos found. Try to search again !');
        }
    }

    public function add_favorite(Request $request)
    {
        $data = $request->post();
        $this->favoriteService->addFavorite($data);
        return "<a href='/remove-favorite' class='btn btn-danger js-remove-favorite' data-data='".json_encode($data)."'>Remove</a>";
    }

    public function remove_favorite(Request $request)
    {
        $data = $request->post();
        $this->favoriteService->removeFavorite($data['git_id']);
        return "<a href='/add-favorite' class='btn btn-success js-add-favorite' data-data='".json_encode($data)."'>Add</a>";
    }

    public function my_favorites()
    {
        return view('favorites')->with([
            'details' => $this->favoriteService->getUserFavorites()
        ]);
    }

    public function remove_favorite_repo(Request $request)
    {
        $this->favoriteService->removeFavoriteById($request->post('id'));
    }

}