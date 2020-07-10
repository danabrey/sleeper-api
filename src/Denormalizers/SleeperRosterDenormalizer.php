<?php

namespace DanAbrey\SleeperApi\Denormalizers;

use DanAbrey\SleeperApi\Models\SleeperLeague;
use DanAbrey\SleeperApi\Models\SleeperLeagueSettings;
use DanAbrey\SleeperApi\Models\SleeperRoster;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SleeperRosterDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $roster = new SleeperRoster();

        $roster->roster_id = $data['roster_id'];
        $roster->owner_id = $data['owner_id'];
        $roster->players = $data['players'] ?? [];

        return $roster;
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === SleeperRoster::class;
    }
}