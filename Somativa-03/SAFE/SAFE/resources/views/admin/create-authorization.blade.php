@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-plus-circle me-2"></i>Nova Autorizacao
            </h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body p-5">
            <form method="POST" action="{{ route('admin.store-authorization') }}">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="student_id" class="form-label fw-bold">
                            <i class="fas fa-user-graduate me-2 text-senai-blue"></i>Aluno
                        </label>
                        <select class="form-select @error('student_id') is-invalid @enderror"
                                id="student_id" name="student_id" required>
                            <option value="">-- Selecione um aluno --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                    {{ $student->name }} ({{ $student->registration }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="type" class="form-label fw-bold">
                            <i class="fas fa-door-open me-2 text-senai-blue"></i>Tipo de Autorizacao
                        </label>
                        <select class="form-select @error('type') is-invalid @enderror"
                                id="type" name="type" required>
                            <option value="">-- Selecione o tipo --</option>
                            <option value="entry" @selected(old('type') == 'entry')>Entrada</option>
                            <option value="exit" @selected(old('type') == 'exit')>Saida</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="scheduled_time" id="scheduled_time_label" class="form-label fw-bold">
                            <i class="fas fa-clock me-2 text-senai-blue"></i>Horario de entrada/saida
                        </label>
                        <input type="time"
                               class="form-control @error('scheduled_time') is-invalid @enderror"
                               id="scheduled_time"
                               name="scheduled_time"
                               value="{{ old('scheduled_time') }}"
                               step="60"
                               required>
                        @error('scheduled_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="guardian_id" class="form-label fw-bold">
                            <i class="fas fa-chalkboard-user me-2 text-senai-blue"></i>Professor que deu aula no dia
                        </label>
                        <select class="form-select @error('guardian_id') is-invalid @enderror"
                                id="guardian_id" name="guardian_id" required>
                            <option value="">-- Selecione o professor do dia --</option>
                            @foreach($guardians as $guardian)
                                <option value="{{ $guardian->id }}" @selected(old('guardian_id') == $guardian->id)>
                                    {{ $guardian->name }} ({{ $guardian->email }})
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Escolha quem deu aula para o aluno naquele dia.</small>
                        @error('guardian_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="professor_id" class="form-label fw-bold">
                            <i class="fas fa-clipboard-check me-2 text-senai-blue"></i>Professor que analisa
                        </label>
                        <select class="form-select @error('professor_id') is-invalid @enderror"
                                id="professor_id" name="professor_id" required>
                            <option value="">-- Selecione um professor --</option>
                            @foreach($professors as $professor)
                                <option value="{{ $professor->id }}" @selected(old('professor_id') == $professor->id)>
                                    {{ $professor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('professor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="reason" class="form-label fw-bold">
                        <i class="fas fa-pen me-2 text-senai-blue"></i>Motivo (Opcional)
                    </label>
                    <textarea class="form-control @error('reason') is-invalid @enderror"
                              id="reason" name="reason" rows="3"
                              placeholder="Descreva o motivo da autorizacao...">{{ old('reason') }}</textarea>
                    @error('reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-senai-primary btn-lg fw-bold">
                        <i class="fas fa-check me-2"></i>Criar Autorizacao
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="alert alert-info mt-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Fluxo de Autorizacao:</strong>
        <ol class="mb-0 mt-2">
            <li>Admin cria a autorizacao e informa o professor que deu aula no dia.</li>
            <li>Professor analisa e aprova/rejeita.</li>
            <li>Portaria valida com codigo e registra entrada/saida.</li>
        </ol>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const typeSelect = document.getElementById('type');
    const scheduledTimeLabel = document.getElementById('scheduled_time_label');

    function updateScheduledTimeLabel() {
        if (!scheduledTimeLabel || !typeSelect) {
            return;
        }

        if (typeSelect.value === 'entry') {
            scheduledTimeLabel.innerHTML = '<i class="fas fa-clock me-2 text-senai-blue"></i>Horario de entrada';
        } else if (typeSelect.value === 'exit') {
            scheduledTimeLabel.innerHTML = '<i class="fas fa-clock me-2 text-senai-blue"></i>Horario de saida';
        } else {
            scheduledTimeLabel.innerHTML = '<i class="fas fa-clock me-2 text-senai-blue"></i>Horario de entrada/saida';
        }
    }

    typeSelect?.addEventListener('change', updateScheduledTimeLabel);
    updateScheduledTimeLabel();
</script>
@endpush
