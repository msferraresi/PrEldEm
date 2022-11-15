<x-app-layout>
    <div class="max-w-10xl mx-auto py-5">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6 border-t border-gray-200 md:border-l">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                    <form method="POST" action="{{ route('admin.index_activities') }}" x-data>
                                        @csrf
                                        <input type="text" value="{{Auth::user()->id}}" hidden id="id_user" name="id_user">
                                        <input type="text" value="{{Auth::user()['current_team_id']}}" hidden id="team_id" name="team_id">
                                        <input type="text" value="all" hidden id="log_names" name="log_names">
                                        <a href="{{ route('admin.index_activities') }}" @click.prevent="$root.submit();">Monitor de Actividades</a>
                                    </form>
                                </div>
                            </div>
                            <div class="ml-12">
                                <div class="mt-2 text-sm text-gray-500">
                                    Desde aqui puede monitorear las actividades realizadas
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
