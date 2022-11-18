<x-app-layout>
    @can('rrhh.create')
        <div class="max-w-10xl mx-auto py-5">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="block mb-8">
                            <form method="POST" action="{{ route('rrhh.index_files') }}" x-data>
                                @csrf
                                <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="company_id" name="company_id">
                                <input type="text" value="0" hidden id="type_file_id" name="type_file_id">
                                <a href="{{ route('rrhh.index_files') }}" @click.prevent="$root.submit();" class="inline-flex items-center px-4 py-2  bg-gray-200   border border-transparent rounded-md font-semibold text-xs text-black uppercase  hover:bg-gray-400 active:bg-gray-900 focus:outline-none focus:border-gray-900 disabled:opacity-25 transition">Volver</a>
                            </form>
                        </div>
                        <br>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form method="POST" action="{{ route('rrhh.store_file') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="block mb-8">
                                        <ul class="flex flex-row px-4 py-5 mt-0 mr-6 space-x-8 text-sm font-medium bg-white">
                                            <li>
                                                <label for="company_name" class="px-6 font-medium text-gray-500 uppercase tracking-wider">Empresa:</label>
                                                <input type="text" name="area_name" disabled id="area_name" type="text" class="form-input rounded-md shadow-sm mt-1"value="{{  $company->name  }}" />
                                            </li>

                                            <li>
                                                <label for="type_file_id" class="px-6 font-medium text-gray-500 uppercase tracking-wider">Tipo:</label>
                                                <select class="form-control m-bot15" name="type_file_id">
                                                    @foreach($type_files as $tf)
                                                        <option value="{{$tf->id}}">{{$tf->name}}</option>
                                                    @endForeach
                                                </select>
                                            </li>
                                            <li>
                                                <label for="month" class="px-6 font-medium text-gray-500 uppercase tracking-wider">mes:</label>
                                                <select class="form-control m-bot15" name="month">
                                                    @foreach(range(1,12) as $month)
                                                            <option value="{{$month}}">
                                                                    {{date("M", strtotime('2016-'.$month))}}
                                                            </option>
                                                    @endforeach
                                                </select>
                                            </li>
                                            <li>
                                                <label for="year" class="px-6 font-medium text-gray-500 uppercase tracking-wider">año:</label>
                                                <select class="form-control m-bot15" name="year">
                                                    @for ($year = date('Y'); $year > date('Y') - 100; $year--)
                                                    <option value="{{$year}}">
                                                            {{$year}}
                                                    </option>
                                                    @endfor
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="block mb-8">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <input type="file" name="urlpdf" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase  hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"/>
                                        </div>
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <label for="comments" class="block font-medium text-sm text-gray-700">Comentario</label>
                                            <textarea name="comments" id="comments"  rows="4" cols="50" class="form-input rounded-md shadow-sm mt-1 block w-full">{{ old('description', '') }}</textarea>
                                            @error('comments')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="text" name="company_id" id="company_id" value="{{Auth::user()['current_team_id']}}" hidden>
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
