<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <!-- Contenido principal -->
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="" class="w-full text-sm text-left text-gray-50 rtl:text-right dark:text-gray-400">
                        <thead class="text-xs uppercase text-gray-50 bg-gray-50 dark:bg-gray-700 dark:text-gray-50">
                            <tr>

                                <th scope="col" class="px-6 py-3 text-center">
                                    Producto
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Supermercado
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Precio
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($precios as $precio)
                                <tr class="bg-white border-b dark:bg-gray-200 dark:border-gray-100 hover:bg-gray-50 ">

                                    <td class="px-6 py-4 font-semibold text-gray-900 text-center capitalize">
                                        <h2>{{ $precio->producto->nombre ?? 'Sin categoría' }}</h2>
                                    </td>

                                    <td class="px-6 py-4 text-gray-900 text-center capitalize">
                                        <h2>{{ $precio->supermercado->nombre ?? 'Sin Productos' }}</h2>
                                    </td>

                                    <td class="px-6 py-4 text-gray-900 text-center capitalize">
                                        <h2>{{ $precio->precio }}€</h2>
                                    </td>

                                    <td class="px-6 py-4 flex justify-center gap-2">
                                        <form action="" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 font-bold text-white p-2 rounded-2xl">Eliminar</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $precios->links() }}

                </div>
            </div>

            <!-- Aside -->
            <aside class=" hidden md:block w-1/4 bg-gray-200 dark:bg-gray-700 p-4 ml-4 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Menu</h2>
                <p class="text-gray-700 text-sm dark:text-gray-300 mt-2">
                    En esta sección puedes añadir productos, supermercados y comparativas para poder comparar los
                    precios
                    de los productos en los diferentes supermercados.
                <div class="text-center">
                    <input class=" my-4 text-gray-900 w-full " type="text" id="buscador" placeholder="Buscar..."
                        class="p-2 mb-4 w-full border rounded-md">

                    <button x-data @click.prevent="$dispatch('open-modal', 'nueva_comparacion')"
                        class="btn btn-active btn-info btn-neutral mb-4 w-full text-xl">
                        Añadir comparativa
                    </button>
                    <button x-data @click.prevent="$dispatch('open-modal', 'nuevo_supermercado')"
                        class="btn btn-active btn-neutral mb-4 w-full btn-success text-xl">
                        Añadir supermercado
                    </button>

                    <button x-data @click.prevent="$dispatch('open-modal', 'nuevo_producto')"
                        class="btn btn-active btn-neutral w-full btn-success text-xl">
                        Añadir producto
                    </button>
                </div>


            </aside>

        </div>
    </div>
</x-app-layout>

<x-modal name="nuevo_supermercado" :show="$errors->isNotEmpty()" focusable>
    <form action="{{ route('supermercado.nuevo') }}" method="POST" class="p-6" enctype="multipart/form-data">
        @csrf
        <h2 class="text-lg font-medium text-white">
            {{ __('Nuevo Supermercado') }}
        </h2>

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
                {{ __('Crear Supermercado') }}
            </button>
        </div>
    </form>
</x-modal>

<x-modal name="nuevo_producto" :show="$errors->isNotEmpty()" focusable>
    <form action="{{ route('producto.nuevo') }}" method="POST" class="p-6" enctype="multipart/form-data">
        @csrf

        <h2 class="text-lg font-medium text-white">
            {{ __('Nuevo Producto') }}
        </h2>


        <div class="mt-6">
            <x-input-label for="nombre" value="{{ __('nombre') }}" class="sr-only" />

            <x-text-input wire:model="nombre" id="nombre" name="nombre" type="text" class="block w-full mt-1"
                placeholder="{{ __('Nombre') }}" />

            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>


        <div class="mt-6">
            <x-input-label for="cantidad" value="{{ __('cantidad') }}" class="sr-only" />

            <x-text-input wire:model="cantidad" id="cantidad" name="cantidad" type="text" class="block w-full mt-1"
                placeholder="{{ __('Cantidad/Gramos') }}" />

            <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <button type="submit" class="ms-3">
                {{ __('Crear Producto') }}
            </button>
        </div>
    </form>
</x-modal>

<x-modal name="nueva_comparacion" :show="$errors->isNotEmpty()" focusable>
    <form action="{{ route('comparacion.nuevo') }}" method="POST" class="p-6" enctype="multipart/form-data">
        @csrf

        <h2 class="text-lg font-medium text-white">
            {{ __('Nueva comparacion') }}
        </h2>

        <div class="mt-6">
            <label for="supermercado" class="text-white">Supermercado</label>
            <select id="supermercado" name="supermercado_id"
                class="block w-full mt-1 bg-gray-800 text-white p-2 rounded">
                <option value="">Seleccione un supermercado</option>
                @foreach ($supermercados as $supermercado)
                    <option value="{{ $supermercado->id }}">{{ $supermercado->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-6">
            <label for="producto" class="text-white">Productos</label>
            <select id="producto" name="producto_id" class="block w-full mt-1 bg-gray-800 text-white p-2 rounded">
                <option value="">Seleccione un producto</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }} {{ $producto->cantidad }}</option>
                @endforeach
            </select>
        </div>


        <div class="mt-6">
            <x-input-label for="precio" value="{{ __('precio') }}" class="sr-only" />

            <x-text-input wire:model="precio" id="precio" name="precio" type="text"
                class="block w-full mt-1" placeholder="{{ __('Precio') }}" />

            <x-input-error :messages="$errors->get('precio')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <button type="submit" class="ms-3">
                {{ __('Crear Comparacion ') }}
            </button>
        </div>
    </form>
</x-modal>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputBuscador = document.getElementById("buscador");
        const filas = document.querySelectorAll("tbody tr");

        inputBuscador.addEventListener("input", function() {
            const texto = inputBuscador.value.toLowerCase();

            filas.forEach(fila => {
                const producto = fila.querySelector("td:nth-child(1) h2").textContent
                    .toLowerCase();
                const supermercado = fila.querySelector("td:nth-child(2) h2").textContent
                    .toLowerCase();
                const precio = fila.querySelector("td:nth-child(3) h2").textContent
                .toLowerCase();

                if (producto.includes(texto) || supermercado.includes(texto) || precio.includes(
                        texto)) {
                    fila.style.display = "";
                } else {
                    fila.style.display = "none";
                }
            });
        });
    });
</script>
