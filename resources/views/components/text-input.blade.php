@props(['disabled' => false, 'label' => null])

<div class="relative">
    <input 
        @disabled($disabled) 
        {{ $attributes->merge([
            'class' => 'peer w-full px-4 py-3 bg-gray-50/50 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-transparent focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 ease-in-out hover:border-gray-300'
        ]) }}
    >
    @if($label)
        <label {{ $attributes->merge(['class' => 'absolute left-4 top-3 text-gray-400 text-sm transition-all duration-300 peer-placeholder-shown:text-base peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-purple-600 peer-focus:bg-white peer-focus:px-1 cursor-text']) }}>
            {{ $label }}
        </label>
    @endif
</div>
