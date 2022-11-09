<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Recibos
        </h2>
    </x-slot>

    <div>
        <div class="max-w-10xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                <tr>
                                    <th hidden>
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Mes
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Año
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo
                                    </th>
                                    <th scope="col" width="200" class="px-6 py-3 bg-gray-50"></th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($paychecks as $paycheck)
                                        <tr>
                                            <td hidden>
                                                {{ $paycheck->id }}
                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $paycheck->month }}
                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $paycheck->year }}
                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $paycheck->type_file_id }}
                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap text-sm font-small">
                                                <a href="#" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                                    <form method="post" action="{{ route('paychecks.show') }}">
                                                        @csrf
                                                        <input type="text" value="{{$paycheck->id}}" hidden id="id" name="id">
                                                        <input type="submit" value=" Ver "/>
                                                    </form>
                                                </a>
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
    </div>
</x-app-layout>
