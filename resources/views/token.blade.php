<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            API Tokens
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-success-message />
                    <x-error-message />
                    <div class="w-auto m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                        <table class="table-fixed bg-white">
                            <thead>
                                <tr>
                                    <th class="border w-fit">Token</th>
                                    <th class="border w-1/2">Created</th>
                                    <th class="border w-1/2">Used</th>
                                    <th class="border w-fit">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tokens as $token)
                                <tr>
                                    <td class="border">
                                        {{ $token->id }}
                                    </td>
                                    <td class="border">
                                        {{ $token->created_at }}
                                    </td>
                                    <td class="border">
                                        {{ $token->last_used_at ?? 'never' }}
                                    </td>
                                    <td class="border">
                                        <form action="/tokens/{{ $token->id }}" method="POST">
                                            @method('DELETE')
                                            {{ csrf_field() }}
                                            <x-button class="block m-1" type="submit">
                                                Delete
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-row flex">
                        <div class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                            <form class="flex flex-col items-center" action="/tokens/create" method="POST">
                                <h2 class="font-semibold text-l leading-tight">Create API token</h2>
                                {{ csrf_field() }}
                                <x-button class="block m-1" type=submit>Create API token</x-button>
                            </form>
                        </div>
                        <div class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                            <form class="flex flex-col items-center" action="/tokens/revokeall" method="POST">
                                <h2 class="font-semibold text-l leading-tight">Revoke all API tokens</h2>
                                {{ csrf_field() }}
                                <div class="flex flex-row">
                                    <x-input type="checkbox" class="m-1" name="confirm" required></x-input>
                                    <x-label class="block m-1 w-full" for="location" value="Revoke all API tokens">
                                    </x-label>
                                </div>
                                <x-button class="block m-1" type=submit>Revoke all API tokens</x-button>
                            </form>
                        </div>
                        <div class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                            <form class="flex flex-col items-center" action="/docs" method="GET">
                                <h2 class="font-semibold text-l leading-tight">API reference</h2>
                                {{ csrf_field() }}
                                <x-button class="block m-1" type=submit>Open docs</x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>