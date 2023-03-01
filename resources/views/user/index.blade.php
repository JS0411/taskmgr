<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resumen') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-4">Hola {{ $datos["nombre"] }}!</h1>

            @if (Auth::user()->tipo == 'estudiante')
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <div class="my-8">
                        <h2 class="text-xl font-bold">Asignaciones Pendientes</h2>
                        @if ($datos['actividades']->isEmpty())
                                <p>No tienes actividades que entregar para esta semana.</p>
                        @else
                            <ul>
                                @foreach ($datos['actividades'] as $actividad)
                                    <li style="display: flex; gap: 24px; margin-top: 4px">
                                        {{ $actividad->nombre }}
                                        {{ $actividad->fecha_entrega}}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
            </div>
            @endif


        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 mt-8">
            <x-button class="mt-4">
                <div class="my-8">
                    <h2 class="text-xl font-bold">Asignaturas en Curso</h2>
                    @if ($datos['asignaturas']->isEmpty())
                        @if (Auth::user()->tipo == 'docente')
                            <p class="my-4">No tiene ninguna asignatura, presione el boton para crear una.</p>
                            <a href="{{ route('asignatura.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Crear Asignatura</a>
                        @else
                            <p>No se ha encontrado ninguna asignatura, por favor contacte a su docente.</p>
                        @endif
                    @else
                        <ul>
                            @foreach ($datos['asignaturas'] as $asignatura)
                                <li style="display: flex; gap: 24px; margin-top: 4px">{{ $asignatura->nombre }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </x-button>
        </div>
        
    </div>
    
</x-app-layout>




