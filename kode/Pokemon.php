<?php

//Abstract class untuk mewakili seluruh Pokémon.
abstract class Pokemon {


    // Properti dasar (Enkapsulasi)
    protected string $name;
    protected string $type;
    protected float $height;
    protected float $weight;
    protected string $category;
    protected array $abilities;
    protected string $gender;

    // Statistik base (constanta) dan current (yang berubah saat latihan)
    protected array $baseStats;
    protected array $stats;

    // Level & EXP (Medium Fast growth)
    protected int $level;
    protected int $exp;
    protected string $growthRate;

    // Konstruktor
    public function __construct(
        string $name,
        string $type,
        float $height,
        float $weight,
        string $category,
        array $abilities,
        string $gender,
        array $baseStats,
        int $level = 1,
        int $exp = 0,
        string $growthRate = "Medium Fast"
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->height = $height;
        $this->weight = $weight;
        $this->category = $category;
        $this->abilities = $abilities;
        $this->gender = $gender;

        $this->baseStats = $baseStats;
        $this->stats = $baseStats;

        $this->level = $level;
        $this->exp = $exp;
        $this->growthRate = $growthRate;
    }

    // Getter
    public function getName(): string { return $this->name; }
    public function getType(): string { return $this->type; }
    public function getHeight(): float { return $this->height; }
    public function getWeight(): float { return $this->weight; }
    public function getCategory(): string { return $this->category; }
    public function getAbilities(): array { return $this->abilities; }
    public function getGender(): string { return $this->gender; }
    public function getBaseStats(): array { return $this->baseStats; }
    public function getStats(): array { return $this->stats; }
    public function getLevel(): int { return $this->level; }
    public function getExp(): int { return $this->exp; }
    public function getGrowthRate(): string { return $this->growthRate; }

    // EXP/Level logic
    public function expForLevel(int $lvl): int {
        if ($lvl < 1) $lvl = 1;
        if ($lvl > 100) $lvl = 100;
        $val = (int) floor(0.8 * ($lvl ** 3));
        return $val;
    }

    public function addExp(int $amount): array {
        $beforeExp = $this->exp;
        $beforeLevel = $this->level;

        if ($this->level >= 100) {
            return [
                'levels_gained' => 0,
                'exp_before' => $beforeExp,
                'exp_after' => $this->exp,
                'stat_changes' => []
            ];
        }

        $this->exp += max(0, $amount);

        $levelsGained = 0;
        $statChangesTotal = [];

        // cek apakah cukup untuk naik level
        while ($this->level < 100) {
            $required = $this->expForLevel($this->level + 1);
            if ($this->exp >= $required) {
                $this->levelUp();
                $levelsGained++;
            } else {
                break;
            }
        }

        return [
            'levels_gained' => $levelsGained,
            'exp_before' => $beforeExp,
            'exp_after' => $this->exp,
            'stat_changes' => []
        ];
    }

    protected function levelUp(): void {
        if ($this->level >= 100) return;
        $this->level += 1;

        $delta = $this->getPerLevelStatIncrease();

        foreach ($delta as $k => $v) {
            if (isset($this->stats[$k])) {
                $this->stats[$k] += (int)$v;
            }
        }
    }

    protected function getPerLevelStatIncrease(): array {
        return [
            'hp' => 2,
            'atk' => 3,
            'def' => 2,
            'spatk' => 1,
            'spdef' => 2,
            'speed' => 3
        ];
    }

    public function applyTrainingResult(array $result): array {
        $before = [
            'level' => $this->level,
            'exp' => $this->exp,
            'stats' => $this->stats
        ];

        $expGain = $result['exp'] ?? 0;
        $this->addExp((int)$expGain);

        $statGains = $result['stat_gains'] ?? [];
        foreach ($statGains as $k => $v) {
            if (isset($this->stats[$k])) {
                $this->stats[$k] += (int)$v;
            }
        }

        $after = [
            'level' => $this->level,
            'exp' => $this->exp,
            'stats' => $this->stats
        ];

        return [
            'before' => $before,
            'after' => $after,
            'applied' => $result
        ];
    }

    public function resetToBase(): void {
        $this->stats = $this->baseStats;
        $this->level = $this->getInitialLevel();
        $this->exp = 0;
    }

    protected function getInitialLevel(): int {
        return 1;
    }

    abstract public function specialMove(): string;

    public function toArray(): array {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'height' => $this->height,
            'weight' => $this->weight,
            'category' => $this->category,
            'abilities' => $this->abilities,
            'gender' => $this->gender,
            'baseStats' => $this->baseStats,
            'stats' => $this->stats,
            'level' => $this->level,
            'exp' => $this->exp,
            'growthRate' => $this->growthRate
        ];
    }

    public static function fromArray(array $data) {
        return null;
    }
}
