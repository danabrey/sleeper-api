<?php

namespace DanAbrey\SleeperApi\Denormalizers;

use DanAbrey\SleeperApi\Models\SleeperLeague;
use DanAbrey\SleeperApi\Models\SleeperLeagueSettings;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SleeperLeagueDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $league = new SleeperLeague();

        $league->league_id = $data['league_id'];
        $league->previous_league_id = $data['previous_league_id'];
        $league->name = $data['name'];
        $league->roster_positions = $data['roster_positions'];

        $leagueSettingsDenormalizer = new Serializer([new ObjectNormalizer(), new ArrayDenormalizer()]);

        $league->settings = $leagueSettingsDenormalizer->denormalize($data['settings'], SleeperLeagueSettings::class);

        return $league;
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === SleeperLeague::class;
    }
}