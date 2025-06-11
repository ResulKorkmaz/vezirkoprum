<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Post;
use App\Models\Message;
use App\Models\Comment;
use App\Rules\RecaptchaRule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class ReportController extends Controller
{
    /**
     * Bildiri oluştur
     */
    public function store(Request $request): JsonResponse
    {
        \Log::info('Report request data:', $request->all());
        
        try {
            $request->validate([
                'type' => ['required', 'string', 'in:post,message,user,comment'],
                'item_id' => ['required', 'integer'],
                'reason' => ['required', 'string', 'in:' . implode(',', array_keys(Report::getReasons()))],
                'description' => ['nullable', 'string', 'max:500'],
            ], [
                'type.required' => 'İçerik türü belirtilmelidir.',
                'type.in' => 'Geçersiz içerik türü.',
                'item_id.required' => 'İçerik ID\'si belirtilmelidir.',
                'reason.required' => 'Bildiri nedeni seçilmelidir.',
                'reason.in' => 'Geçersiz bildiri nedeni.',
                'description.max' => 'Açıklama en fazla 500 karakter olabilir.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', Arr::flatten($e->errors())),
                'errors' => $e->errors()
            ], 422);
        }

        // Model class'ını belirle
        $reportableType = match($request->type) {
            'post' => 'App\\Models\\Post',
            'message' => 'App\\Models\\Message',
            'user' => 'App\\Models\\User',
            'comment' => 'App\\Models\\Comment',
            default => null,
        };

        if (!$reportableType) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz içerik türü.'
            ], 400);
        }

        // İçeriğin var olup olmadığını kontrol et
        $reportableClass = $reportableType;
        $reportable = $reportableClass::find($request->item_id);

        if (!$reportable) {
            return response()->json([
                'success' => false,
                'message' => 'Bildirmek istediğiniz içerik bulunamadı.'
            ], 404);
        }

        // Kullanıcı daha önce bu içeriği bildirmiş mi?
        $existingReport = Report::where([
            'reporter_id' => Auth::id(),
            'reportable_type' => $reportableType,
            'reportable_id' => $request->item_id,
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
            'reportable_type' => $reportableType,
            'reportable_id' => $request->item_id,
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
            'type' => ['required', 'string', 'in:post,message,user,comment'],
            'id' => ['required', 'integer'],
        ]);

        $type = $request->type;
        $id = $request->id;

        // İçeriğin var olup olmadığını kontrol et
        $model = match($type) {
            'post' => Post::find($id),
            'message' => Message::find($id),
            'user' => \App\Models\User::find($id),
            'comment' => \App\Models\Comment::find($id),
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

        // İçerik bilgilerini ekle
        $contentInfo = null;
        if ($type === 'comment' && $model) {
            $contentInfo = [
                'content' => $model->content,
                'user_name' => $model->user->name ?? 'Bilinmeyen Kullanıcı',
                'created_at' => $model->created_at->diffForHumans(),
            ];
        } elseif ($type === 'post' && $model) {
            $contentInfo = [
                'content' => \Str::limit($model->content, 100),
                'user_name' => $model->user->name ?? 'Bilinmeyen Kullanıcı',
                'created_at' => $model->created_at->diffForHumans(),
            ];
        } elseif ($type === 'message' && $model) {
            $contentInfo = [
                'content' => \Str::limit($model->content, 100),
                'user_name' => $model->user->name ?? 'Bilinmeyen Kullanıcı',
                'created_at' => $model->created_at->diffForHumans(),
            ];
        } elseif ($type === 'user' && $model) {
            $contentInfo = [
                'name' => $model->name,
                'email' => $model->email,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'type' => $type,
                'id' => $id,
                'reasons' => $reasons,
                'model_type' => 'App\\Models\\' . ucfirst($type),
                'content_info' => $contentInfo,
            ]
        ]);
    }
}
