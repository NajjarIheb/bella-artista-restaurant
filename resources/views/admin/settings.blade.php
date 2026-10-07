@extends('layouts.admin')

@section('title', 'Restaurant Settings')

@section('content')
<h1 style="margin-bottom: 2rem;">Restaurant Settings</h1>

<form action="{{ route('admin.settings.update') }}" method="POST" style="max-width: 720px;">
    @csrf

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div class="form-group">
            <label>Restaurant Name *</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $info->name) }}">
        </div>

        <div class="form-group">
            <label>Phone *</label>
            <input type="text" name="phone" class="form-control" required value="{{ old('phone', $info->phone) }}">
        </div>
    </div>

    <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $info->address) }}">
    </div>

    <div class="form-group">
        <label>Opening Hours</label>
        <input type="text" name="hours" class="form-control" value="{{ old('hours', $info->hours) }}" placeholder="e.g. 6:00 AM - 3:00 AM">
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
        <div class="form-group">
            <label>Delivery Fee (DT) *</label>
            <input type="number" step="0.01" min="0" name="delivery_fee" class="form-control" required value="{{ old('delivery_fee', $info->delivery_fee) }}">
        </div>

        <div class="form-group">
            <label>Minimum Order (DT)</label>
            <input type="number" step="0.01" min="0" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', $info->min_order_amount) }}">
        </div>

        <div class="form-group">
            <label>Delivery Radius</label>
            <input type="text" name="delivery_radius" class="form-control" value="{{ old('delivery_radius', $info->delivery_radius) }}">
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div class="form-group">
            <label>Plus Code</label>
            <input type="text" name="plus_code" class="form-control" value="{{ old('plus_code', $info->plus_code) }}">
        </div>

        <div class="form-group">
            <label>Google Maps URL</label>
            <input type="url" name="maps_url" class="form-control" value="{{ old('maps_url', $info->maps_url) }}">
        </div>
    </div>

    <div class="form-group">
        <label>About Text</label>
        <textarea name="about" rows="4" class="form-control">{{ old('about', $info->about) }}</textarea>
    </div>

    <button type="submit" class="btn-gold" style="padding: 0.8rem 2rem;">Save Settings</button>
</form>

<hr style="border: none; border-top: 1px solid var(--color-border); margin: 2.5rem 0;">

<h2 style="margin-bottom: 1rem;">Admin Account</h2>
<p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">
    Update the email and password used to sign in to this management portal.
</p>

@if($errors->has('current_password') || $errors->has('email') || $errors->has('password'))
    <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
        <ul style="margin: 0; padding-inline-start: 1.2rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.profile.update') }}" method="POST" style="max-width: 720px;">
    @csrf

    <div class="form-group">
        <label>Current Password *</label>
        <input type="password" name="current_password" class="form-control" required autocomplete="current-password">
    </div>

    <div class="form-group">
        <label>New Email *</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email', auth()->user()->email) }}" autocomplete="email">
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Leave blank to keep current">
        </div>

        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>
    </div>

    <button type="submit" class="btn-gold" style="padding: 0.8rem 2rem;">Update My Account</button>
</form>
@endsection
