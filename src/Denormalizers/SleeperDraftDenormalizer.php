<?php

namespace DanAbrey\SleeperApi\Denormalizers;

use DanAbrey\SleeperApi\Models\SleeperDraft;
use DanAbrey\SleeperApi\Models\SleeperDraftSettings;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SleeperDraftDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $draft = new SleeperDraft();

        $leagueDenormalizer = new Serializer([new ObjectNormalizer(), new ArrayDenormalizer()]);

        $settings = $data['settings'];
        unset($data['settings']);

        $draft = $leagueDenormalizer->denormalize($data, SleeperDraft::class);

        $draft->settings = $leagueDenormalizer->denormalize($settings, SleeperDraftSettings::class);

        return $draft;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === SleeperDraft::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            SleeperDraft::class => true,
        ];
    }
}