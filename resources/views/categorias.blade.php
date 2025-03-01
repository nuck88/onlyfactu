<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <!-- Contenido principal -->
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full text-sm text-left text-gray-50 rtl:text-right dark:text-gray-400">
                        <thead class="text-xs uppercase text-gray-50 bg-gray-50 dark:bg-gray-700 dark:text-gray-50">
                            <tr>

                                <th scope="col" class="px-6 py-3">
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Descripción
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias as $categoria)
                            <tr class="bg-white border-b dark:bg-gray-200 dark:border-gray-100 hover:bg-gray-50 ">

                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    <h2>{{ $categoria->nombre }}</h2>
                                </td>
                                <td class="px-6 py-4 text-gray-900">
                                    <div class="flex items-center">
                                        <h2>{{ $categoria->descripcion }}</h2>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <td class="px-6 py-4">
                                        <form action="{{ route('categorias.delete', $categoria->id) }}" method="POST"  class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 font-bold text-white p-2 rounded-2xl">Eliminar</button>
                                        </form>
                                    </td>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categorias->links() }}
                </div>
            </div>

            <!-- Aside -->
            <aside class=" hidden md:block w-1/4 bg-gray-200 dark:bg-gray-700 p-4 ml-4 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Información adicional</h2>
                <p class="text-gray-700 dark:text-gray-300 mt-2">
                    Aquí puedes colocar enlaces, datos adicionales o cualquier contenido complementario.

                </p>
                <button x-data @click.prevent="$dispatch('open-modal', 'nueva_categoria')" class="btn btn-active btn-neutral">
                    Nueva categoría
                </button>
            </aside>

        </div>
    </div>

</x-app-layout>

<x-modal name="nueva_categoria" :show="$errors->isNotEmpty()" focusable>
    <form action="{{ route('categorias.nuevo') }}" method="POST" class="p-6" enctype="multipart/form-data">
        @csrf

        <h2 class="text-lg font-medium text-white">
            {{ __('Nueva Categoria') }}
        </h2>


        <div class="mt-6">
            <x-input-label for="nombre" value="{{ __('nombre') }}" class="sr-only" />

            <x-text-input wire:model="nombre" id="nombre" name="nombre" type="text" class="block w-full mt-1"
                placeholder="{{ __('Nombre') }}" />

            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-input-label for="descripcion" value="{{ __('descripcion') }}" class="sr-only" />

            <x-text-input wire:model="descripcion" id="descripcion" name="descripcion" type="text"
                class="block w-full mt-1" placeholder="{{ __('Descripcion') }}" />

            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
        </div>


        <div class="flex justify-end mt-6">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <button type="submit" class="ms-3">
                {{ __('Crear Categoria') }}
            </button>
        </div>
    </form>
</x-modal>


