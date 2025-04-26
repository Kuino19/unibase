<?php

namespace App\Http\Controllers;

use App\Models\TextDocument;
use App\Models\ScannedNote;
use App\Models\ChatMessage;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's activity stats
        $stats = [
            'study_hours' => $this->calculateStudyHours(),
            'notes_scanned' => ScannedNote::where('user_id', $user->id)->count(),
            'ai_assists' => $this->countAIAssists($user->id),
        ];
        
        // Get recent activity
        $recentActivity = $this->getRecentActivity($user->id);
        
        // Get study reminders
        $reminders = $this->getStudyReminders($user->id);
        
        return view('dashboard', compact('stats', 'recentActivity', 'reminders'));
    }
    
    private function calculateStudyHours()
    {
        // This would typically calculate based on session tracking
        // For now, return a placeholder value
        return 12.5;
    }
    
    private function countAIAssists($userId)
    {
        $textAnalysis = TextDocument::where('user_id', $userId)->count();
        $scannedNotes = ScannedNote::where('user_id', $userId)->count();
        $therapyChats = ChatMessage::where('user_id', $userId)
            ->where('type', 'therapy')
            ->count();
            
        return $textAnalysis + $scannedNotes + $therapyChats;
    }
    
    private function getRecentActivity($userId)
    {
        // Combine and sort recent activity from different modules
        $activity = collect();
        
        // Add text documents
        $activity = $activity->merge(
            TextDocument::where('user_id', $userId)
                ->latest()
                ->take(3)
                ->get()
                ->map(function ($doc) {
                    return [
                        'type' => 'document',
                        'icon' => 'book',
                        'color' => 'green',
                        'message' => "Converted {$doc->title} to audio",
                        'created_at' => $doc->created_at
                    ];
                })
        );
        
        // Add scanned notes
        $activity = $activity->merge(
            ScannedNote::where('user_id', $userId)
                ->latest()
                ->take(3)
                ->get()
                ->map(function ($note) {
                    return [
                        'type' => 'scan',
                        'icon' => 'camera',
                        'color' => 'blue',
                        'message' => "Scanned {$note->title}",
                        'created_at' => $note->created_at
                    ];
                })
        );
        
        // Add therapy sessions
        $activity = $activity->merge(
            ChatMessage::where('user_id', $userId)
                ->where('type', 'therapy')
                ->latest()
                ->take(3)
                ->get()
                ->map(function ($chat) {
                    return [
                        'type' => 'therapy',
                        'icon' => 'comments',
                        'color' => 'purple',
                        'message' => 'Therapy session completed',
                        'created_at' => $chat->created_at
                    ];
                })
        );
        
        return $activity->sortByDesc('created_at')->take(3);
    }
    
    private function getStudyReminders($userId)
    {
        // This would typically come from a reminders table
        // For now, return placeholder data
        return [
            [
                'title' => 'Physics Quiz',
                'due_date' => now()->addDay(),
                'priority' => 'medium',
            ],
            [
                'title' => 'Math Assignment',
                'due_date' => now()->addDays(2),
                'priority' => 'high',
            ],
        ];
    }
}
