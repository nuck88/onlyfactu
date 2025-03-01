    <x-app-layout>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 flex">
                <!-- Contenido principal -->
                <div class=" bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg flex-1">
                    <div class="p-6 text-gray-900 ">

                        <table class="w-full text-sm text-left text-gray-50 rtl:text-right dark:text-gray-400">
                            <thead class="text-xs uppercase text-gray-50 bg-gray-50 dark:bg-gray-700 dark:text-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Concepto
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Importe
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ingresos as $ingreso)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-200 dark:border-gray-100 hover:bg-gray-50 ">

                                        <td class="px-6 py-4 font-semibold text-gray-900 text-center capitalize">
                                            <h2>{{ $ingreso->concepto }}</h2>
                                        </td>
                                        <td class="px-6 py-4 text-gray-900 text-center capitalize">
                                            <h2>{{ $ingreso->importe }}</h2>
                                        </td>
                                        <td class="px-6 py-4 flex justify-center gap-2">
                                            <form action="{{ route('ingresos.delete', $ingreso->id) }}" method="POST"
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
                        {{ $ingresos->links() }}

                    </div>
                </div>



                <!-- Aside -->
                <aside class="hidden md:block w-1/4 bg-gray-200 dark:bg-gray-700 p-4 ml-4 rounded-lg shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Menu</h2>
                    <!-- Formulario para filtrar por mes -->
                    <form method="GET" action="{{ route('ingresos') }}">
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

                    <div class="text-center mt-10">
                        <button x-data @click.prevent="$dispatch('open-modal', 'nuevo_ingreso')"
                            class="btn btn-success w-full">Nuevo Ingreso</button>
                    </div>
                </aside>
                {{-- Fin aside --}}
            </div>
        </div>

        <div class=" mx-auto sm:px-6 lg:px-8 flex">
            <div class="bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg flex-1">
                <h2>ingresos</h2>

                <div class="max-h-screen">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>

    </x-app-layout>




    {{-- Modal ingresos --}}
    <x-modal name="nuevo_ingreso" :show="$errors->isNotEmpty()" focusable>
        <form action="{{ route('ingresos.nuevo') }}" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf

            <h2 class="text-xl text center font-medium text-success">
                {{ __('Nuevo Ingreso') }}
            </h2>

            <div class="mt-6">
                <select name="categoria_id" id="categoria_id"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-white">
                    <option value="" disabled selected>Selecciona una categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6">
                <select name="concepto_id" id="concepto_id"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-white">
                    <option value="" disabled selected>Selecciona un concepto</option>
                    @foreach ($conceptos as $concepto)
                        <option value="{{ $concepto->id }}">{{ $concepto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6">
                <x-input-label for="importe" value="{{ __('importe') }}" class="sr-only" />

                <x-text-input wire:model="importe" id="importe" name="importe" type="text"
                    class="block w-full mt-1" placeholder="{{ __('importe') }}" />

                <x-input-error :messages="$errors->get('importe')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="concepto" value="{{ __('concepto') }}" class="sr-only" />

                <x-text-input wire:model="concepto" id="concepto" name="concepto" type="text"
                    class="block w-full mt-1" placeholder="{{ __('concepto') }}" />

                <x-input-error :messages="$errors->get('concepto')" class="mt-2" />
            </div>


            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <button type="submit" class="ms-3">
                    {{ __('Crear Ingreso') }}
                </button>
            </div>
        </form>
    </x-modal>
    {{-- Fin modal ingresos --}}

    <script>
        const ingresos = @json($ingresos->pluck('importe'));
        const conceptos = @json($ingresos->pluck('concepto'));

        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'Ingresos',
                    data: ingresos,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
