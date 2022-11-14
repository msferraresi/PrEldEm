<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Novedades
        </h2>
    </x-slot>
    <div class="max-w-10xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="block mb-8">
                        @can('rrhh.create')
                            <form method="POST" action="{{ route('rrhh.create_news') }}" x-data>
                                @csrf
                                <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                <a href="{{ route('rrhh.index') }}" class="inline-flex items-center px-4 py-2  bg-gray-200   border border-transparent rounded-md font-semibold text-xs text-black uppercase  hover:bg-gray-400 active:bg-gray-900 focus:outline-none focus:border-gray-900 disabled:opacity-25 transition">Volver</a>
                                <a href="{{ route('rrhh.create_news') }}" @click.prevent="$root.submit();" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase  hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Agregar Novedad</a>
                            </form>
                        @endcan
                    </div>
                    <br>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                            <tr>
                                <th hidden>ID</th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Empresa: <b>{{$company[0]->name}}</b> - Novedades:
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Equipo:
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <form method="POST" action="{{ route('rrhh.index_news') }}" x-data>
                                        @csrf
                                        <input type="text" value="{{ Auth::user()->id }}"                 hidden id="id_user" name="id_user">
                                        <input type="text" value="{{ Auth::user()['current_team_id'] }}" hidden id="team_id" name="team_id">
                                        <select class="form-control m-bot15" name="area_id" onchange="this.form.submit()">
                                            <option value="0" {{ $area_selected == 0 ? 'selected' : ''}} >Todos</option>
                                            @if($areas->count() > 0)
                                                @foreach($areas as $area)
                                                    <option value="{{$area->id}}" {{ $area_selected == $area->id ? 'selected' : ''}} >{{$area->name}}</option>
                                                @endForeach
                                            @else
                                                No Record Found
                                            @endif
                                        </select>
                                    </form>
                                </th>
                                <th scope="col" width="100" class="px-6 py-3 bg-gray-50"></th>
                                <th scope="col" width="100" class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($news as $new)
                                    <tr>
                                        <td hidden>
                                            {{ $new->id }}
                                        </td>

                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $new->tittle }}
                                        </td>

                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900"></td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900"></td>

                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                            @can('rrhh.edit')
                                                <form method="POST" action="{{ route('rrhh.edit_news') }}" x-data>
                                                    @csrf
                                                    <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                                    <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                                    <input type="text" value="{{$new->id}}" hidden id="new_id" name="new_id">
                                                    <a href="{{ route('rrhh.edit_news')   }}" @click.prevent="$root.submit();" class="inline-flex items-center px-4 py-2   bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Editar</a>
                                                </form>
                                            @endcan
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                            @can('rrhh.destroy')
                                                <form class="inline-block" action="{{ route('rrhh.destroy_news') }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar?');">
                                                    <input type="hidden" name="_method" value="POST">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="text" value="{{$new->id}}" hidden id="new_id" name="new_id">
                                                    <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                                    <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                                    <input type="submit" class="inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" value="Borrar">
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
