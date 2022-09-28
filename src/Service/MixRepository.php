<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
class MixRepository
{
//    private HttpClientInterface $httpClient;
//    private CacheInterface $cache;
//
//    public function __construct(HttpClientInterface $httpClient, CacheInterface $cache)
//    {
//        $this->httpClient = $httpClient;
//        $this->cache = $cache;
//    }
//
//    OR

    public function __construct(
        private HttpClientInterface $githubContentClient,
        private CacheInterface      $cache

    )
    {}

    public function findAll()
    {
        return $this->cache->get('mixes_data', function (CacheItemInterface $cacheItem) {
            $response = $this->githubContentClient->request('GET', '/SymfonyCasts/vinyl-mixes/main/mixes.json');

            return $response->toArray();
        });
    }
}