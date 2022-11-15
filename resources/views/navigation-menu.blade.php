<div class="max-w-10xl mx-auto py-2 sm:px-6 lg:px-8">
<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl px-4 md:px-6 py-2.5">
         <!-- Logo -->
        <div class="shrink-0 flex items-center">
            <x-jet-application-mark class="block h-9 w-auto" />
        </div>

         <!-- Account -->
        <div class="flex items-center">
            <!-- Settings Dropdown -->
            <div class="ml-3 relative">
                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                        @else
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                    {{ Auth::user()->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        @endif
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Administrar cuenta') }}
                        </div>

                        <x-jet-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Perfil') }}
                        </x-jet-dropdown-link>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-jet-dropdown-link>
                        @endif


                        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && Auth::user()->isMemberOfATeam())
                        <div class="border-t border-gray-100"></div>
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Equipos') }}
                        </div>

                        <!-- Team Settings -->
                        <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                            {{ __('Ajustes de Equipo') }}
                        </x-jet-dropdown-link>


                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            @unlessrole('COLABORADOR')
                                <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Crear nuevo Equipo') }}
                                </x-jet-dropdown-link>
                            @endunlessrole
                        @endcan

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Seleccionar Equipo') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-jet-switchable-team :team="$team" />
                        @endforeach
                        @endif

                        <div class="border-t border-gray-100"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf

                            <x-jet-dropdown-link href="{{ route('logout') }}"
                                     @click.prevent="$root.submit();">
                                {{ __('Cerrar sesion') }}
                            </x-jet-dropdown-link>
                        </form>
                    </x-slot>
                </x-jet-dropdown>
            </div>
        </div>
    </div>
</nav>
 <!-- Navigation Menu -->
<nav class="bg-gray-50 dark:bg-gray-700">
    <div class="py-3 px-4 mx-auto max-w-screen-xl md:px-6">
        <div class="flex items-center">
            <ul class="flex flex-row mt-0 mr-6 space-x-8 text-sm font-medium">
                <li>
                    @can('news.index')
                        <form method="POST" action="{{ route('news.index') }}" x-data>
                            @csrf
                            <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                            <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                            <a href="{{ route('news.index') }}" @click.prevent="$root.submit();" class="text-gray-900 dark:text-white hover:underline">Novedades</a>
                        </form>
                    @endcan
                </li>
                <li>
                    @can('paychecks.index')
                        <form method="POST" action="{{ route('paychecks.index') }}" x-data>
                            @csrf
                            <input type="text" value="{{Auth::user()->id}}" hidden id="id" name="id">
                            <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                            <a href="{{ route('paychecks.index') }}" @click.prevent="$root.submit();" class="text-gray-900 dark:text-white hover:underline">Recibos</a>
                        </form>
                    @endcan
                </li>
                <li>
                    @can('rrhh.index')
                        <a href="{{ route('rrhh.index') }}" class="text-gray-900 dark:text-white hover:underline">RRHH</a>
                    @endcan
                </li>
                <li>
                    @can('administration.index')
                        <a href="{{ route('admin.index') }}" class="text-gray-900 dark:text-white hover:underline">Administracion</a>
                    @endcan
                </li>
            </ul>
        </div>
    </div>
</nav>
</div>
