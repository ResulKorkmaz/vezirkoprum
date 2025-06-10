<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Post;
use App\Models\Message;
use App\Rules\RecaptchaRule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Bildiri oluştur
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'reportable_type' => ['required', 'string', 'in:App\Models\Post,App\Models\Message,App\Models\User'],
            'reportable_id' => ['required', 'integer'],
            'reason' => ['required', 'string', 'in:' . implode(',', array_keys(Report::getReasons()))],
            'description' => ['nullable', 'string', 'max:500'],
            'recaptcha_token' => [new RecaptchaRule('report')],
        ], [
            'reportable_type.required' => 'İçerik türü belirtilmelidir.',
            'reportable_type.in' => 'Geçersiz içerik türü.',
            'reportable_id.required' => 'İçerik ID\'si belirtilmelidir.',
            'reason.required' => 'Bildiri nedeni seçilmelidir.',
            'reason.in' => 'Geçersiz bildiri nedeni.',
            'description.max' => 'Açıklama en fazla 500 karakter olabilir.',
        ]);

        // İçeriğin var olup olmadığını kontrol et
        $reportableClass = $request->reportable_type;
        $reportable = $reportableClass::find($request->reportable_id);

        if (!$reportable) {
            return response()->json([
                'success' => false,
                'message' => 'Bildirmek istediğiniz içerik bulunamadı.'
            ], 404);
        }

        // Kullanıcı daha önce bu içeriği bildirmiş mi?
        $existingReport = Report::where([
            'reporter_id' => Auth::id(),
            'reportable_type' => $request->reportable_type,
            'reportable_id' => $request->reportable_id,
        ])->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Bu içeriği daha önce bildirmişsiniz.'
            ], 422);
        }

        // Kendi içeriğini bildirmeye çalışıyor mu?
        if (method_exists($reportable, 'user_id') && $reportable->user_id == Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Kendi içeriğinizi bildiremezsiniz.'
            ], 422);
        }

        // Bildiri oluştur
        $report = Report::create([
            'reporter_id' => Auth::id(),
            'reportable_type' => $request->reportable_type,
            'reportable_id' => $request->reportable_id,
            'reason' => $request->reason,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bildiriminiz başarıyla gönderildi. İnceleme sürecine alınacaktır.'
        ]);
    }

    /**
     * Bildiri formunu göster (AJAX)
     */
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'type' => ['required', 'string', 'in:post,message,user'],
            'id' => ['required', 'integer'],
        ]);

        $type = $request->type;
        $id = $request->id;

        // İçeriğin var olup olmadığını kontrol et
        $model = match($type) {
            'post' => Post::find($id),
            'message' => Message::find($id),
            'user' => \App\Models\User::find($id),
            default => null,
        };

        if (!$model) {
            return response()->json([
                'success' => false,
                'message' => 'İçerik bulunamadı.'
            ], 404);
        }

        // Daha önce bildirilmiş mi?
        $alreadyReported = Report::where([
            'reporter_id' => Auth::id(),
            'reportable_type' => 'App\\Models\\' . ucfirst($type),
            'reportable_id' => $id,
        ])->exists();

        if ($alreadyReported) {
            return response()->json([
                'success' => false,
                'message' => 'Bu içeriği daha önce bildirmişsiniz.'
            ], 422);
        }

        $reasons = Report::getReasons();

        return response()->json([
            'success' => true,
            'data' => [
                'type' => $type,
                'id' => $id,
                'reasons' => $reasons,
                'model_type' => 'App\\Models\\' . ucfirst($type),
            ]
        ]);
    }
}
