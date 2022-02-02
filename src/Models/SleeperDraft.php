<?php
namespace DanAbrey\SleeperApi\Models;

final class SleeperDraft
{
    public string $type;
    public string $status;
    public int $start_time;
    public string $season;
    public string $season_type;
    public SleeperDraftSettings $settings;
    public string $league_id;
    public ?array $draft_order = null;
    public string $draft_id;
}
