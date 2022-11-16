<x-app-layout>
    @can('rrhh.edit')
        <div class="max-w-10xl mx-auto py-5">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="block mb-8">
                            <form method="POST" action="{{ route('rrhh.index_employees') }}" x-data>
                                @csrf
                                <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                <input type="text" value="0" hidden id="area_id" name="area_id">
                                <input type="text" value="all" hidden id="role_name" name="role_name">
                                <a href="{{ route('rrhh.index_employees') }}"  @click.prevent="$root.submit();" class="inline-flex items-center px-4 py-2  bg-gray-200   border border-transparent rounded-md font-semibold text-xs text-black uppercase  hover:bg-gray-400 active:bg-gray-900 focus:outline-none focus:border-gray-900 disabled:opacity-25 transition">Volver</a>
                            </form>

                        </div>
                        <br>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form method="POST" action="{{ route('rrhh.update_employee') }}">
                                @csrf
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="block mb-8">
                                        <div class="px-4 py-5 bg-white ">
                                            <label for="user_name" class="px-6 font-medium text-gray-500 uppercase tracking-wider">Nombre:</label>
                                            <input type="text" maxlength="45" name="user_name" id="user_name" type="text" class="form-input rounded-md shadow-sm mt-1"
                                                value="{{ old('user_name', $user[0]->name ) }}" required/>
                                            @error('user_name')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                            <label for="user_identification" class="px-6 font-medium text-gray-500 uppercase tracking-wider">Identificacion:</label>
                                            <input type="text" maxlength="20" name="user_identification" id="user_identification" type="text" class="form-input rounded-md shadow-sm mt-1"
                                                value="{{ old('user_identification', $user[0]->identification ) }}" required/>
                                            @error('user_identification')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="block mb-8">
                                        <div class="px-4 py-5 bg-white ">
                                            <label class="px-6 font-medium text-gray-500 uppercase tracking-wider">Roles</label>
                                            @for ($i = 0; $i < count(collect($roles)); $i++)
                                                <div class="form-group px-6">
                                                    <input type="radio" value="{{ $roles[$i]->id }}" checked id="role" name="role">
                                                    <label for="role" class="px-6 font-medium text-gray-500 uppercase tracking-wider" {{ $roles[$i]->assigned = 1 ? 'checked' : '' }}>{{ $roles[$i]->name }}</label>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="block mb-8">
                                        <table class="min-w-full divide-y divide-gray-200 w-full">
                                            <thead>
                                            <tr>
                                                <th hidden>ID</th>
                                                <th scope="col" width="100" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Equipo
                                                </th>
                                                <th scope="col" width="100" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    ¿Agreegar?
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @for ($i = 0; $i < count(collect($areas)); $i++)
                                                    <tr>
                                                        <td hidden>
                                                            {{ $areas[$i]->id }}
                                                        </td>
                                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $areas[$i]->name }}
                                                        </td>
                                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                                            <div class="form-check">
                                                                <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 my-1 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" type="checkbox" value="{{$areas[$i]->id}}" id="{{'chk'.$areas[$i]->id}}" name="{{'chk'.$areas[$i]->id}}" {{$areas[$i]->assigned == 1 ? 'checked' : ''}}>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="text" name="team_id" id="team_id" value="{{Auth::user()['current_team_id']}}" hidden>
                                    <input type="text" name="id_user" id="id_user" value="{{Auth::user()->id}}" hidden>
                                    <input type="text" name="employee_id" id="employee_id" value="{{$user[0]->id}}" hidden>
                                    <input type="text" name="area_id" id="area_id" value="0" hidden>
                                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                            MODIFICAR
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="antialiased">
            <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
                <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                        <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">403</div>
                        <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">Esta acción no está autorizada.</div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</x-app-layout>
