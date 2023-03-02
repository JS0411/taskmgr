<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $datos['carrera'] }} - PROMEDIO: {{ $datos['promedio'] }}
        </h2>
        <p class="mt-2 text-gray-600">{{ $datos['sede'] }}</p>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-between">
            <div class="w-full md:w-1/2 px-4 mb-8 md:mb-0">
                <h3 class="text-lg font-semibold mb-4">Progreso de Carrera</h3>
                <div>
                    <h4 class="text-gray-600 font-semibold mb-2 bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">Materias Aprobadas ({{ $datos['materias_aprobadas']->count() }})</h4>
                    @foreach ($datos['materias_aprobadas'] as $clase)
                        <div class="flex justify-between mb-2">
                            <div class="p-4">
                                <p class="font-semibold">{{ $clase->nombre }}, Docente: {{ $clase->docente_id }}</p>
                                <p class="text-gray-600">Puntuacion: {{ $clase->pivot->puntuacion }}</p>
                            </div>
                        </div>
                        <hr class="my-2">
                    @endforeach
                </div>
                <div class="mt-4">
                    <h4 class="text-gray-600 font-semibold mb-2 bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">Materias Reprobadas ({{ $datos['materias_reprobadas']->count() }})</h4>
                    @foreach ($datos['materias_reprobadas'] as $clase)
                        <div class="flex justify-between mb-2">
                            <div class="p-4">
                                <p class="font-semibold">{{ $clase->nombre }}, Docente: {{ $clase->docente_id }}</p>
                                <p class="text-gray-600">Puntuacion: {{ $clase->pivot->puntuacion }}</p>
                            </div>
                        </div>
                        <hr class="my-2">
                    @endforeach
                </div>
            </div>
            <div style="max-height: 400px;" class="w-full md:w-1/2 px-4">
                <h3 class="text-lg font-semibold mb-4">Gráfica de Progreso</h3>
                <canvas id="pie-chart"></canvas>
            </div>
        </div>
    </div>
</x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var data = {
                labels: ['Aprobadas', 'Reprobadas'],
                datasets: [
                    {
                        data: [{{ $datos['materias_aprobadas']->count() }}, {{ $datos['materias_reprobadas']->count() }}],
                        backgroundColor: [
                            '#4CAF50',
                            '#FF5252'
                        ],
                        borderWidth: 1
                    }
                ]
            };
            var options = {
                responsive: true,
                maintainAspectRatio: false
            };
            var ctx = document.getElementById('pie-chart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: data,
                options: options
            });
        });
    </script>
