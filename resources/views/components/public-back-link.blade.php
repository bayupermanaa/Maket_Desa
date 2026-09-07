@props([
    'href',
    'label' => 'Kembali',
    'class' => '',
])

@once
    <style>
        .public-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #2563eb;
            font-size: 13px;
            font-weight: 600;
            transition: color 200ms ease, transform 200ms ease;
        }

        .public-back-link:hover {
            color: #1d4ed8;
            transform: translateX(-2px);
        }

        .public-back-link:focus-visible {
            outline: 2px solid rgba(59, 130, 246, 0.35);
            outline-offset: 3px;
            border-radius: 10px;
        }

        .public-back-link-icon {
            width: 16px;
            height: 16px;
            flex: 0 0 16px;
        }

        .public-inline-icon {
            width: 16px;
            height: 16px;
            flex: 0 0 16px;
            display: block;
        }

        .public-back-link-icon svg {
            width: 100%;
            height: 100%;
            display: block;
        }
    </style>
@endonce

<a href="{{ $href }}" {{ $attributes->merge(['class' => trim('public-back-link ' . $class)]) }}>
    <svg class="public-back-link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M15 18l-6-6 6-6"></path>
    </svg>
    <span>{{ $label }}</span>
</a>
