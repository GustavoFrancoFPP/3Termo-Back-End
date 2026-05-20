<?php

namespace App\Services;

use App\Models\Authorization;
use App\Models\SafeNotification;
use App\Models\Guardian;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NotificationService
{
    /**
     * Enviar notificação de autorização solicitada
     */
    public function sendAuthorizationRequest(Authorization $authorization): void
    {
        $guardian = $authorization->guardian;
        $student = $authorization->student;

        $message = $this->buildAuthorizationRequestMessage($student, $authorization);
        
        $this->sendNotification(
            authorization: $authorization,
            guardian: $guardian,
            type: 'authorization_request',
            message: $message,
            channels: $this->getEnabledChannels($guardian)
        );

        Log::info("Notificação de autorização solicitada", [
            'authorization_id' => $authorization->id,
            'guardian_id' => $guardian->id,
            'student_id' => $student->id,
            'type' => 'authorization_request',
            'timestamp' => now(),
        ]);
    }

    /**
     * Enviar notificação de entrada do aluno
     */
    public function sendEntryNotification(Authorization $authorization): void
    {
        $guardian = $authorization->guardian;
        $student = $authorization->student;

        $message = "✅ Entrada Registrada\n";
        $message .= "O(a) aluno(a) {$student->name} foi registrado(a) na entrada da escola as " . now()->format('H:i:s') . "\n";
        $message .= "Data: " . now()->format('d/m/Y H:i:s') . "\n";
        $message .= "Horario previsto: " . $authorization->scheduled_time_formatted . "\n";
        $message .= "Classe: {$student->class}";

        $this->sendNotification(
            authorization: $authorization,
            guardian: $guardian,
            type: 'entry_notification',
            message: $message,
            channels: $this->getEnabledChannels($guardian)
        );

        Log::info("Notificação de entrada registrada", [
            'authorization_id' => $authorization->id,
            'guardian_id' => $guardian->id,
            'student_id' => $student->id,
            'type' => 'entry_notification',
            'timestamp' => now(),
        ]);
    }

    /**
     * Enviar notificação de saída do aluno
     */
    public function sendExitNotification(Authorization $authorization): void
    {
        $guardian = $authorization->guardian;
        $student = $authorization->student;

        $message = "🚪 Saída Registrada\n";
        $message .= "O(a) aluno(a) {$student->name} foi registrado(a) na saida da escola as " . now()->format('H:i:s') . "\n";
        $message .= "Data: " . now()->format('d/m/Y H:i:s') . "\n";
        $message .= "Horario previsto: " . $authorization->scheduled_time_formatted . "\n";
        $message .= "Classe: {$student->class}";

        $this->sendNotification(
            authorization: $authorization,
            guardian: $guardian,
            type: 'exit_notification',
            message: $message,
            channels: $this->getEnabledChannels($guardian)
        );

        Log::info("Notificação de saída registrada", [
            'authorization_id' => $authorization->id,
            'guardian_id' => $guardian->id,
            'student_id' => $student->id,
            'type' => 'exit_notification',
            'timestamp' => now(),
        ]);
    }

    /**
     * Enviar notificação de rejeição
     */
    public function sendRejectionNotification(Authorization $authorization): void
    {
        $guardian = $authorization->guardian;
        $student = $authorization->student;

        $type = $authorization->type === 'exit' ? 'saida' : 'entrada';

        $message = "❌ Autorização Rejeitada\n";
        $message .= "A autorizacao de {$type} para {$student->name} foi rejeitada.\n";
        $message .= "Horario solicitado: " . $authorization->scheduled_time_formatted . "\n";
        $message .= "Motivo: " . ($authorization->rejection_reason ?? 'Não especificado') . "\n";
        $message .= "Favor contatar a escola para mais informações.";

        $this->sendNotification(
            authorization: $authorization,
            guardian: $guardian,
            type: 'rejection_notification',
            message: $message,
            channels: $this->getEnabledChannels($guardian)
        );

        Log::warning("Notificação de rejeição enviada", [
            'authorization_id' => $authorization->id,
            'guardian_id' => $guardian->id,
            'student_id' => $student->id,
            'rejection_reason' => $authorization->rejection_reason,
            'timestamp' => now(),
        ]);
    }

    /**
     * Enviar notificação através dos canais configurados
     */
    private function sendNotification(
        Authorization $authorization,
        Guardian $guardian,
        string $type,
        string $message,
        array $channels
    ): void {
        foreach ($channels as $channel) {
            if ($channel === 'email') {
                $this->sendEmailNotification($authorization, $guardian, $type, $message);
            } elseif ($channel === 'log') {
                $this->sendLogNotification($authorization, $guardian, $type, $message);
            }
        }
    }

    /**
     * Enviar notificação por email usando Mailpit
     */
    private function sendEmailNotification(
        Authorization $authorization,
        Guardian $guardian,
        string $type,
        string $message
    ): void {
        try {
            Mail::send('emails.safe-notification', [
                'guardian' => $guardian,
                'student' => $authorization->student,
                'message' => $message,
                'type' => $type,
            ], function ($mail) use ($guardian) {
                $mail->to($guardian->email)
                    ->subject('SAFE - Sistema de Autorização Escolar');
            });

            $notification = SafeNotification::create([
                'authorization_id' => $authorization->id,
                'guardian_id' => $guardian->id,
                'channel' => 'email',
                'type' => $type,
                'message' => $message,
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            Log::info("Email enviado com sucesso", [
                'notification_id' => $notification->id,
                'guardian_email' => $guardian->email,
                'type' => $type,
            ]);
        } catch (\Exception $e) {
            Log::error("Erro ao enviar email", [
                'guardian_id' => $guardian->id,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);

            SafeNotification::create([
                'authorization_id' => $authorization->id,
                'guardian_id' => $guardian->id,
                'channel' => 'email',
                'type' => $type,
                'message' => $message,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Enviar notificação por log (simulação de envio)
     */
    private function sendLogNotification(
        Authorization $authorization,
        Guardian $guardian,
        string $type,
        string $message
    ): void {
        try {
            $notification = SafeNotification::create([
                'authorization_id' => $authorization->id,
                'guardian_id' => $guardian->id,
                'channel' => 'log',
                'type' => $type,
                'message' => $message,
                'status' => 'sent',
                'response' => 'Registro interno de auditoria.',
                'sent_at' => now(),
            ]);

            Log::info("Notificacao registrada no canal log", [
                'notification_id' => $notification->id,
                'authorization_id' => $authorization->id,
                'guardian_id' => $guardian->id,
                'guardian_name' => $guardian->name,
                'guardian_phone' => $guardian->phone,
                'channel' => 'log',
                'type' => $type,
                'timestamp' => now()->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            Log::error("Erro ao registrar notificacao no canal log", [
                'authorization_id' => $authorization->id,
                'guardian_id' => $guardian->id,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Obter canais habilitados para o guardião
     */
    private function getEnabledChannels(Guardian $guardian): array
    {
        $channels = ['log']; // Log é sempre ativado para auditoria

        if ($guardian->receive_notifications) {
            $preferences = json_decode($guardian->notification_preferences ?? '{}', true);
            
            if ($preferences['email'] ?? true) {
                $channels[] = 'email';
            }
        }

        return $channels;
    }

    /**
     * Construir mensagem de solicitação de autorização
     */
    private function buildAuthorizationRequestMessage(mixed $student, Authorization $authorization): string
    {
        $type = $authorization->type === 'exit' ? 'saída' : 'entrada';
        
        $message = "📋 Solicitação de Autorização de $type\n\n";
        $message .= "Prezado(a) " . $authorization->guardian->name . ",\n\n";
        $message .= "Solicitamos sua autorização para o(a) aluno(a):\n";
        $message .= "Nome: " . $student->name . "\n";
        $message .= "Matrícula: " . $student->registration . "\n";
        $message .= "Classe: " . $student->class . "\n";
        $message .= "Tipo: " . ($authorization->type === 'exit' ? 'SAÍDA' : 'ENTRADA') . "\n";
        $message .= "Horario solicitado: " . $authorization->scheduled_time_formatted . "\n";
        $message .= "Motivo: " . ($authorization->reason ?? 'Não especificado') . "\n";
        $message .= "Código de Validação: " . $authorization->validation_code . "\n";
        $message .= "Data: " . $authorization->created_at->format('d/m/Y H:i:s') . "\n\n";
        $message .= "Por favor, analise esta solicitacao no sistema SAFE.";

        return $message;
    }
}
