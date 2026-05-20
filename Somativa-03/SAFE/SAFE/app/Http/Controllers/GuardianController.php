<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    /**
     * Listar todos os responsáveis
     */
    public function index()
    {
        $guardians = Guardian::with('students')->paginate(20);
        return view('guardians.index', compact('guardians'));
    }

    /**
     * Formulário para criar novo responsável
     */
    public function create()
    {
        return view('guardians.create');
    }

    /**
     * Armazenar novo responsável
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc|max:255|unique:guardians,email',
            'phone' => ['required', 'string', 'max:15', function ($attribute, $value, $fail) {
                $digits = $this->onlyDigits($value);

                if (!in_array(strlen($digits), [10, 11], true)) {
                    $fail('O telefone deve ter DDD e 10 ou 11 dígitos.');
                }
            }],
            'document' => ['required', 'string', 'max:14', function ($attribute, $value, $fail) {
                if (strlen($this->onlyDigits($value)) !== 11) {
                    $fail('O CPF deve ter 11 dígitos.');
                    return;
                }

                if ($this->documentExists($value)) {
                    $fail('Este CPF já está cadastrado.');
                }
            }],
            'can_authorize_exit' => 'nullable|boolean',
            'receive_notifications' => 'nullable|boolean',
        ]);

        $validated['email'] = strtolower($validated['email']);
        $validated['phone'] = $this->formatPhone($validated['phone']);
        $validated['document'] = $this->formatCpf($validated['document']);
        $validated['relationship'] = 'Professor do dia';
        $validated['can_authorize_exit'] = $request->boolean('can_authorize_exit');
        $validated['receive_notifications'] = $request->boolean('receive_notifications');

        Guardian::create($validated);

        return redirect()->route('guardians.index')
            ->with('success', 'Professor responsavel cadastrado com sucesso!');
    }

    /**
     * Exibir detalhes do responsável
     */
    public function show(Guardian $guardian)
    {
        $guardian->load(['students', 'authorizations', 'notifications']);
        return view('guardians.show', compact('guardian'));
    }

    /**
     * Formulário para editar responsável
     */
    public function edit(Guardian $guardian)
    {
        return view('guardians.edit', compact('guardian'));
    }

    /**
     * Atualizar responsável
     */
    public function update(Request $request, Guardian $guardian)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc|max:255|unique:guardians,email,' . $guardian->id,
            'phone' => ['required', 'string', 'max:15', function ($attribute, $value, $fail) {
                $digits = $this->onlyDigits($value);

                if (!in_array(strlen($digits), [10, 11], true)) {
                    $fail('O telefone deve ter DDD e 10 ou 11 dígitos.');
                }
            }],
            'document' => ['required', 'string', 'max:14', function ($attribute, $value, $fail) use ($guardian) {
                if (strlen($this->onlyDigits($value)) !== 11) {
                    $fail('O CPF deve ter 11 dígitos.');
                    return;
                }

                if ($this->documentExists($value, $guardian->id)) {
                    $fail('Este CPF já está cadastrado.');
                }
            }],
            'can_authorize_exit' => 'nullable|boolean',
            'receive_notifications' => 'nullable|boolean',
        ]);

        $validated['email'] = strtolower($validated['email']);
        $validated['phone'] = $this->formatPhone($validated['phone']);
        $validated['document'] = $this->formatCpf($validated['document']);
        $validated['relationship'] = 'Professor do dia';
        $validated['can_authorize_exit'] = $request->boolean('can_authorize_exit');
        $validated['receive_notifications'] = $request->boolean('receive_notifications');

        $guardian->update($validated);

        return redirect()->route('guardians.show', $guardian)
            ->with('success', 'Professor responsavel atualizado com sucesso!');
    }

    /**
     * Deletar responsável
     */
    public function destroy(Guardian $guardian)
    {
        $guardian->delete();
        return redirect()->route('guardians.index')
            ->with('success', 'Professor responsavel removido com sucesso!');
    }
    private function onlyDigits(string $value): string
    {
        return preg_replace('/\D+/', '', $value) ?? '';
    }

    private function formatCpf(string $value): string
    {
        $digits = $this->onlyDigits($value);

        return sprintf(
            '%s.%s.%s-%s',
            substr($digits, 0, 3),
            substr($digits, 3, 3),
            substr($digits, 6, 3),
            substr($digits, 9, 2)
        );
    }

    private function formatPhone(string $value): string
    {
        $digits = $this->onlyDigits($value);

        if (strlen($digits) === 10) {
            return sprintf(
                '(%s) %s-%s',
                substr($digits, 0, 2),
                substr($digits, 2, 4),
                substr($digits, 6, 4)
            );
        }

        return sprintf(
            '(%s) %s-%s',
            substr($digits, 0, 2),
            substr($digits, 2, 5),
            substr($digits, 7, 4)
        );
    }

    private function documentExists(string $value, ?int $ignoreId = null): bool
    {
        $digits = $this->onlyDigits($value);
        $formatted = $this->formatCpf($value);

        return Guardian::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->whereIn('document', [$digits, $formatted])
            ->exists();
    }
}
