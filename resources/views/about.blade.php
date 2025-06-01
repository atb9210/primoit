<x-public-layout>
    <x-slot name="title">About Us</x-slot>
    <x-slot name="description">Learn more about PrimoIT - your trusted source for premium refurbished IT hardware. Our mission, values, and team.</x-slot>

    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-blue-800 to-indigo-900 rounded-xl overflow-hidden shadow-xl mb-12">
                <div class="px-6 py-12 sm:px-12 sm:py-16 lg:px-16 lg:py-20 text-center">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
                        About PrimoIT
                    </h1>
                    <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                        Your trusted partner for high-quality refurbished IT hardware solutions
                    </p>
                </div>
            </div>

            <!-- Mission Section -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-12">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
                        <div class="prose max-w-none text-gray-600">
                            <p>At PrimoIT, our mission is to provide businesses with reliable, high-quality refurbished IT hardware that meets their needs while reducing environmental impact and offering exceptional value.</p>
                            <p>We believe that technology should be accessible, sustainable, and cost-effective. By carefully refurbishing premium IT equipment, we extend the lifecycle of hardware, reduce electronic waste, and help businesses optimize their IT budgets without compromising on quality or performance.</p>
                            <p>Our commitment to rigorous testing and quality control ensures that every product we offer meets the highest standards of performance and reliability.</p>
                        </div>
                    </div>
                    <div class="md:w-1/2">
                        <img src="{{ asset('images/mission.jpg') }}" alt="PrimoIT Mission" class="rounded-lg shadow-md" onerror="this.src='{{ asset('images/fallback/mission.svg') }}'">
                    </div>
                </div>
            </div>

            <!-- Values Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-lg shadow-md p-8 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Quality</h3>
                    <p class="text-gray-600">We maintain the highest standards in our refurbishment process, ensuring every product meets rigorous quality benchmarks before reaching our customers.</p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-8 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Sustainability</h3>
                    <p class="text-gray-600">By extending the lifecycle of IT hardware, we contribute to reducing electronic waste and promoting more sustainable technology consumption.</p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-8 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Customer Service</h3>
                    <p class="text-gray-600">We prioritize exceptional customer service, providing expert guidance and support throughout your purchase journey and beyond.</p>
                </div>
            </div>

            <!-- Team Section -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Our Team</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-32 h-32 bg-gray-300 rounded-full mb-4 overflow-hidden">
                            <img src="{{ asset('images/team/ceo.jpg') }}" alt="CEO" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/fallback/profile.svg') }}'">
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Marco Rossi</h3>
                        <p class="text-blue-600 mb-3">Chief Executive Officer</p>
                        <p class="text-gray-600 text-sm">With over 15 years of experience in the IT industry, Marco leads our company with vision and expertise.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-32 h-32 bg-gray-300 rounded-full mb-4 overflow-hidden">
                            <img src="{{ asset('images/team/cto.jpg') }}" alt="CTO" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/fallback/profile.svg') }}'">
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Alessia Bianchi</h3>
                        <p class="text-blue-600 mb-3">Chief Technical Officer</p>
                        <p class="text-gray-600 text-sm">Alessia oversees our technical operations, ensuring every product meets our rigorous quality standards.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-32 h-32 bg-gray-300 rounded-full mb-4 overflow-hidden">
                            <img src="{{ asset('images/team/operations.jpg') }}" alt="Operations Manager" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/fallback/profile.svg') }}'">
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Paolo Ferrara</h3>
                        <p class="text-blue-600 mb-3">Operations Manager</p>
                        <p class="text-gray-600 text-sm">Paolo manages our supply chain and logistics, ensuring efficient and timely delivery of products to our customers.</p>
                    </div>
                </div>
            </div>

            <!-- Our Process -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Our Refurbishment Process</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mb-4 relative">
                            <span class="text-xl font-bold">1</span>
                            <div class="absolute w-full h-1 bg-blue-600 right-0 top-1/2 transform -translate-y-1/2 hidden lg:block" style="width: 100%; left: 100%;"></div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Sourcing</h3>
                        <p class="text-gray-600">We carefully source premium IT hardware from trusted suppliers and enterprise environments.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mb-4 relative">
                            <span class="text-xl font-bold">2</span>
                            <div class="absolute w-full h-1 bg-blue-600 right-0 top-1/2 transform -translate-y-1/2 hidden lg:block" style="width: 100%; left: 100%;"></div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Inspection</h3>
                        <p class="text-gray-600">Every device undergoes thorough inspection and diagnostics to assess its condition.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mb-4 relative">
                            <span class="text-xl font-bold">3</span>
                            <div class="absolute w-full h-1 bg-blue-600 right-0 top-1/2 transform -translate-y-1/2 hidden lg:block" style="width: 100%; left: 100%;"></div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Refurbishment</h3>
                        <p class="text-gray-600">We clean, repair, and upgrade components to meet our quality standards.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mb-4">
                            <span class="text-xl font-bold">4</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Testing</h3>
                        <p class="text-gray-600">Each product undergoes rigorous testing to ensure optimal performance before being offered to customers.</p>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="bg-blue-50 rounded-lg shadow-md p-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Ready to work with us?</h2>
                <p class="text-lg text-gray-600 mb-6 max-w-3xl mx-auto">Contact our team today to discuss your IT hardware needs and discover how PrimoIT can provide reliable, cost-effective solutions for your business.</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('contact') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                        Contact Us
                    </a>
                    <a href="{{ route('batches.index') }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                        Browse Our Batches
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-public-layout> 