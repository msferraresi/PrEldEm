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
                    @can('news.create')
                        <div class="block mb-8">
                            <a href="{{ route('rrhh.index') }}" class="inline-flex items-center px-4 py-2  bg-gray-200   border border-transparent rounded-md font-semibold text-xs text-black uppercase  hover:bg-gray-400 active:bg-gray-900 focus:outline-none focus:border-gray-900 disabled:opacity-25 transition">Volver</a>
                            <a href="{{ route('news.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase  hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Agregar noticia</a>
                        </div>
                        <br>
                    @endcan

                    <div class="block mb-8">
                        <form method="POST" action="{{ route('rrhh.index_news') }}" x-data>
                            @csrf
                            <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                            <select style="width:250px;" class="inline-flex items-center py-2  bg-gray-200   border border-transparent rounded-md font-semibold text-xs text-black uppercase  focus:outline-none focus:border-gray-900 disabled:opacity-25 transition" name="team_id">
                                <option value="0">Todos</option>
                                @if(count(collect($teams)) > 0)
                                    @foreach($teams as $team)
                                        <option value="{{$team->id}}">{{$team->name}}</option>
                                    @endForeach
                                @else
                                    No Record Found
                                @endif
                            </select>

                            <x-jet-nav-link href="{{ route('rrhh.index_news') }}"
                                     @click.prevent="$root.submit();">
                               Buscar
                            </x-jet-nav-link>
                        </form>
                    </div>
                    <br>

                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                            <tr>
                                <th hidden>
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Titulo
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Descripcion
                                </th>
                                <th scope="col" width="200" class="px-6 py-3 bg-gray-50">

                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @for ($i = 0; $i < count(collect($news)); $i++)
                                @php
                                    $n_id = $news[$i]->id;
                                @endphp
                                <tr>
                                    <td hidden>
                                        {{ $news[$i]->id }}
                                    </td>

                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $news[$i]->tittle }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $news[$i]->description }}
                                    </td>

                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                        @can('news.edit')
                                            <a href="@php echo "e(route('news.edit'," . $n_id ." ))"; @endphp" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Editar</a>
                                        @endcan
                                        @can('news.destroy')
                                            <form class="inline-block" action="@php echo "e(route('news.destroy'," . $n_id ." ))"; @endphp" method="POST" onsubmit="return confirm('¿Esta seguro que desea eliminar esta novedad?');">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" value="Borrar">
                                            </form>
                                        @endcan
                                    </td>
                                </tr>

                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
