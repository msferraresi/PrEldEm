
<x-app-layout>
    @can('rrhh.create')
        <div class="max-w-10xl mx-auto py-5">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="block mb-8">
                            <form method="POST" action="{{ route('rrhh.index_group') }}" x-data>
                                @csrf
                                <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                <a href="{{ route('rrhh.index_group') }}"  @click.prevent="$root.submit();" class="inline-flex items-center px-4 py-2  bg-gray-200   border border-transparent rounded-md font-semibold text-xs text-black uppercase  hover:bg-gray-400 active:bg-gray-900 focus:outline-none focus:border-gray-900 disabled:opacity-25 transition">Volver</a>
                            </form>

                        </div>
                        <br>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form method="POST" action="{{ route('rrhh.store_group') }}">
                                @csrf
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="block mb-8">
                                        <div class="px-4 py-5 bg-white ">
                                            <label for="company_name" class="font-medium text-sm text-gray-700">Empresa:</label>
                                            <input type="text" name="area_name" disabled id="area_name" type="text" class="form-input rounded-md shadow-sm mt-1"
                                                value="{{  $company[0]->name  }}" />
                                            <label for="area_name" class="font-medium text-sm text-gray-700">Area:</label>
                                            <input type="text" name="area_name" id="area_name" type="text" class="form-input rounded-md shadow-sm mt-1"
                                                value="{{ old('area_name', '') }}" />
                                            @error('area_name')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="block mb-8">
                                        <table class="min-w-full divide-y divide-gray-200 w-full">
                                            <thead>
                                            <tr>
                                                <th hidden>ID</th>
                                                <th scope="col" width="100" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Usuario
                                                </th>
                                                <th scope="col" width="100" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    ¿Agreegar?
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @for ($i = 0; $i < count(collect($users)); $i++)
                                                    <tr>
                                                        <td hidden>
                                                            {{ $users[$i]->user_id }}
                                                        </td>
                                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $users[$i]->name }}
                                                        </td>
                                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                                            <div class="form-check">
                                                                <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 my-1 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" type="checkbox" value="{{$users[$i]->user_id}}" id="{{'chk'.$users[$i]->user_id}}" name="{{'chk'.$users[$i]->user_id}}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>



                                    <input type="text" name="team_id" id="team_id" value="{{Auth::user()['current_team_id']}}" hidden>
                                    <input type="text" name="id_user" id="id_user" value="{{Auth::user()->id}}" hidden>
                                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                            Crear
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
        <p>FORBIDEN</p>
    @endcan
</x-app-layout>
