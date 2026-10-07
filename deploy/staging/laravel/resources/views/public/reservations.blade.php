@extends('layouts.app')

@section('title', 'Table Reservations - Bella Artista')
@section('metaDescription', __('seo.reservationsDesc'))

@section('content')
<div class="section" style="padding-top: 10rem;">
    <div class="section-header">
        <div class="section-subtitle">{{ __('reservations.subtitle') }}</div>
        <h1>{{ __('reservations.reserve') }}</h1>
        <div class="divider-gold"></div>
    </div>

    <div class="form-container">
        <p style="text-align: center; margin-bottom: 2rem; color: var(--color-text-muted);">
            {{ __('reservations.intro') }}
        </p>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                <ul style="margin-left: 1.2rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <div class="form-group">
                    <label for="customer_name">{{ __('reservations.fullName') }}</label>
                    <input type="text" id="customer_name" name="customer_name" class="form-control" required value="{{ old('customer_name') }}">
                </div>

                <div class="form-group">
                    <label for="phone">{{ __('reservations.phone') }}</label>
                    <input type="tel" id="phone" name="phone" class="form-control" required value="{{ old('phone') }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem;">
                <div class="form-group">
                    <label for="date">{{ __('reservations.date') }}</label>
                    <input type="date" id="date" name="date" class="form-control" required min="{{ date('Y-m-d') }}" value="{{ old('date') }}">
                </div>

                <div class="form-group">
                    <label for="time">{{ __('reservations.time') }}</label>
                    <input type="time" id="time" name="time" class="form-control" required value="{{ old('time', '19:00') }}">
                </div>

                <div class="form-group">
                    <label for="guests">{{ __('reservations.guestsCount') }}</label>
                    <select id="guests" name="guests" class="form-control" required>
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ old('guests') == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? __('reservations.guest') : __('reservations.guests') }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="notes">{{ __('reservations.notesLabel') }}</label>
                <textarea id="notes" name="notes" rows="3" class="form-control" placeholder="{{ __('reservations.notesPlaceholder') }}">{{ old('notes') }}</textarea>
            </div>

            <div style="background: rgba(212, 175, 55, 0.08); padding: 1.2rem; border-inline-start: 3px solid var(--color-gold); margin-bottom: 2rem;">
                <p style="font-size: 0.9rem; color: var(--color-cream); margin: 0;">
                    <i class="fas fa-calendar-check text-gold"></i> <strong>{{ __('reservations.noPayment') }}</strong> {{ __('reservations.noPaymentText') }}
                </p>
            </div>

            <button type="submit" class="btn-gold" style="width: 100%;">{{ __('reservations.completeRequest') }}</button>
        </form>
    </div>
</div>
@endsection
