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
                                    <form method="POST" action="{{ route('rrhh.index_employees') }}" x-data>
                                        @csrf
                                        <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                        <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                        <label for="area_id" class="px-6 font-medium text-gray-500 uppercase tracking-wider">Equipo:</label>
                                        <select class="form-control m-bot15" name="area_id" onchange="this.form.submit()">
                                        <option value="0" {{ $area_selected == 0 ? 'selected' : ''}} >Todos</option>
                                        @foreach($areas as $area)
                                            <option value="{{$area->id}}" {{ $area_selected == $area->id ? 'selected' : ''}} >{{$area->name}}</option>
                                        @endForeach
                                        </select>
                                        <label for="role_name" class="px-6 font-medium text-gray-500 uppercase tracking-wider">Rol:</label>
                                        <select class="form-control m-bot15" name="role_name" onchange="this.form.submit()">
                                            <option value="all" {{ $role_selected == 'all' ? 'selected' : ''}} >Todos</option>
                                            @foreach($roles as $rol)
                                                <option value="{{$rol->name}}" {{ $role_selected == $rol->name ? 'selected' : ''}} >{{$rol->name}}</option>
                                            @endForeach
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
                                    Empresa: <b>{{$company[0]->name}}</b> - Empleado:
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Equipo/s
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rol
                                </th>
                                <th scope="col" width="100" class="px-6 py-3 bg-gray-50">:</th>
                                <th scope="col" width="100" class="px-6 py-3 bg-gray-50">
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td hidden>
                                            {{ $employee->id }}
                                        </td>

                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $employee->name }}
                                        </td>

                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{$employee->teams}}</td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{$employee->role}}</td>

                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                            @can('rrhh.edit')
                                                <form method="POST" action="{{ route('rrhh.edit_employee') }}" x-data>
                                                    @csrf
                                                    <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                                    <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                                    <input type="text" value="{{$employee->id}}" hidden id="employee_id" name="employee_id">
                                                    <a href="{{ route('rrhh.edit_employee')   }}" @click.prevent="$root.submit();" class="inline-flex items-center px-4 py-2   bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Editar</a>
                                                </form>
                                            @endcan
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                            @can('rrhh.destroy')
                                                <form class="inline-block" action="{{ route('rrhh.destroy_employee') }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar?');">
                                                    <input type="hidden" name="_method" value="POST">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="text" value="{{$employee->id}}" hidden id="employee_id" name="employee_id">
                                                    <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                                    <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                                    <input type="text" value="0" hidden id="area_id" name="area_id">
                                                    <input type="text" value="all" hidden id="role_name" name="role_name">
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
