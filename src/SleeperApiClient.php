<?php
namespace DanAbrey\SleeperApi;

use DanAbrey\SleeperApi\Denormalizers\SleeperLeagueDenormalizer;
use DanAbrey\SleeperApi\Denormalizers\SleeperRosterDenormalizer;
use DanAbrey\SleeperApi\Models\SleeperLeague;
use DanAbrey\SleeperApi\Models\SleeperLeagueSettings;
use DanAbrey\SleeperApi\Models\SleeperLeagueUser;
use DanAbrey\SleeperApi\Models\SleeperRoster;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SleeperApiClient
{
    private Serializer $serializer;
    private ResponseParser $responseParser;
    private HttpClientInterface $httpClient;

    private const API_BASE = "https://api.sleeper.app/v1";

    public function __construct()
    {
        $this->httpClient = HttpClient::create();
    }

    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    protected function get(string $path)
    {
        $response = $this->httpClient->request('GET', self::API_BASE . $path);
        
        if ($response->getStatusCode() !== 200) {
            throw new SleeperApiException();
        }
        
        return json_decode($response->getContent(), true);
    }

    /**
     * @param string $leagueId
     * @return array|SleeperLeague
     * @throws SleeperApiException
     */
    public function league(string $leagueId): SleeperLeague
    {
        $response = $this->get('/league/' . $leagueId);

        $normalizers = [new ArrayDenormalizer(), new SleeperLeagueDenormalizer()];
        $serializer = new Serializer($normalizers);
        return $serializer->denormalize($response, SleeperLeague::class);
    }

    /**
     * @param string $leagueId
     * @return array|SleeperLeagueUser[]
     * @throws SleeperApiException
     */
    public function users(string $leagueId): array
    {
        $response = $this->get('/league/' . $leagueId . '/users');

        $normalizers = [new ArrayDenormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers);
        return $serializer->denormalize($response, SleeperLeagueUser::class . '[]');
    }

    /**
     * @param string $leagueId
     * @return array|SleeperRoster[]
     * @throws SleeperApiException
     */
    public function rosters(string $leagueId): array
    {
        $response = $this->get('/league/' . $leagueId . '/rosters');

        $normalizers = [new ArrayDenormalizer(), new SleeperRosterDenormalizer()];
        $serializer = new Serializer($normalizers);
        return $serializer->denormalize($response, SleeperRoster::class . '[]');
    }
}
