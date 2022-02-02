<?php
namespace DanAbrey\SleeperApi\Models;

final class SleeperDraftSettings
{
    public int $teams;
    public int $slots_wr;
    public int $slots_te;
    public int $slots_super_flex;
    public int $slots_rb;
    public int $slots_qb;
    public int $slots_flex;
    public int $slots_bn;
    public int $rounds;
    public int $reversal_round;
    public int $player_type;
    public int $pick_timer;
    public int $nomination_timer;
    public int $enforce_position_limits;
    public int $cpu_autopick;
    public int $alpha_sort;
}
