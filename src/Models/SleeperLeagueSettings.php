<?php
namespace DanAbrey\SleeperApi\Models;

final class SleeperLeagueSettings
{
    public int $waiver_type;
    public int $waiver_day_of_week;
    public int $waiver_clear_days;
    public int $waiver_budget;
    public int $type;
    public int $trade_review_days;
    public int $trade_deadline;
    public int $taxi_years;
    public int $taxi_slots;
    public int $taxi_deadline;
    public int $taxi_allow_vets;
    public int $start_week;
    public int $reserve_slots;
    public int $reserve_allow_sus;
    public int $reserve_allow_out;
    public int $reserve_allow_doubtful;
    public int $playoff_week_start;
    public int $playoff_type;
    public int $playoff_teams;
    public int $pick_trading;
    public int $offseason_adds;
    public int $num_teams;
    public int $max_keepers;
    public int $leg;
    public int $league_average_match;
    public int $last_scored_leg;
    public int $last_report;
    public int $draft_rounds;
    public int $daily_waivers_hour;
    public int $daily_waivers;
    public int $bench_lock;
}
