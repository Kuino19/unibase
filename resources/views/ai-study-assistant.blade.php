<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">AI Study Assistant</h2>
                    
                    <!-- Text Summarization -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">Text Summarization</h3>
                        <form id="summarizeForm" class="space-y-4">
                            <div>
                                <label for="text" class="block text-sm font-medium text-gray-700">Enter text to summarize</label>
                                <textarea id="text" name="text" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Summarize
                            </button>
                        </form>
                        <div id="summaryResult" class="mt-4 p-4 bg-gray-50 rounded-md hidden"></div>
                    </div>

                    <!-- Question Generation -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">Practice Question Generator</h3>
                        <form id="questionForm" class="space-y-4">
                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700">Topic</label>
                                <input type="text" id="topic" name="topic" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="difficulty" class="block text-sm font-medium text-gray-700">Difficulty</label>
                                    <select id="difficulty" name="difficulty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="easy">Easy</option>
                                        <option value="medium">Medium</option>
                                        <option value="hard">Hard</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="count" class="block text-sm font-medium text-gray-700">Number of Questions</label>
                                    <input type="number" id="count" name="count" min="1" max="10" value="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Generate Questions
                            </button>
                        </form>
                        <div id="questionsResult" class="mt-4 p-4 bg-gray-50 rounded-md hidden"></div>
                    </div>

                    <!-- Concept Explanation -->
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Concept Explainer</h3>
                        <form id="conceptForm" class="space-y-4">
                            <div>
                                <label for="concept" class="block text-sm font-medium text-gray-700">Enter a concept to explain</label>
                                <input type="text" id="concept" name="concept" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="level" class="block text-sm font-medium text-gray-700">Explanation Level</label>
                                <select id="level" name="level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Explain Concept
                            </button>
                        </form>
                        <div id="explanationResult" class="mt-4 p-4 bg-gray-50 rounded-md hidden"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('summarizeForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = document.getElementById('text').value;
            const resultDiv = document.getElementById('summaryResult');
            
            try {
                const response = await fetch('/ai/summarize', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ text })
                });
                
                const data = await response.json();
                resultDiv.textContent = data.summary;
                resultDiv.classList.remove('hidden');
            } catch (error) {
                alert('Failed to generate summary');
            }
        });

        document.getElementById('questionForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const topic = document.getElementById('topic').value;
            const difficulty = document.getElementById('difficulty').value;
            const count = document.getElementById('count').value;
            const resultDiv = document.getElementById('questionsResult');
            
            try {
                const response = await fetch('/ai/generate-questions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ topic, difficulty, count })
                });
                
                const data = await response.json();
                resultDiv.textContent = data.questions;
                resultDiv.classList.remove('hidden');
            } catch (error) {
                alert('Failed to generate questions');
            }
        });

        document.getElementById('conceptForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const concept = document.getElementById('concept').value;
            const level = document.getElementById('level').value;
            const resultDiv = document.getElementById('explanationResult');
            
            try {
                const response = await fetch('/ai/explain-concept', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ concept, level })
                });
                
                const data = await response.json();
                resultDiv.textContent = data.explanation;
                resultDiv.classList.remove('hidden');
            } catch (error) {
                alert('Failed to explain concept');
            }
        });
    </script>
    @endpush
</x-app-layout>
