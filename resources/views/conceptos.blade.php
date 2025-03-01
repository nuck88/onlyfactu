<x-app-layout>
    @vite(['resources/js/app.js'])
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <!-- Contenido principal -->
            <div class=" bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 ">
                    <form method="GET" action="{{ route('conceptos') }}">
                        <input type="text" name="query" value="{{ request('query') }}" placeholder="Buscar concepto...">
                        <button type="submit" class="text-white">Buscar</button>
                    </form>
                    <table id="" class="w-full text-sm text-left text-gray-50 rtl:text-right dark:text-gray-400">
                        <thead class="text-xs uppercase text-gray-50 bg-gray-50 dark:bg-gray-700 dark:text-gray-50">
                            <tr>

                                <th scope="col" class="px-6 py-3 text-center">
                                    Nombre concepto
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Categoria
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($concepto as $concept)
                            <tr class="bg-white border-b dark:bg-gray-200 dark:border-gray-100 hover:bg-gray-50 ">

                                <td class="px-6 py-4 font-semibold text-gray-900 text-center capitalize">
                                    <h2>{{ $concept->nombre }}</h2>
                                </td>
                                <td class="px-6 py-4 text-gray-900 text-center capitalize">
                                        <h2>{{ $concept->categoria->nombre ?? 'Sin categoría' }}</h2>
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-2">
                                        <form action="{{ route('concepto.delete', $concept->id) }}" method="POST"  class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 font-bold text-white p-2 rounded-2xl">Eliminar</button>
                                        </form>

                                        <form action="">
                                            <button type="submit" class="bg-green-600 font-bold text-white p-2 rounded-2xl">Añadir Gasto</button>
                                        </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $concepto->links() }}

                </div>
            </div>

            <!-- Aside -->
            <aside class="hidden md:block w-1/4 bg-gray-200 dark:bg-gray-700 p-4 ml-4 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Menu</h2>
                <p class="text-gray-700 dark:text-gray-300 mt-2">
                    Aquí puedes colocar enlaces, datos adicionales o cualquier contenido complementario.

                </p>
                <div class="text-center">
                    <button x-data @click.prevent="$dispatch('open-modal', 'nuevo_concepto')" class="btn btn-success">Nuevo Concepto</button>

                </div>
            </aside>


        </div>
    </div>

</x-app-layout>

<x-modal name="nuevo_concepto" :show="$errors->isNotEmpty()" focusable>
    <form action="{{ route('concepto.nuevo') }}" method="POST" class="p-6" enctype="multipart/form-data">
        @csrf

        <h2 class="text-lg font-medium text-white">
            {{ __('Nuevo concepto ') }}
        </h2>

        <div class="mt-6">
x
        </div>

        <div class="mt-6">
            <x-input-label for="nombre" value="{{ __('nombre') }}" class="sr-only" />

            <x-text-input wire:model="nombre" id="nombre" name="nombre" type="text" class="block w-full mt-1"
                placeholder="{{ __('Nombre') }}" />

            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <button type="submit" class="ms-3">
                {{ __('Crear Concepto') }}
            </button>
        </div>
    </form>
</x-modal>

