<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ZoomService
{
    protected string $accountId;
    protected string $clientId;
    protected string $clientSecret;
    protected ?string $defaultHost;

    public function __construct()
    {
        $this->accountId = (string) config('zoom.account_id');
        $this->clientId = (string) config('zoom.client_id');
        $this->clientSecret = (string) config('zoom.client_secret');
        $this->defaultHost = config('zoom.default_host');
    }

    public function available(): bool
    {
        return $this->accountId && $this->clientId && $this->clientSecret && $this->defaultHost;
    }

    /**
     * Create a scheduled meeting under the given user (email or id).
     *
     * @param  array{topic:string,start_time:\DateTimeInterface|string, duration?:int, timezone?:string, host?:string}  $data
     * @return array{join_url:string,start_url:string,id:int}|null
     */
    public function createMeeting(array $data): ?array
    {
        if (!$this->available()) {
            return null;
        }

        $token = $this->getAccessToken();
        if (!$token) {
            return null;
        }

        $host = $data['host'] ?? $this->defaultHost;
        $duration = $data['duration'] ?? (int) config('zoom.default.duration', 60);
        $timezone = $data['timezone'] ?? (string) config('zoom.default.timezone', config('app.timezone', 'UTC'));

        $start = $data['start_time'];
        $startTime = $start instanceof \DateTimeInterface
            ? Carbon::instance($start)->toIso8601String()
            : Carbon::parse($start, $timezone)->toIso8601String();

        $payload = [
            'topic' => $data['topic'],
            'type' => 2, // Scheduled meeting
            'start_time' => $startTime,
            'duration' => $duration,
            'timezone' => $timezone,
            'settings' => [
                'waiting_room' => (bool) config('zoom.default.waiting_room', true),
                'join_before_host' => (bool) config('zoom.default.join_before_host', false),
                'approval_type' => 2, // No registration required
                'video_host' => true,
                'video_participants' => false,
            ],
        ];

        // Validate host exists in account; Zoom returns 404 if host not in account
        if (!$this->hostExists($host, $token)) {
            logger()->error('Zoom host not found in account', ['host' => $host]);
            return null;
        }

        $resp = Http::withToken($token)
            ->acceptJson()
            ->post("https://api.zoom.us/v2/users/{$host}/meetings", $payload);

        if (!$resp->successful()) {
            logger()->error('Zoom createMeeting failed', [
                'status' => $resp->status(),
                'host' => $host,
                'body' => $resp->body(),
            ]);
            return null;
        }

        $json = $resp->json();

        return [
            'join_url' => $json['join_url'] ?? '',
            'start_url' => $json['start_url'] ?? '',
            'id' => $json['id'] ?? 0,
        ];
    }

    protected function hostExists(string $host, string $token): bool
    {
        // Host can be email or userId
        $resp = Http::withToken($token)
            ->acceptJson()
            ->get("https://api.zoom.us/v2/users/{$host}");

        if ($resp->successful()) {
            return true;
        }

        // Fallback: try to find by listing users (limited to first page)
        $list = Http::withToken($token)
            ->acceptJson()
            ->get('https://api.zoom.us/v2/users', [
                'status' => 'active',
                'page_size' => 300,
            ]);
        if ($list->successful()) {
            $users = $list->json('users') ?? [];
            foreach ($users as $u) {
                if (isset($u['email']) && strcasecmp($u['email'], $host) === 0) {
                    return true;
                }
                if (isset($u['id']) && $u['id'] === $host) {
                    return true;
                }
            }
        }
        logger()->error('Zoom host lookup failed', ['status' => $resp->status(), 'body' => $resp->body()]);
        return false;
    }

    protected function getAccessToken(): ?string
    {
        return Cache::remember('zoom_s2s_token', now()->addMinutes(50), function () {
            $clientId = $this->clientId;
            $clientSecret = $this->clientSecret;
            $accountId = $this->accountId;

            if (!$clientId || !$clientSecret || !$accountId) {
                return null;
            }

            $basic = base64_encode($clientId . ':' . $clientSecret);

            $resp = Http::withHeaders([
                    'Authorization' => 'Basic ' . $basic,
                ])
                ->asForm()
                ->post('https://zoom.us/oauth/token', [
                    'grant_type' => 'account_credentials',
                    'account_id' => $accountId,
                ]);

            if (!$resp->successful()) {
                return null;
            }

            $data = $resp->json();
            $token = $data['access_token'] ?? null;
            $expiresIn = (int) ($data['expires_in'] ?? 3600);

            if (!$token) {
                return null;
            }

            // Adjust cache TTL by -60s safety margin
            Cache::put('zoom_s2s_token', $token, now()->addSeconds(max(60, $expiresIn - 60)));

            return $token;
        });
    }
}
