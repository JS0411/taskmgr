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
            <h2 class="text-xl font-bold">Asignaciones Pendientes</h2>
                @if ($datos['actividades']->isEmpty())
                        <p class="my-4">No tienes actividades que entregar para esta semana.</p>
                @else
                    <ul>
                        @foreach ($datos['actividades'] as $actividad)
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">
                                    <a class="" href="/actividad/{{$actividad->id}}">
                                        <li style="display: flex; gap: 24px; margin-top: 4px">
                                            {{$actividad->modalidad}},{{$actividad->puntuacionMaxima}}% - {{ $actividad->asignatura->nombre}}
                                            <div>
                                                @if ($actividad->estado != 'Pendiente')
                                                    <p style="color: #666666">Finalizada</p>
                                                @else
                                                    <p style="color: #ff0000">Para entregar en {{$actividad->entrega()}}</p>
                                                @endif
                                            </div>
                                        </li>                                            
                                    </a>
                                </div>
                            @endforeach
                    </ul>
                @endif
            @endif


            <div class="my-8">
                <h2 class="text-xl font-bold">Asignaturas en Curso</h2>
                @if ($datos['asignaturas']->isEmpty())
                    @if (Auth::user()->tipo == 'docente')
                        <p class="my-4">No tiene ninguna asignatura, presione el boton para crear una.</p>
                        <a href="{{ route('asignatura.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Crear Asignatura</a>
                    @else
                        <p class="my-4">No se ha encontrado ninguna asignatura, por favor contacte a su docente.</p>
                    @endif
                @else
                    <ul>
                        @foreach ($datos['asignaturas'] as $asignatura)
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">
                                <a class="" href="asignatura/{{$asignatura->id}}">
                                    <li style="display: flex; gap: 24px; margin-top: 4px">{{ $asignatura->nombre }}</li>
                                </a>
                            </div>
                        @endforeach
                        @if (Auth::user()->tipo == 'docente')
                                <a href="{{ route('asignatura.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 mt-4 rounded hover:bg-blue-600">Crear Asignatura</a>
                            @endif
                    </ul>
                @endif
            </div>
        
    </div>
    
</x-app-layout>




