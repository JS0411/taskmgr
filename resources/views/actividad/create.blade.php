<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('actividad.store') }}">
            @csrf

            <div>
                <x-label for="modalidad" value="Modalidad" />
                <select id="modalidad" name="modalidad" class="form-select w-full" required>
                    <option value="Examen">Examen</option>
                    <option value="Examen">Exposicion</option>
                    <option value="Examen">Taller</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="porcentaje" value="Porcentaje" />
                <x-input id="porcentaje" class="block mt-1 w-full" type="number" min=1 max=50 name="porcentaje" :value="old('porcentaje')" placeholder="20" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="entrega" value="Fecha de Entrega" />
                <input type="datetime-local" id="entrega" name="entrega" required>
            </div>

            <div class="mt-4">
                <x-label for="descripcion" value="Descripción" />
                <x-input id="descripcion" class="block mt-1 w-full" type="text" name="descripcion" :value="old('descripcion')" placeholder="Descripción" required />
            </div>

            <input type="hidden" name="asignatura_id" value="{{ $datos }}">

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    Crear
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>