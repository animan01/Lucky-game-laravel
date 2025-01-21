<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucky Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">
                Welcome, {{ $user->username }}!
            </h1>
            <span class="text-sm text-gray-500">
                    Link expires: {{ $user->link_expires_at->format('Y-m-d H:i:s') }}
                </span>
        </div>
    </div>

    <!-- Game Result -->
    @if(session('result'))
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-bold mb-4">Game Result</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-lg font-medium text-gray-500">Number</div>
                    <div
                        class="text-2xl font-bold">{{ session('result')['number'] }}</div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-lg font-medium text-gray-500">Result</div>
                    <div
                        class="text-2xl font-bold {{ session('result')['result'] === 'Win' ? 'text-green-600' : 'text-red-600' }}">
                        {{ session('result')['result'] }}
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-lg font-medium text-gray-500">Win Amount
                    </div>
                    <div class="text-2xl font-bold">
                        ${{ number_format(session('result')['winAmount'], 2) }}</div>
                </div>
            </div>
        </div>
    @endif

    <!-- Game Actions -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <form method="POST" action="{{ route('game.play', $user->id) }}">
                @csrf
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    I'm Feeling Lucky
                </button>
            </form>

            <form method="POST" action="{{ route('game.newLink', $user->id) }}">
                @csrf
                <button type="submit"
                        class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    Generate New Link
                </button>
            </form>

            <form method="POST"
                  action="{{ route('game.deactivate', $user->id) }}"
                  onsubmit="return confirm('Are you sure you want to deactivate this link?');">
                @csrf
                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    Deactivate Link
                </button>
            </form>
        </div>
    </div>

    <!-- Game History -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Last 3 Games</h2>
        @if($history->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Number
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Result
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Win Amount
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($history as $game)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $game->random_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $game->result === 'Win' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $game->result }}
                                        </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${{ number_format($game->win_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ $game->created_at->format('Y-m-d H:i:s') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No games played yet.</p>
        @endif
    </div>
</div>

@if(session('error'))
    <div
        class="fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"
        role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif
</body>
</html>
