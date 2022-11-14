
<x-app-layout>
    @can('rrhh.edit')
        <div class="max-w-10xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="block mb-8">
                            <form method="POST" action="{{ route('rrhh.index_news') }}" x-data>
                                @csrf
                                <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                <a href="{{ route('rrhh.index_news') }}"  @click.prevent="$root.submit();" class="inline-flex items-center px-4 py-2  bg-gray-200   border border-transparent rounded-md font-semibold text-xs text-black uppercase  hover:bg-gray-400 active:bg-gray-900 focus:outline-none focus:border-gray-900 disabled:opacity-25 transition">Volver</a>
                            </form>

                        </div>
                        <br>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form method="POST" action="{{ route('rrhh.update_news') }}">
                                @csrf
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="block mb-8">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <label for="tittle" class="block font-medium text-sm text-gray-700">Titulo</label>
                                            <input type="text" name="tittle" id="tittle" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                                value="{{ old('tittle', $new[0]->tittle) }}" />
                                            @error('tittle')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <label for="description" class="block font-medium text-sm text-gray-700">Descripcion</label>
                                            <textarea name="description" id="description"  rows="4" cols="50" class="form-input rounded-md shadow-sm mt-1 block w-full">{{ old('description', $new[0]->description ) }}</textarea>
                                            @error('description')
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
                                                            {{ $areas[$i]->area_id }}
                                                        </td>
                                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $areas[$i]->name }}
                                                        </td>
                                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                                            <div class="form-check">
                                                                <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 my-1 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" type="checkbox" value="{{$areas[$i]->area_id}}" id="{{'chk'.$areas[$i]->area_id}}" name="{{'chk'.$areas[$i]->area_id}}" {{$areas[$i]->assigned == 1 ? 'checked' : ''}}>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="text" name="team_id" id="team_id" value="{{Auth::user()['current_team_id']}}" hidden>
                                    <input type="text" name="id_user" id="id_user" value="{{Auth::user()->id}}" hidden>
                                    <input type="text" name="new_id" id="new_id" value="{{$new[0]->id}}" hidden>
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
        <p>FORBIDEN</p>
    @endcan
</x-app-layout>
