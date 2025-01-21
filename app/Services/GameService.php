<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Game;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class GameService
{
    private const MIN_NUMBER = 1;
    private const MAX_NUMBER = 1000;
    private const HISTORY_LIMIT = 3;

    /**
     * Play game for a user.
     *
     * @throws InvalidArgumentException
     */
    public function play(string $userId): array
    {
        $number = $this->generateRandomNumber();
        $result = $this->determineResult($number);
        $winAmount = $this->calculateWinAmount($number, $result);

        $game = Game::create([
            'user_id' => $userId,
            'random_number' => $number,
            'result' => $result,
            'win_amount' => $winAmount,
        ]);

        return [
            'number' => $game->random_number,
            'result' => $game->result,
            'winAmount' => $game->win_amount,
        ];
    }

    /**
     * Get user's game history.
     */
    public function getHistory(string $userId): Collection
    {
        return Game::where('user_id', $userId)
            ->latest()
            ->take(self::HISTORY_LIMIT)
            ->get();
    }

    /**
     * Generate a random number between MIN_NUMBER and MAX_NUMBER.
     */
    private function generateRandomNumber(): int
    {
        return random_int(self::MIN_NUMBER, self::MAX_NUMBER);
    }

    /**
     * Determine if the number results in a win or lose.
     */
    private function determineResult(int $number): string
    {
        return $number % 2 === 0 ? 'Win' : 'Lose';
    }

    /**
     * Calculate win amount based on number and result.
     */
    private function calculateWinAmount(int $number, string $result): float
    {
        if ($result === 'Lose') {
            return 0;
        }

        return match (true) {
            $number > 900 => $number * 0.7,
            $number > 600 => $number * 0.5,
            $number > 300 => $number * 0.3,
            default => $number * 0.1,
        };
    }
}
