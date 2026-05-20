@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-plus-circle me-2"></i>Nova Autorizacao</h1>
    <p class="text-muted">Criar nova solicitacao de autorizacao de entrada ou saida</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Preencha os dados da autorizacao</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('authorizations.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="student_id" class="form-label"><i class="bi bi-person me-2"></i>Aluno <span class="text-danger">*</span></label>
                        <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror">
                            <option value="">-- Selecione um aluno --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} ({{ $student->registration }}) - Classe: {{ $student->class }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label"><i class="bi bi-arrow-left-right me-2"></i>Tipo de Autorizacao <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="">-- Selecione o tipo --</option>
                            <option value="entry" {{ old('type') == 'entry' ? 'selected' : '' }}>Entrada</option>
                            <option value="exit" {{ old('type') == 'exit' ? 'selected' : '' }}>Saida</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="scheduled_time" id="scheduled_time_label" class="form-label">
                            <i class="bi bi-clock me-2"></i>Horario de entrada/saida <span class="text-danger">*</span>
                        </label>
                        <input type="time"
                               name="scheduled_time"
                               id="scheduled_time"
                               class="form-control @error('scheduled_time') is-invalid @enderror"
                               value="{{ old('scheduled_time') }}"
                               step="60"
                               required>
                        @error('scheduled_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="guardian_id" class="form-label"><i class="bi bi-person-check me-2"></i>Professor que deu aula no dia <span class="text-danger">*</span></label>
                        <select name="guardian_id" id="guardian_id" class="form-control @error('guardian_id') is-invalid @enderror">
                            <option value="">-- Selecione o professor do dia --</option>
                            @foreach($guardians as $guardian)
                                <option value="{{ $guardian->id }}" {{ old('guardian_id') == $guardian->id ? 'selected' : '' }}>
                                    {{ $guardian->name }} ({{ $guardian->email }})
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Escolha quem deu aula para o aluno naquele dia.</small>
                        @error('guardian_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="teacher_id" class="form-label"><i class="bi bi-briefcase me-2"></i>Professor legado (Opcional)</label>
                        <select name="teacher_id" id="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror">
                            <option value="">-- Nenhum professor --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }} ({{ $teacher->class }})
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label"><i class="bi bi-chat-left-text me-2"></i>Motivo (Opcional)</label>
                        <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="3" placeholder="Descreva o motivo da autorizacao">{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Informacao:</strong> Uma notificacao sera registrada para o professor responsavel do dia.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Criar Autorizacao
                        </button>
                        <a href="{{ route('authorizations.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
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
            scheduledTimeLabel.innerHTML = '<i class="bi bi-clock me-2"></i>Horario de entrada <span class="text-danger">*</span>';
        } else if (typeSelect.value === 'exit') {
            scheduledTimeLabel.innerHTML = '<i class="bi bi-clock me-2"></i>Horario de saida <span class="text-danger">*</span>';
        } else {
            scheduledTimeLabel.innerHTML = '<i class="bi bi-clock me-2"></i>Horario de entrada/saida <span class="text-danger">*</span>';
        }
    }

    typeSelect?.addEventListener('change', updateScheduledTimeLabel);
    updateScheduledTimeLabel();
</script>
@endpush
