<x-app-layout>
    <div class="max-w-10xl mx-auto py-5">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow grid grid-cols-1 md:grid-cols-2">

                        <div class="p-6 border-t border-gray-200 md:border-l">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                    <form method="POST" action="{{ route('rrhh.index_news') }}" x-data>
                                        @csrf
                                        <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                        <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                        <input type="text" value="0" hidden id="area_id" name="area_id">
                                        <a href="{{ route('rrhh.index_news') }}" @click.prevent="$root.submit();">Gestion Novedades</a>
                                    </form>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-sm text-gray-500">
                                    Desde aqui puede gestionar las noticias y novedades que desee informar a sus equipos de trabajo.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 md:border-l">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                    <form method="POST" action="{{ route('rrhh.index_files') }}" x-data>
                                        @csrf
                                        <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                        <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="company_id" name="company_id">
                                        <input type="text" value="0" hidden id="type_file_id" name="type_file_id">
                                        <a href="{{ route('rrhh.index_files') }}" @click.prevent="$root.submit();">Gestion de Archivos</a>
                                    </form>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-sm text-gray-500">
                                    En esta seccion puede gestionar la carga de los archivos que tiene todos los recibos a liquidar de sus empleados.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 md:border-l">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                    <form method="POST" action="{{ route('rrhh.index_group') }}" x-data>
                                        @csrf
                                        <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                        <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                        <a href="{{ route('rrhh.index_group') }}" @click.prevent="$root.submit();">Gestion de Equipos</a>
                                    </form>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-sm text-gray-500">
                                    Desde aqui puede gestionar los equipos de trabajo
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 md:border-l">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                    <form method="POST" action="{{ route('rrhh.index_employees') }}" x-data>
                                        @csrf
                                        <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                        <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                        <input type="text" value="0" hidden id="area_id" name="area_id">
                                        <input type="text" value="all" hidden id="role_name" name="role_name">
                                        <a href="{{ route('rrhh.index_employees') }}" @click.prevent="$root.submit();">Gestion de Empleados</a>
                                    </form>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-sm text-gray-500">
                                    Desde aqui puede gestionar los empleados de la empresa
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
