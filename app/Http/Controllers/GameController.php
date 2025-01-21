<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\GameService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class GameController extends Controller {

    public function __construct(
        private readonly GameService $gameService,
        private readonly UserService $userService
    ) {}

    /**
     * Display the main game view with user info, history, and last result.
     */
    public function show(string $link): View|RedirectResponse {
        $user = $this->userService->getUserByLink($link);

        if (!$user || $this->userService->isLinkExpired($user)) {
            return redirect()->route('register')
                ->with('error', 'Invalid or expired link');
        }

        // Fetch last 3 games for the user.
        $history = $this->gameService->getHistory((string) $user->id);

        // If you stored the game result in the session, retrieve it
        // (e.g. from the play() method below).
        $result = session('result');

        return view('game', compact('user', 'history', 'result'));
    }

    /**
     * Handle the game play action.
     */
    public function play(string $userId): RedirectResponse {
        $result = $this->gameService->play($userId);

        $user = $this->userService->getUser($userId);

        return redirect()->route('game.show', ['link' => $user->unique_link])
            ->with('result', $result);
    }

}
