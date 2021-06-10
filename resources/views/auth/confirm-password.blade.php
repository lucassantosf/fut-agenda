<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{route('login')}}" class="df-ali-jusc">
                <img class="w-25" src="{{asset('assets/ico.png')}}" />
            </a>          
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Por favor, confirme a sua senha antes de continuar.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex justify-end mt-4">
                <x-button>
                    {{ __('Confirmar') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
