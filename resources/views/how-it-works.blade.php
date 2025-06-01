<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('How It Works') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">How Our B2B Platform Works</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        <div class="border rounded-lg p-6 bg-gray-50">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 text-blue-800 rounded-full mb-4 text-xl font-bold">1</div>
                            <h2 class="text-xl font-semibold mb-3">Register</h2>
                            <p>Create a B2B account with your company details. Our team will review your application and approve it within 24 hours.</p>
                        </div>
                        
                        <div class="border rounded-lg p-6 bg-gray-50">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 text-blue-800 rounded-full mb-4 text-xl font-bold">2</div>
                            <h2 class="text-xl font-semibold mb-3">Browse Products</h2>
                            <p>Explore our available stock of IT equipment. You can filter by category, condition, and other specifications to find what you need.</p>
                        </div>
                        
                        <div class="border rounded-lg p-6 bg-gray-50">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 text-blue-800 rounded-full mb-4 text-xl font-bold">3</div>
                            <h2 class="text-xl font-semibold mb-3">Request & Order</h2>
                            <p>Submit inquiries about products you're interested in or place orders directly through our platform.</p>
                        </div>
                    </div>
                    
                    <h2 class="text-xl font-semibold mb-4">The B2B Process in Detail</h2>
                    
                    <div class="space-y-6 prose max-w-none">
                        <div>
                            <h3 class="text-lg font-medium">1. Registration & Approval</h3>
                            <p>To access our B2B platform, you need to register with your company details including VAT number. This ensures that our platform is exclusively for business clients. Our team reviews each application to verify business credentials before granting access.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium">2. Browsing Available Stock</h3>
                            <p>Once approved, you can browse our extensive catalog of IT equipment. Each product listing includes detailed specifications, condition information, available quantity, and pricing. You can use our search and filter features to find exactly what you're looking for.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium">3. Product Inquiries</h3>
                            <p>Have questions about a specific product? Use our inquiry feature to contact our sales team directly from the product page. We aim to respond to all inquiries within one business day.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium">4. Placing Orders</h3>
                            <p>Ready to purchase? Place an order through our platform by selecting the desired quantity and completing the checkout process. We'll confirm your order and provide estimated delivery dates.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium">5. Order Management</h3>
                            <p>Track your orders through your account dashboard. You can view order status, history, and details of past purchases for easy reference and reordering.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 