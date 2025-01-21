<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class UserController extends Controller {

    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * Registration form.
     */
    public function showRegisterForm(): View {
        return view('register');
    }

    /**
     * Handle user registration action.
     */
    public function register(RegisterRequest $request): RedirectResponse {
        $uniqueLink = $this->userService->registerUser(
            $request->validated('username'),
            $request->validated('phone_number')
        );

        return redirect()->route('game.show', ['link' => $uniqueLink]);
    }

    /**
     * Generate a new unique link for an existing user.
     */
    public function generateNewLink(string $userId): RedirectResponse {
        $newLink = $this->userService->generateNewLink($userId);
        return redirect()->route('game.show', ['link' => $newLink]);
    }

    /**
     * Deactivate user's current link.
     */
    public function deactivateLink(string $userId): RedirectResponse {
        $this->userService->deactivateLink($userId);
        return redirect()->route('register');
    }

}
