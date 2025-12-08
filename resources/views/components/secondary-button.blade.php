<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary d-inline-flex align-items-center text-uppercase']) }}>
    {{ $slot }}
</button>
