<?php
require_once __DIR__ . '/Pokemon.php';

class Raticate extends Pokemon {

    protected int $initialLevel = 20;

    public function __construct(array $data = null) {
        $baseStats = [
            'hp' => 55,
            'atk' => 81,
            'def' => 60,
            'spatk' => 50,
            'spdef' => 70,
            'speed' => 97
        ];

        parent::__construct(
            "Raticate",
            "Normal",
            0.7,
            18.5,
            "Pokémon Tikus",
            ["Run Away", "Guts"],
            "♂ / ♀",
            $baseStats,
            $this->initialLevel,
            0,
            "Medium Fast"
        );

        if ($data !== null) {
            $this->restoreFromArray($data);
        }
    }

    protected function getInitialLevel(): int {
        return $this->initialLevel;
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

    // Implementasi specialMove (Polymorphism)
    public function specialMove(): string {
        return "Hyper Fang – Gigitan kuat khas Raticate!";
    }

    public function restoreFromArray(array $data): void {
        if (isset($data['baseStats'])) $this->baseStats = $data['baseStats'];
        if (isset($data['stats'])) $this->stats = $data['stats'];
        if (isset($data['level'])) $this->level = (int)$data['level'];
        if (isset($data['exp'])) $this->exp = (int)$data['exp'];
    }

    public static function fromArray(array $data): Raticate {
        $inst = new Raticate();
        $inst->restoreFromArray($data);
        return $inst;
    }
}
