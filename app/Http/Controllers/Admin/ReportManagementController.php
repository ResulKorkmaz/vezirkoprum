<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportManagementController extends Controller
{
    /**
     * Bildiri listesi
     */
    public function index(Request $request)
    {
        $query = Report::with(['reporter', 'reviewer', 'reportable'])
            ->latest();

        // Filtreleme
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('reportable_type', 'App\\Models\\' . ucfirst($request->type));
        }

        if ($request->filled('reason')) {
            $query->where('reason', $request->reason);
        }

        $reports = $query->paginate(20);

        $stats = [
            'pending' => Report::where('status', 'pending')->count(),
            'reviewed' => Report::where('status', 'reviewed')->count(),
            'resolved' => Report::where('status', 'resolved')->count(),
            'dismissed' => Report::where('status', 'dismissed')->count(),
        ];

        return view('admin.reports.index', compact('reports', 'stats'));
    }

    /**
     * Bildiri detayı
     */
    public function show(Report $report)
    {
        $report->load(['reporter', 'reviewer', 'reportable']);
        
        return view('admin.reports.show', compact('report'));
    }

    /**
     * Bildiri durumunu güncelle
     */
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => ['required', 'in:pending,reviewed,resolved,dismissed'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $report->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Bildiri durumu güncellendi.');
    }

    /**
     * Bildiriyi sil
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Bildiri silindi.');
    }

    /**
     * Toplu işlemler
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:resolve,dismiss,delete'],
            'report_ids' => ['required', 'array'],
            'report_ids.*' => ['exists:reports,id'],
        ]);

        $reports = Report::whereIn('id', $request->report_ids);

        switch ($request->action) {
            case 'resolve':
                $reports->update([
                    'status' => 'resolved',
                    'reviewed_by' => Auth::id(),
                    'reviewed_at' => now(),
                ]);
                $message = 'Seçilen bildiriler çözüldü olarak işaretlendi.';
                break;

            case 'dismiss':
                $reports->update([
                    'status' => 'dismissed',
                    'reviewed_by' => Auth::id(),
                    'reviewed_at' => now(),
                ]);
                $message = 'Seçilen bildiriler reddedildi.';
                break;

            case 'delete':
                $reports->delete();
                $message = 'Seçilen bildiriler silindi.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * İçeriği gizle/aktif et
     */
    public function toggleContent(Report $report)
    {
        $reportable = $report->reportable;

        if (!$reportable) {
            return redirect()->back()->with('error', 'İçerik bulunamadı.');
        }

        // Post veya Message için is_active alanını toggle et
        if (method_exists($reportable, 'update') && isset($reportable->is_active)) {
            $reportable->update([
                'is_active' => !$reportable->is_active
            ]);

            $action = $reportable->is_active ? 'aktif edildi' : 'gizlendi';
            
            // Bildiri durumunu güncelle
            $report->update([
                'status' => 'resolved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'admin_notes' => "İçerik {$action}.",
            ]);

            return redirect()->back()->with('success', "İçerik {$action}.");
        }

        return redirect()->back()->with('error', 'Bu içerik için işlem yapılamaz.');
    }
}
