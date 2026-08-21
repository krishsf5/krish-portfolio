<?php

namespace App\Livewire\Inquiries;

use App\Services\ApiClient;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard — Inquiries')]
class InquiryManager extends Component
{
    public string $filter = 'active';

    public ?int $selectedId = null;

    public function selectInquiry(int $id): void
    {
        ApiClient::patch("/admin/inquiries/{$id}/read");
        $this->selectedId = $id;
    }

    public function markRead(int $id): void
    {
        ApiClient::patch("/admin/inquiries/{$id}/read");
    }

    public function markUnread(int $id): void
    {
        ApiClient::patch("/admin/inquiries/{$id}/unread");
    }

    public function archive(int $id): void
    {
        ApiClient::patch("/admin/inquiries/{$id}/archive");
        if ($this->selectedId === $id) {
            $this->selectedId = null;
        }
    }

    public function render()
    {
        $response    = ApiClient::get('/admin/inquiries', ['filter' => $this->filter]);
        $data        = $response->successful() ? $response->json() : [];
        $inquiries   = collect($data['inquiries'] ?? []);
        $unreadCount = $data['unread_count'] ?? 0;

        $selected = $this->selectedId
            ? $inquiries->firstWhere('id', $this->selectedId)
            : $inquiries->first();

        return view('livewire.admin.inquiries.inquiry-manager', [
            'inquiries'   => $inquiries,
            'selected'    => $selected,
            'unreadCount' => $unreadCount,
        ])->layout('layouts.dashboard');
    }
}
