<x-app-layout>
    @if(isset($errorMessage))
        <div class="antialiased">
            <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
                <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                        <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">{{ $errorCode }}</div>
                        <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">{{ $errorMessage }}</div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="max-w-10xl mx-auto py-5">
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
                                    <th hide scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                            <td  hide class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $paycheck->type_file_id }}
                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap text-sm font-small">

                                                <form method="POST" action="{{ route('paychecks.show') }}" x-data>
                                                    @csrf
                                                    <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                                    <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                                    <input type="text" value="{{$paycheck->path}}" hidden id="path" name="path">
                                                    <input type="text" value="{{$paycheck->month}}" hidden id="month" name="month">
                                                    <input type="text" value="{{$paycheck->year}}" hidden id="year" name="year">

                                                    <a href="{{ route('paychecks.show')   }}" @click.prevent="$root.submit();" class="inline-flex items-center px-4 py-2   bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Descargar</a>
                                                </form>
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
    @endif
</x-app-layout>
