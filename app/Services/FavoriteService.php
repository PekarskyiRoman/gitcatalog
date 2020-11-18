<?php

namespace App\Services;


use App\Models\FavoriteRepository;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function getUserFavoritesGitId()
    {
        $favorites = FavoriteRepository::select('git_id')->where('user_id', Auth::user()->id)->get();
        $result = [];
        if (isset($favorites)) {
            foreach ($favorites as $item) {
                $result[] = $item->git_id;
            }
        }
        return $result;
    }

    public function addFavorite($props)
    {
        $favorite = new FavoriteRepository();
        $favorite->user_id = Auth::user()->id;
        $favorite->git_id = $props['git_id'];
        $favorite->name = $props['name'];
        $favorite->html_url = $props['html_url'];
        $favorite->description = $props['description'];
        $favorite->owner_login = $props['owner'];
        $favorite->stargazers_count = $props['stargazers_count'];
        $favorite->save();
    }

    public function removeFavorite($repo_id)
    {
        FavoriteRepository::where([
            'user_id' => Auth::user()->id,
            'git_id' => $repo_id
        ])->delete();
    }

    public function getUserFavorites()
    {
        return FavoriteRepository::where('user_id', Auth::user()->id)->get();
    }

    public function removeFavoriteById($id)
    {
        FavoriteRepository::where('id', $id)->delete();
    }
}