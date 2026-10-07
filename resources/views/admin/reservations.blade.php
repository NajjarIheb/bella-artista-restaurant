@extends('layouts.admin')

@section('title', 'Manage Reservations')

@section('content')
<h1 style="margin-bottom: 2rem;">Table Reservations</h1>

<div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 1px solid var(--color-border); background: rgba(255,255,255,0.02);">
                <th style="padding: 1.2rem;">ID</th>
                <th style="padding: 1.2rem;">Customer</th>
                <th style="padding: 1.2rem;">Phone / Email</th>
                <th style="padding: 1.2rem;">Date & Time</th>
                <th style="padding: 1.2rem;">Guests</th>
                <th style="padding: 1.2rem;">Notes</th>
                <th style="padding: 1.2rem;">Status</th>
                <th style="padding: 1.2rem;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $res)
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                <td style="padding: 1.2rem;">#{{ $res->id }}</td>
                <td style="padding: 1.2rem;">
                    <strong>{{ $res->customer_name }}</strong>
                </td>
                <td style="padding: 1.2rem; font-size: 0.9rem;">
                    <div><i class="fas fa-phone text-gold"></i> {{ $res->phone }}</div>
                    @if($res->email)
                    <div style="color: var(--color-text-muted);">{{ $res->email }}</div>
                    @endif
                </td>
                <td style="padding: 1.2rem; font-weight: bold; color: var(--color-gold);">
                    {{ $res->date }} @ {{ $res->time }}
                </td>
                <td style="padding: 1.2rem;">
                    {{ $res->guests }} {{ $res->guests == 1 ? 'Guest' : 'Guests' }}
                </td>
                <td style="padding: 1.2rem; font-size: 0.85rem; color: var(--color-text-muted);">
                    {{ $res->notes ?? '—' }}
                </td>
                <td style="padding: 1.2rem;">
                    <span style="display: inline-block; padding: 0.3rem 0.8rem; border-radius: 3px; font-size: 0.8rem; font-weight: 500;
                        background: {{ in_array($res->status, ['confirmed', 'seated', 'completed']) ? 'rgba(46, 204, 113, 0.2)' : (in_array($res->status, ['cancelled', 'no_show']) ? 'rgba(231, 76, 60, 0.2)' : 'rgba(241, 196, 15, 0.2)') }};
                        color: {{ in_array($res->status, ['confirmed', 'seated', 'completed']) ? '#2ecc71' : (in_array($res->status, ['cancelled', 'no_show']) ? '#e74c3c' : '#f1c40f') }};">
                        {{ strtoupper(str_replace('_', ' ', $res->status)) }}
                    </span>
                </td>
                <td style="padding: 1.2rem;">
                    <form action="{{ route('admin.reservations.update', $res->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="form-control" style="padding: 0.4rem; font-size: 0.85rem;">
                            <option value="pending" {{ $res->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $res->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="seated" {{ $res->status == 'seated' ? 'selected' : '' }}>Seated</option>
                            <option value="no_show" {{ $res->status == 'no_show' ? 'selected' : '' }}>No Show</option>
                            <option value="completed" {{ $res->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $res->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding: 2rem; text-align: center; color: var(--color-text-muted);">No reservations found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
