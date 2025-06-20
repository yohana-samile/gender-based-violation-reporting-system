<?php

namespace App\Http\Controllers\Gbv\Audit;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LogController extends Controller
{
    public function __construct() {
        $this->middleware('access.routeNeedsPermission:manage_role_and_permissions,all_functions', [
            'only' => ['index', 'show', 'download', 'delete', 'getLogFiles', 'formatSizeUnits']
        ]);
    }

    public function index()
    {
        $logFiles = $this->getLogFiles();
        return view('pages.audit.logs.index', compact('logFiles'));
    }

    /*
    public function show($fileName)
    {
        $filePath = storage_path("logs/{$fileName}");

        if (!File::exists($filePath)) {
            abort(404);
        }

        $logContent = File::get($filePath);

        return view('pages.backend.audit.logs.show', [
            'fileName' => $fileName,
            'logContent' => $logContent
        ]);
    } */

    public function show($fileName)
    {
        $filePath = storage_path("logs/{$fileName}");

        if (!File::exists($filePath)) {
            abort(404);
        }

        $logContent = File::get($filePath);
        $groupedLogs = $this->parseAndGroupLogs($logContent);

        return view('pages.audit.logs.show', [
            'fileName' => $fileName,
            'groupedLogs' => $groupedLogs
        ]);
    }

    protected function parseAndGroupLogs($content)
    {
        $pattern = '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\](.*?(?=\n\[|$))/ms';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        $groups = [];
        $groupThresholdMinutes = 5; // Group logs within 5 minutes

        foreach ($matches as $match) {
            $timestamp = trim($match[1]);
            $message = trim($match[2]);
            $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);

            // Format exactly like Laravel logs
            $logTimestamp = "[$timestamp]";

            if (empty($groups)) {
                // First group
                $groups[] = [
                    'time' => $dateTime,
                    'log_timestamp' => $logTimestamp, // Store original format
                    'formatted_time' => $dateTime->format('Y-m-d H:i:s'), // For display
                    'messages' => [$message]
                ];
            } else {
                $lastGroupIndex = count($groups) - 1;
                $lastGroup = &$groups[$lastGroupIndex];

                if ($dateTime->diffInMinutes($lastGroup['time']) > $groupThresholdMinutes ||
                    $this->shouldStartNewGroup($message, $lastGroup['messages'][0])) {
                    // New group
                    $groups[] = [
                        'time' => $dateTime,
                        'log_timestamp' => $logTimestamp,
                        'formatted_time' => $dateTime->format('Y-m-d H:i:s'),
                        'messages' => [$message]
                    ];
                } else {
                    // Add to existing group
                    $lastGroup['messages'][] = $message;
                }
            }
        }

        return $groups;
    }


    protected function shouldStartNewGroup($newMessage, $lastMessage)
    {
        // Start new group if message types are different
        $errorKeywords = ['error', 'fail', 'exception', 'sqlstate'];
        $newIsError = Str::contains(strtolower($newMessage), $errorKeywords);
        $lastIsError = Str::contains(strtolower($lastMessage), $errorKeywords);

        return $newIsError !== $lastIsError;
    }


    public function download($fileName)
    {
        $filePath = storage_path("logs/{$fileName}");

        if (!File::exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath);
    }

    public function delete($fileName)
    {
        $filePath = storage_path("logs/{$fileName}");
        if (!File::exists($filePath)) {
            return response()->json([
                'status' => 404,
                'message' => __('Log file not found')
            ], 404);
        }

        try {
            File::delete($filePath);

            return response()->json([
                'status' => 200,
                'message' => __('Log file deleted successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => __('Failed to delete log file')
            ], 500);
        }
    }

    protected function getLogFiles()
    {
        $files = File::files(storage_path('logs'));

        return collect($files)
            ->filter(function ($file) {
                return strpos($file->getFilename(), 'laravel') === 0;
            })
            ->map(function ($file) {
                return [
                    'name' => $file->getFilename(),
                    'size' => $this->formatSizeUnits($file->getSize()),
                    'last_modified' => date('d M Y H:i', $file->getMTime()),
                    'date' => date('d M Y', $file->getCTime()),
                ];
            })
            ->sortByDesc('last_modified');
    }

    protected function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
