<?php

namespace App\Libraries;

/**
 * Supabase REST API Client for PHP
 * Wraps Supabase PostgREST and GoTrue APIs
 */
class SupabaseClient
{
    // Public keys — safe to commit (security is via Supabase RLS policies)
    private const SUPABASE_URL = 'https://pewplcngdxpcaopareaw.supabase.co';
    private const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InBld3BsY25nZHhwY2FvcGFyZWF3Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3Njk2NzU5MjEsImV4cCI6MjA4NTI1MTkyMX0.J0yWL6cN80ZBs1k-i6iV2-zK_cWHVO0ACTRXg3_S9zo';

    private string $url;
    private string $anonKey;
    private string $serviceKey;

    public function __construct()
    {
        // Public keys: use hardcoded defaults (env override optional)
        $this->url = $_ENV['SUPABASE_URL'] ?? getenv('SUPABASE_URL') ?: self::SUPABASE_URL;
        $this->anonKey = $_ENV['SUPABASE_ANON_KEY'] ?? getenv('SUPABASE_ANON_KEY') ?: self::SUPABASE_ANON_KEY;

        // Service key: MUST be set via environment (Vercel Env Vars) — never hardcode
        $this->serviceKey = $_ENV['SUPABASE_SERVICE_KEY'] ?? getenv('SUPABASE_SERVICE_KEY') ?? '';
    }

    // ==========================================
    // AUTH METHODS
    // ==========================================

    /**
     * Sign in with email and password
     */
    public function signIn(string $email, string $password): array
    {
        return $this->request('POST', '/auth/v1/token?grant_type=password', [
            'email' => $email,
            'password' => $password,
        ], $this->anonKey);
    }

    /**
     * Sign up with email and password
     */
    public function signUp(string $email, string $password, array $metadata = []): array
    {
        return $this->request('POST', '/auth/v1/signup', [
            'email' => $email,
            'password' => $password,
            'data' => $metadata,
        ], $this->anonKey);
    }

    /**
     * Request password reset
     */
    public function resetPasswordForEmail(string $email, string $redirectTo): array
    {
        return $this->request('POST', '/auth/v1/recover', [
            'email' => $email,
            'gotrue_meta_security' => ['captcha_token' => ''],
        ], $this->anonKey, [
            'Redirect-To' => $redirectTo,
        ]);
    }

    /**
     * Update user password (requires access token)
     */
    public function updatePassword(string $accessToken, string $newPassword): array
    {
        return $this->request('PUT', '/auth/v1/user', [
            'password' => $newPassword,
        ], $accessToken);
    }

    /**
     * Get user by access token
     */
    public function getUser(string $accessToken): array
    {
        return $this->request('GET', '/auth/v1/user', [], $accessToken);
    }

    /**
     * Sign out
     */
    public function signOut(string $accessToken): array
    {
        return $this->request('POST', '/auth/v1/logout', [], $accessToken);
    }

    // ==========================================
    // DATA METHODS (PostgREST)
    // ==========================================

    /**
     * Select from a table
     */
    public function from(string $table): QueryBuilder
    {
        return new QueryBuilder($this, $table);
    }

    /**
     * Execute a PostgREST request
     */
    public function executeQuery(string $method, string $table, array $params = [], array $body = [], ?string $token = null): array
    {
        $queryString = '';
        if (!empty($params)) {
            $queryString = '?' . http_build_query($params);
        }

        $authToken = $token ?: $this->serviceKey;
        return $this->request($method, '/rest/v1/' . $table . $queryString, $body, $authToken, [
            'Prefer' => $method === 'POST' ? 'return=representation' : 'return=minimal',
        ]);
    }

    // ==========================================
    // HTTP CLIENT
    // ==========================================

    private function request(string $method, string $path, array $body = [], string $token = '', array $extraHeaders = []): array
    {
        $url = $this->url . $path;

        $headers = [
            'Content-Type: application/json',
            'apikey: ' . $this->anonKey,
        ];

        if ($token) {
            $headers[] = 'Authorization: Bearer ' . $token;
        }

        foreach ($extraHeaders as $key => $value) {
            $headers[] = "$key: $value";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        } elseif ($method === 'PUT' || $method === 'PATCH') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['error' => ['message' => $error], 'status' => 0];
        }

        $decoded = json_decode($response, true) ?? [];
        $decoded['_status'] = $httpCode;

        return $decoded;
    }
}

/**
 * Simple Query Builder for PostgREST
 */
class QueryBuilder
{
    private SupabaseClient $client;
    private string $table;
    private array $params = [];
    private string $selectColumns = '*';

    public function __construct(SupabaseClient $client, string $table)
    {
        $this->client = $client;
        $this->table = $table;
    }

    public function select(string $columns = '*'): self
    {
        $this->selectColumns = $columns;
        $this->params['select'] = $columns;
        return $this;
    }

    public function eq(string $column, $value): self
    {
        $this->params[$column] = 'eq.' . $value;
        return $this;
    }

    public function neq(string $column, $value): self
    {
        $this->params[$column] = 'neq.' . $value;
        return $this;
    }

    public function order(string $column, bool $ascending = true): self
    {
        $dir = $ascending ? 'asc' : 'desc';
        $this->params['order'] = $column . '.' . $dir;
        return $this;
    }

    public function limit(int $count): self
    {
        $this->params['limit'] = $count;
        return $this;
    }

    public function single(): array
    {
        $this->params['limit'] = 1;
        $result = $this->execute();
        return is_array($result) && isset($result[0]) ? $result[0] : $result;
    }

    public function insert(array $data): array
    {
        return $this->client->executeQuery('POST', $this->table, $this->params, $data);
    }

    public function update(array $data): array
    {
        return $this->client->executeQuery('PATCH', $this->table, $this->params, $data);
    }

    public function delete(): array
    {
        return $this->client->executeQuery('DELETE', $this->table, $this->params);
    }

    public function execute(): array
    {
        return $this->client->executeQuery('GET', $this->table, $this->params);
    }
}
