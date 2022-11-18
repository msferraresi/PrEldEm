<x-app-layout>
    <div class="max-w-10xl mx-auto py-5">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    @can('rrhh.create')
                        <div class="block mb-8">
                            <ul class="flex flex-row mt-0 mr-6 space-x-8 text-sm font-medium">
                                <li>
                                    <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                    <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                    <a href="{{ route('rrhh.index') }}" class="inline-flex items-center px-4 py-2  bg-gray-200   border border-transparent rounded-md font-semibold text-xs text-black uppercase  hover:bg-gray-400 active:bg-gray-900 focus:outline-none focus:border-gray-900 disabled:opacity-25 transition">Volver</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('rrhh.create_file') }}" x-data>
                                        @csrf
                                        <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                        <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="company_id" name="company_id">
                                        <a href="{{ route('rrhh.create_file') }}" @click.prevent="$root.submit();" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase  hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">cargar archivo</a>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('rrhh.index_files') }}" x-data>
                                        @csrf
                                        <input type="text" value="{{ Auth::user()->id }}"                 hidden id="id_user" name="id_user">
                                        <input type="text" value="{{ Auth::user()['current_team_id'] }}" hidden id="company_id" name="company_id">
                                        <label for="type_file_id" class="px-6 font-medium text-gray-500 uppercase tracking-wider">Tipo:</label>
                                        <select class="form-control m-bot15" name="type_file_id" onchange="this.form.submit()">
                                            <option value="0" {{ $type_file_selected == 0 ? 'selected' : ''}} >Todos</option>
                                            @if($type_files->count() > 0)
                                                @foreach($type_files as $tf)
                                                    <option value="{{$tf->id}}" {{ $type_file_selected == $tf->id ? 'selected' : ''}} >{{$tf->name}}</option>
                                                @endForeach
                                            @else
                                                No Record Found
                                            @endif
                                        </select>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endcan
                    <br>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                            <tr>
                                <th hidden>ID</th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Empresa: <b>{{$company->name}}</b> - Mes
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    año
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">tipo</th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comentario</th>
                                <th scope="col" width="100" class="px-6 py-3 bg-gray-50"></th>
                                <th scope="col" width="100" class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($files as $file)
                                    <tr>
                                        <td hidden>{{ $file->id }}</td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                            @foreach(range(1,12) as $month)
                                                {{  $file->month == $month ? date("F", strtotime('2016-'.$month)) : ''}}
                                            @endforeach
                                         </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{ $file->year }}</td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                        @foreach($type_files as $tf)
                                             {{  $file->type_file_id == $tf->id ? $tf->name : ''}}
                                        @endForeach
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{ $file->comments }}</td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">

                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                            @can('rrhh.destroy')
                                                <form class="inline-block" action="{{ route('rrhh.destroy_file') }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar?');">
                                                    <input type="hidden" name="_method" value="POST">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="text" value="{{$file->id}}" hidden id="file_id" name="file_id">
                                                    <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                                    <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="company_id" name="company_id">
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
