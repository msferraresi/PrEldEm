<x-app-layout>
    <div class="max-w-10xl mx-auto py-5">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="block mb-8">
                        <form method="POST" action="{{ route('news.index') }}" x-data>
                            @csrf
                            <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                            <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                            <a href="{{ route('news.index') }}"  @click.prevent="$root.submit();" class="inline-flex items-center px-4 py-2  bg-gray-200   border border-transparent rounded-md font-semibold text-xs text-black uppercase  hover:bg-gray-400 active:bg-gray-900 focus:outline-none focus:border-gray-900 disabled:opacity-25 transition">Volver</a>
                        </form>
                    </div>
                    <br>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="block mb-8">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <label for="tittle" class="block font-medium text-sm text-gray-700">Titulo</label>
                                    <input type="text" disabled name="tittle" id="tittle" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                        value="{{ old('tittle', $new[0]->tittle) }}" />
                                    @error('tittle')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <label for="description" class="block font-medium text-sm text-gray-700">Descripcion</label>
                                    <textarea name="description" id="description" disabled rows="4" cols="50" class="form-input rounded-md shadow-sm mt-1 block w-full">{{ old('description', $new[0]->description ) }}</textarea>
                                    @error('description')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
