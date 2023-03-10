<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Evaluar Actividades') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Lista de Estudiantes</h3>
                <p class="text-sm mb-4">Asigne una nota a cada estudiante en esta lista dependiendo de sus entregas. Puede presionar "Enviar Calificaciones" una vez que haya asignado una nota a todos.</p>
                <form x-data="{ estudiantes: [], puntuaciones: {} }" x-init="estudiantes = {{ $datos['estudiantes'] }}; estudiantes.forEach(estudiante => { puntuaciones[estudiante.id] = '' })" action="{{ route('actividad.update', ['id' => $datos['id']]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @foreach($datos['estudiantes'] as $estudiante)
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <span class="font-semibold">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</span>
                                <span class="text-sm text-gray-500">- {{ $estudiante->cedula }}</span>
                            </div>
                            <p></p>
                            <input type="text" placeholder="Puntuacion" name="puntuaciones[{{ $estudiante->id }}]" x-model="puntuaciones[{{ $estudiante->id }}]" class="w-120 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    @endforeach
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Enviar Calificaciones
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

