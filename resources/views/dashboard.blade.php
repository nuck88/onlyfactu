
{{-- Principal --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-around">
                    <div class="stats shadow">
                        <div class="stat">
                            <div class="stat-figure text-secondary">

                            </div>
                            <div class="stat-title text-success uppercase font-bold">Ingresos</div>
                            <div class="stat-value">{{$ingresos}}€</div>
                            <div class="stat-desc">Jan 1st - Feb 1st</div>
                        </div>

                        <div class="stat">
                            <div class="stat-figure text-secondary">

                            </div>
                            <div class="stat-title text-error uppercase font-bold">Gastos</div>
                            <div class="stat-value">{{$gastos}}€</div>
                            <div class="stat-desc">↗︎ 400 (22%)</div>
                        </div>

                        <div class="stat">
                            <div class="stat-figure text-secondary">
                            </div>
                            <div class="stat-title text-warning font-bold uppercase">Balance</div>
                            <div class="stat-value">{{$balance}}€</div>
                            @if ($balance < 0)
                            <div class="text-error uppercase font-bold">
                                {{ 'Balance negativo' }}
                            </div>
                            @endif
                            @if ($balance >0)
                            <div class="text-success uppercase font-bold">
                                {{ 'Balance positivo' }}
                            </div>
                            @endif
                            <div class="stat-desc">↘︎ 90 (14%)</div>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="text-center flex flex-col gap-4">
                        <button x-data @click.prevent="$dispatch('open-modal', 'nuevo_ingreso')"
                            class="btn btn-success">Nuevo Ingreso</button>

                        <button x-data @click.prevent="$dispatch('open-modal', 'nuevo_gasto')"
                            class="btn btn-error">Nuevo Gasto</button>
                    </div>
                    {{-- Fin Botones --}}
                </div>

            </div>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</x-app-layout>
{{-- Fin principal --}}

{{-- Modal ingresos --}}
<x-modal name="nuevo_ingreso" :show="$errors->isNotEmpty()" focusable>
    <form action="{{ route('ingresos.nuevo') }}" method="POST" class="p-6" enctype="multipart/form-data">
        @csrf

        <h2 class="text-xl text center font-medium text-success">
            {{ __('Nuevo Ingreso') }}
        </h2>

        <div class="mt-6">
            <select name="categoria_id" id="categoria_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-white">
                <option value="" disabled selected>Selecciona una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id}}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-6">
            <select name="concepto_id" id="concepto_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-white">
                <option value="" disabled selected>Selecciona un concepto</option>
                @foreach ($conceptos as $concepto)
                    <option value="{{ $concepto->id}}">{{ $concepto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-6">
            <x-input-label for="importe" value="{{ __('importe') }}" class="sr-only" />

            <x-text-input wire:model="importe" id="importe" name="importe" type="text" class="block w-full mt-1"
                placeholder="{{ __('importe') }}" />

            <x-input-error :messages="$errors->get('importe')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-input-label for="concepto" value="{{ __('concepto') }}" class="sr-only" />

            <x-text-input wire:model="concepto" id="concepto" name="concepto" type="text" class="block w-full mt-1"
                placeholder="{{ __('concepto') }}" />

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

{{-- modal gastos --}}
<x-modal name="nuevo_gasto" :show="$errors->isNotEmpty()" focusable>
    <form action="{{ route('concepto.nuevo') }}" method="POST" class="p-6" enctype="multipart/form-data">
        @csrf

        <h2 class="text-lg font-medium text-warning">
            {{ __('Nuevo Gasto') }}
        </h2>

        <div class="mt-6">
            <select name="categoria_id" id="categoria_id"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-white">
                <option value="" disabled selected>Selecciona una categoria</option>
            </select>

            <select name="categoria_id" id="categoria_id"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-white">
                <option value="" disabled selected>Selecciona un concepto </option>
            </select>
        </div>

        <div class="mt-6">
            <x-input-label for="notas" value="{{ __('notas') }}" class="sr-only" />

            <x-text-input wire:model="notas" id="notas" name="notas" type="text" class="block w-full mt-1"
                placeholder="{{ __('notas') }}" />

            <x-input-error :messages="$errors->get('notas')" class="mt-2" />
        </div>
        <div class="mt-6">
            <x-input-label for="importe" value="{{ __('importe') }}" class="sr-only" />

            <x-text-input wire:model="importe" id="importe" name="importe" type="text" class="block w-full mt-1"
                placeholder="{{ __('importe') }}" />

            <x-input-error :messages="$errors->get('importe')" class="mt-2" />
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
{{-- Fin modal gastos --}}


<script>
    const ingresos = @json($ingresos);

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

