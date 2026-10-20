<?php

namespace App\Livewire\Inquiries;

use App\Services\ApiClient;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard — Inquiries')]
class InquiryManager extends Component
{
    public string $filter = 'active';

    public ?int $selectedId = null;

    public function selectInquiry(int $id): void
    {
        $response = ApiClient::patch("/admin/inquiries/{$id}/read");
        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user', 'api_login_at']);
            session()->flash('error', 'Your session has expired. Please log in again.');
            $this->redirect(route('login'), navigate: true);

            return;
        }
        $this->selectedId = $id;
    }

    public function markRead(int $id): void
    {
        $response = ApiClient::patch("/admin/inquiries/{$id}/read");
        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user', 'api_login_at']);
            session()->flash('error', 'Your session has expired. Please log in again.');
            $this->redirect(route('login'), navigate: true);
        }
    }

    public function markUnread(int $id): void
    {
        $response = ApiClient::patch("/admin/inquiries/{$id}/unread");
        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user', 'api_login_at']);
            session()->flash('error', 'Your session has expired. Please log in again.');
            $this->redirect(route('login'), navigate: true);
        }
    }

    public function archive(int $id): void
    {
        $response = ApiClient::patch("/admin/inquiries/{$id}/archive");
        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user', 'api_login_at']);
            session()->flash('error', 'Your session has expired. Please log in again.');
            $this->redirect(route('login'), navigate: true);

            return;
        }
        if ($this->selectedId === $id) {
            $this->selectedId = null;
        }
    }

    public function render()
    {
        $response = ApiClient::get('/admin/inquiries', ['filter' => $this->filter]);

        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user', 'api_login_at']);
            session()->flash('error', 'Your session has expired. Please log in again.');
            $this->redirect(route('login'), navigate: true);

            return view('livewire.admin.inquiries.inquiry-manager', [
                'inquiries' => collect(),
                'selected' => null,
                'unreadCount' => 0,
            ])->layout('layouts.dashboard');
        }

        $data = $response->successful() ? json_decode($response->body()) : null;
        $inquiries = collect($data->inquiries ?? [])->map(function ($item) {
            if (! empty($item->created_at)) {
                $item->created_at = Carbon::parse($item->created_at);
            }
            if (! empty($item->read_at)) {
                $item->read_at = Carbon::parse($item->read_at);
            }
            if (! empty($item->archived_at)) {
                $item->archived_at = Carbon::parse($item->archived_at);
            }

            return $item;
        });
        $unreadCount = $data->unread_count ?? 0;

        $selected = $this->selectedId
            ? $inquiries->firstWhere('id', $this->selectedId)
            : $inquiries->first();

        return view('livewire.admin.inquiries.inquiry-manager', [
            'inquiries' => $inquiries,
            'selected' => $selected,
            'unreadCount' => $unreadCount,
        ])->layout('layouts.dashboard');
    }
}
