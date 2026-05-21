<?php

namespace App\Livewire\Inquiries;

use App\Models\ContactInquiry;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard - Inquiries')]
class InquiryManager extends Component
{
    public string $filter = 'active';

    public ?int $selectedId = null;

    public function selectInquiry(int $id): void
    {
        $inquiry = ContactInquiry::findOrFail($id);

        if ($inquiry->status === ContactInquiry::STATUS_UNREAD) {
            $inquiry->markRead();
        }

        $this->selectedId = $id;
    }

    public function markRead(int $id): void
    {
        ContactInquiry::findOrFail($id)->markRead();
    }

    public function markUnread(int $id): void
    {
        ContactInquiry::findOrFail($id)->markUnread();
    }

    public function archive(int $id): void
    {
        ContactInquiry::findOrFail($id)->archive();

        if ($this->selectedId === $id) {
            $this->selectedId = null;
        }
    }

    public function render()
    {
        $query = ContactInquiry::query()->latest();

        match ($this->filter) {
            'unread' => $query->where('status', ContactInquiry::STATUS_UNREAD),
            'archived' => $query->where('status', ContactInquiry::STATUS_ARCHIVED),
            'all' => $query,
            default => $query->where('status', '!=', ContactInquiry::STATUS_ARCHIVED),
        };

        $inquiries = $query->get();
        $selected = $this->selectedId ? ContactInquiry::find($this->selectedId) : $inquiries->first();

        return view('livewire.admin.inquiries.inquiry-manager', [
            'inquiries' => $inquiries,
            'selected' => $selected,
            'unreadCount' => ContactInquiry::where('status', ContactInquiry::STATUS_UNREAD)->count(),
        ])->layout('layouts.dashboard');
    }
}
