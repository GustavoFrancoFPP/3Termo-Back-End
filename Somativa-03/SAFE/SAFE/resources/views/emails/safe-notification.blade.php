@component('mail::message')
# {{ ucfirst($type) }} - SAFE

Prezado(a) **{{ $guardian->name }}**,

{!! nl2br($message) !!}

---

**Informações do Aluno:**
- Nome: {{ $student->name }}
- Matrícula: {{ $student->registration }}
- Classe: {{ $student->class }}

---

*Este é um email automático do Sistema de Autorização e Fluxo Escolar (SAFE).*
*Não responda este email.*

@component('mail::footer')
© {{ date('Y') }} Sistema SAFE - Todos os direitos reservados
@endcomponent

@endcomponent
