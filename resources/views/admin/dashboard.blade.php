<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <span class="text-sm bg-red-600 text-white px-2 py-1 rounded-md">Admin Panel</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Welcome to the Admin Dashboard</h1>
                    <p class="mb-4">This is the administration area of PrimoIT B2B platform.</p>
                    <p>Use the navigation menu to manage products, categories, orders, inquiries and users.</p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 