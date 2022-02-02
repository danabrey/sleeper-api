<?php
namespace DanAbrey\SleeperApi;

use DanAbrey\SleeperApi\Denormalizers\SleeperDraftDenormalizer;
use DanAbrey\SleeperApi\Denormalizers\SleeperLeagueDenormalizer;
use DanAbrey\SleeperApi\Denormalizers\SleeperRosterDenormalizer;
use DanAbrey\SleeperApi\Models\SleeperDraft;
use DanAbrey\SleeperApi\Models\SleeperLeague;
use DanAbrey\SleeperApi\Models\SleeperLeagueUser;
use DanAbrey\SleeperApi\Models\SleeperRoster;
use DanAbrey\SleeperApi\Models\SleeperTradedPick;
use DanAbrey\SleeperApi\Models\SleeperUser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
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

        if ($response->getStatusCode() !== 200 || $response->getContent() === 'null') {
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
     * @param string $userId
     * @param string $season
     * @return array|SleeperLeague[]
     * @throws SleeperApiException
     */
    public function leagues(string $userId, string $season): array
    {
        $response = $this->get('/user/' . $userId . '/leagues/nfl/' . $season);

        $normalizers = [new ArrayDenormalizer(), new SleeperLeagueDenormalizer()];
        $serializer = new Serializer($normalizers);
        return $serializer->denormalize($response, SleeperLeague::class . '[]');
    }

    /**
     * @param string $identifier Username or Sleeper ID of the user
     * @return SleeperUser
     * @throws SleeperApiException
     */
    public function user(string $identifier): SleeperUser
    {
        $response = $this->get('/user/' . $identifier);

        $normalizers = [new ArrayDenormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers);
        return $serializer->denormalize($response, SleeperUser::class);
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

    /**
     * @param string $leagueId
     * @return array|SleeperDraft[]
     * @throws SleeperApiException
     */
    public function drafts(string $leagueId): array
    {
        $response = $this->get('/league/' . $leagueId . '/drafts');

        $normalizers = [new ArrayDenormalizer(), new SleeperDraftDenormalizer()];
        $serializer = new Serializer($normalizers);
        return $serializer->denormalize($response, SleeperDraft::class . '[]');
    }


    /**
     * @param string $leagueId
     * @return array|SleeperTradedPick[]
     * @throws SleeperApiException
     */
    public function tradedPicks(string $leagueId): array
    {
        $response = $this->get('/league/' . $leagueId . '/traded_picks');

        $normalizers = [new ArrayDenormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers);
        return $serializer->denormalize($response, SleeperTradedPick::class . '[]');
    }
}
