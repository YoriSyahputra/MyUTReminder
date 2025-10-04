<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="parent max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="div1">1</div>
        <div class="div2">2</div>
        <div class="div3">3</div>
        <div class="div4">4</div>
        <div class="div5">5</div>
    </div>
    
    <style>
.parent {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: repeat(5, 1fr);
    gap: 16px;
    padding: 20px;
    min-height: 80vh;
}

.div1, .div2, .div3, .div4, .div5 {
    background-color: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: all 0.3s ease;
}

/* Dark mode styles */
@media (prefers-color-scheme: dark) {
    .div1, .div2, .div3, .div4, .div5 {
        background-color: rgb(31, 41, 55); /* dark:bg-gray-800 equivalent */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        color: #ffffff;
    }
}

.div1 {
    grid-row: 1 / span 4;
    grid-column: 1 / span 1;
}

.div2 {
    grid-row: 1 / span 4;
    grid-column: 2 / span 3;
}

.div3 {
    grid-row: 1 / span 3;
    grid-column: 5 / span 1;
}

.div4 {
    grid-row: 4 / span 1;
    grid-column: 5 / span 1;
}

.div5 {
    grid-row: 5 / span 1;
    grid-column: 1 / span 5;
}

.div1:hover, .div2:hover, .div3:hover, .div4:hover, .div5:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

@media (max-width: 768px) {
    .parent {
        grid-template-columns: 1fr;
        grid-template-rows: auto;
    }
    
    .div1, .div2, .div3, .div4, .div5 {
        grid-column: 1 / -1;
        grid-row: auto;
    }
}
</style>
</x-app-layout>
