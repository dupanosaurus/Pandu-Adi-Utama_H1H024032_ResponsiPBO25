<?php
require_once __DIR__ . '/Pokemon.php';
require_once __DIR__ . '/Raticate.php';

class Training {

    protected int $baseExp = 50;

    protected array $expMultiplier = [
        'Attack' => 1.2,
        'Defense' => 0.8,
        'Speed' => 1.5
    ];

    protected array $statMultiplier = [
        'Attack' => ['atk' => 2, 'hp' => 1],
        'Defense' => ['def' => 2, 'hp' => 2],
        'Speed' => ['speed' => 3, 'hp' => 0]
    ];

    public function calculate(Pokemon $pokemon, string $type, int $intensity): array {
        $type = ucfirst(strtolower($type));
        if (!in_array($type, ['Attack','Defense','Speed'])) {
            $type = 'Attack';
        }
        if ($intensity < 1) $intensity = 1;
        if ($intensity > 10) $intensity = 10;

        $mult = $this->expMultiplier[$type] ?? 1.0;
        $expGain = (int) floor($this->baseExp * $intensity * $mult);

        $gains = [];
        $mults = $this->statMultiplier[$type] ?? [];

        foreach ($mults as $statKey => $m) {
            $gains[$statKey] = (int) floor($intensity * $m);
        }

        if ($pokemon->getName() === 'Raticate') {
            if ($type === 'Speed' && isset($gains['speed'])) {
                $gains['speed'] += (int) floor($intensity / 5);
            }
            if ($type === 'Attack' && isset($gains['atk'])) {
                $gains['atk'] += (int) floor($intensity / 6);
            }
        }

        if (!isset($gains['hp'])) $gains['hp'] = 0;

        $gains['hp'] = max(0, (int)$gains['hp']);

        return [
            'exp' => $expGain,
            'stat_gains' => $gains,
            'type' => $type,
            'intensity' => $intensity
        ];
    }
}
