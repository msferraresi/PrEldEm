<x-app-layout>
    <div class="max-w-10xl mx-auto py-5">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="block mb-8">
                        <ul class="flex flex-row mt-0 mr-6 space-x-8 text-sm font-medium">
                            <li>
                                <a href="{{ route('admin.index') }}" class="inline-flex items-center px-4 py-2  bg-gray-200   border border-transparent rounded-md font-semibold text-xs text-black uppercase  hover:bg-gray-400 active:bg-gray-900 focus:outline-none focus:border-gray-900 disabled:opacity-25 transition">Volver</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.index_activities') }}" x-data>
                                    @csrf
                                     <label for="log_names" class="px-6 font-medium text-gray-500 uppercase tracking-wider">Tipo Log:</label>
                                     <select class="form-control m-bot15" name="log_names" onchange="this.form.submit()">
                                        <option value="all" {{ $log_selected == 'all' ? 'selected' : ''}} >Todos</option>
                                        @foreach($log_names as $lg)
                                            <option value="{{$lg->log_name}}" {{ $log_selected == $lg->log_name ? 'selected' : ''}} >{{$lg->log_name}}</option>
                                        @endForeach
                                    </select>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <br>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                            <tr>
                                <th hidden>ID</th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Log
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Descripcion
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Evento
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Objeto Modificado
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Agente de Cambio
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Usuario
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($logs as $log)
                                    <tr>
                                        <td hidden>
                                            {{ $log->id }}
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small text-gray-900">
                                            {{ $log->log_name }}
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                            {{ $log->description }}
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                            {{ $log->event }}
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                            {{ $log->where }}
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                            {{ $log->who }}
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                            {{ $log->user_name }}
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
