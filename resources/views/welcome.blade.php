<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UniBase - Your All-in-One Student Platform</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-2xl font-bold text-indigo-600">UniBase</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 mx-4">Log in</a>
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Get Started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 flex justify-center items-center">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">Transform Your University Experience</h1>
                    <p class="text-lg mb-8">UniBase is your all-in-one platform for studying smarter, managing stress, and connecting with peers.</p>
                    <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 inline-block">Start Your Journey</a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Everything You Need to Succeed</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-brain text-2xl text-indigo-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">AI Reading Assistant</h3>
                        <p class="text-gray-600">Get instant explanations and summaries of complex academic texts.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-comments text-2xl text-purple-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">AI Therapist Chat</h3>
                        <p class="text-gray-600">24/7 mental health support to help you manage stress and anxiety.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-camera text-2xl text-pink-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Smart Note Scanner</h3>
                        <p class="text-gray-600">Convert handwritten notes to text and get AI-powered study suggestions.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Proof -->
        <div class="py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Loved by Students</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 rounded-full bg-gray-200"></div>
                            <div class="ml-4">
                                <h4 class="font-semibold">Sarah Johnson</h4>
                                <p class="text-gray-500">Computer Science</p>
                            </div>
                        </div>
                        <p class="text-gray-600">"UniBase has completely transformed how I study. The AI reading assistant is like having a personal tutor!"</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 rounded-full bg-gray-200"></div>
                            <div class="ml-4">
                                <h4 class="font-semibold">Michael Chen</h4>
                                <p class="text-gray-500">Engineering</p>
                            </div>
                        </div>
                        <p class="text-gray-600">"The note scanner saves me hours of typing, and the study suggestions are incredibly helpful."</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 rounded-full bg-gray-200"></div>
                            <div class="ml-4">
                                <h4 class="font-semibold">Emma Davis</h4>
                                <p class="text-gray-500">Psychology</p>
                            </div>
                        </div>
                        <p class="text-gray-600">"Having access to the AI therapist has helped me manage my stress levels during exam periods."</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-indigo-600 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold mb-4">Ready to Transform Your Academic Journey?</h2>
                <p class="text-lg mb-8">Join thousands of students already using UniBase to excel in their studies.</p>
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 inline-block">Get Started for Free</a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <span class="text-2xl font-bold text-indigo-600">UniBase</span>
                        <p class="mt-4 text-gray-600">Your all-in-one platform for academic success and wellbeing.</p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-4">Features</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li>AI Reading Assistant</li>
                            <li>Text to Audio</li>
                            <li>Note Scanner</li>
                            <li>Study Tools</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-4">Support</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li>Help Center</li>
                            <li>Contact Us</li>
                            <li>Privacy Policy</li>
                            <li>Terms of Service</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-4">Connect</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-200 text-center text-gray-600">
                    <p>&copy; {{ date('Y') }} UniBase. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
