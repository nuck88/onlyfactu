<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <!-- Contenido principal -->
            <div class=" bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <div class="p-6 text-gray-900 ">
                    <table class="w-full text-sm text-left text-gray-50 rtl:text-right dark:text-gray-400">
                        <thead class="text-xs uppercase text-gray-50 bg-gray-50 dark:bg-gray-700 dark:text-gray-50">
                            <tr class="">
                                <th scope="col" class="px-6 py-3 text-center">
                                    Categoria
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Concepto
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Importe
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Notas
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Acciones
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gastos as $gasto)
                                <tr class=" bg-white border-b dark:bg-gray-200 dark:border-gray-100 hover:bg-gray-50 ">

                                    <td class="px-6 py-4 text-gray-900 text-center font-semibold">
                                        <h2>{{ $gasto->categoria->nombre ?? 'Sin categoría' }}</h2> <!-- Nombre de la categoría -->
                                    </td>

                                    <td class="px-6 py-4 text-gray-900 text-center font-semibold">
                                        <h2>{{ $gasto->concepto->nombre ?? 'Sin concepto' }}</h2> <!-- Nombre del concepto -->
                                    </td>

                                    <td class="px-6 py-4 text-gray-900 text-center">
                                        <h2>{{ $gasto->gasto }}</h2>
                                    </td>

                                    <td class="px-6 py-4  text-gray-900 text-center">
                                        <h2>{{ $gasto->notas }}</h2>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('gasto.delete', $gasto->id) }}" method="POST"
                                            class="inline-block">
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
                </div>
            </div>
            {{-- Fin Contenido principal --}}

            <!-- Aside -->
            <aside class=" hidden md:block w-1/4 bg-gray-200 dark:bg-gray-700 p-4 ml-4 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Menu</h2>
                <!-- Formulario para filtrar por mes -->
                <form method="GET" action="{{ route('gastos') }}">
                    <label for="mes" class="text-white">Filtrar por mes:</label>
                    <select class="ml-3" name="mes" id="mes" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        @foreach (range(1, 12) as $num)
                            <option value="{{ $num }}" {{ request('mes') == $num ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($num)->locale('es')->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </form>
                {{-- Fin formulario para filtrar mes --}}
                <div class="text-center mt-10">
                    <button x-data @click.prevent="$dispatch('open-modal', 'nuevo_gasto')"
                        class="btn btn-warning w-full">Nuevo gasto</button>
                </div>
            </aside>
            {{-- fin aside --}}
        </div>
    </div>
</x-app-layout>


{{-- Modal Gastos --}}
<x-modal name="nuevo_gasto" :show="$errors->isNotEmpty()" focusable>
    <form action="{{ route('gasto.nuevo') }}" method="POST" class="p-6" enctype="multipart/form-data">
        @csrf

        <h2 class="text-xl text center font-medium text-warning">
            {{ __('Nuevo Gasto') }}
        </h2>

        <div class="mt-6">
            <label for="categoria" class="text-white">Categoría</label>
            <select id="categoria" name="categoria_id" class="block w-full mt-1 bg-gray-800 text-white p-2 rounded">
                <option value="">Seleccione una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-6">
            <label for="concepto" class="text-white">Concepto</label>
            <select id="concepto" name="concepto_id" class="block w-full mt-1 bg-gray-800 text-white p-2 rounded">
                <option value="">Seleccione un concepto</option>
            </select>
        </div>

        <div class="mt-6">
            <x-input-label for="importe" value="{{ __('importe') }}" class="sr-only" />

            <x-text-input wire:model="importe" id="importe" name="importe" type="text" class="block w-full mt-1"
                placeholder="{{ __('importe') }}" />

            <x-input-error :messages="$errors->get('importe')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-input-label for="notas" value="{{ __('notas') }}" class="sr-only" />

            <x-text-input wire:model="notas" id="notas" name="notas" type="text" class="block w-full mt-1"
                placeholder="{{ __('notas') }}" />

            <x-input-error :messages="$errors->get('notas')" class="mt-2" />
        </div>


        <div class="flex justify-end mt-6">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <button type="submit" class="ms-3">
                {{ __('Crear Gasto') }}
            </button>
        </div>
    </form>
</x-modal>
{{-- Fin modal Gastos --}}

<script>
    document.addEventListener("DOMContentLoaded", function () {
    let selectCategoria = document.getElementById("categoria");
    let selectConcepto = document.getElementById("concepto");

    selectCategoria.addEventListener("change", function () {
        let categoriaId = this.value;

        // Limpiar opciones previas
        selectConcepto.innerHTML = '<option value="">Seleccione un concepto</option>';

        if (categoriaId) {
            fetch(`/conceptos/por-categoria/${categoriaId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(concepto => {
                        let option = document.createElement("option");
                        option.value = concepto.id;
                        option.textContent = concepto.nombre;
                        selectConcepto.appendChild(option);
                    });
                })
                .catch(error => console.error("Error cargando conceptos:", error));
        }
    });
});

</script>
