<?php

namespace App\Services;

use GuzzleHttp\Client;

class GitApiService
{
    protected $client;
    protected $page_count;
    protected $fetchedData = [];

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json'
            ]
        ]);

        $this->page_count = 100;
    }

    /**
     * @param $query
     * @return array
     */
    public function getSearchRepos($query)
    {
        $res = $this->fetchData($query);
        $data = $this->getNecessaryData($res);

        return $data;
    }

    protected function fetchData($query, $current_page = 1)
    {
        $response = $this->client->get('https://api.github.com/search/repositories?q='.$query.
            '&per_page='.$this->page_count.
            '&page='.$current_page
        );

        $data = json_decode($response->getBody());

        if (!empty($data->items)) {
            $this->fetchedData = array_merge($this->fetchedData, $data->items);

            if ($current_page <= 9) {
                $this->fetchData($query, $current_page + 1);
            }
        }

        return $this->fetchedData;
    }

    /**
     * Get only necessary data from all git repo data
     *
     * @param $all_data
     * @return array
     */
    protected function getNecessaryData($all_data)
    {
        $res = [];

        foreach ($all_data as $data) {
            $res[] = [
                'git_id' => $data->id,
                'name' => $data->name,
                'html_url' => $data->html_url,
                'description' => $data->description,
                'owner' => $data->owner->login,
                'stargazers_count' => $data->stargazers_count
            ];
        }

        return $res;
    }
}