<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Help - Sport Indirect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/user/help.css') }}">
</head>

@extends('layouts.user')

@section('content')

<body>
    <div class="container mt-5 help-page">
        <h1 class="text-center text-dark">Help Center</h1>
        <p class="text-center text-dark">Type your question below and get instant answers:</p>
        
        <div class="mb-3">
            <input type="text" id="helpQuery" class="form-control" placeholder="Enter your question...">
        </div>

        <!-- Results will be displayed here -->
        <div id="helpResults" class="list-group"></div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const helpQueryInput = document.getElementById("helpQuery");
            const helpResultsContainer = document.getElementById("helpResults");
            
            let debounceTimeout = null;
            
            helpQueryInput.addEventListener("keyup", function() {
                const query = this.value.trim();
                
                if (debounceTimeout) {
                    clearTimeout(debounceTimeout);
                }
                
                debounceTimeout = setTimeout(() => {
                    if (query.length > 0) {
                        fetchHelpResults(query);
                    } else {
                        helpResultsContainer.innerHTML = "";
                    }
                }, 500);
            });
            
            function fetchHelpResults(query) {
                const dummyData = [
                    { question: "How do I return a product?", answer: "You can return a product within 30 days of purchase if it is in original condition." },
                    { question: "What is your shipping policy?", answer: "We offer free shipping on orders above RM200 and fast delivery across the region." },
                    { question: "How do I track my order?", answer: "Track your order by logging into your account and clicking on 'My Orders'." },
                    { question: "Can I cancel my order?", answer: "Yes, you can cancel your order within 1 hour of placing it by contacting customer support." }
                ];
                
                const filteredData = dummyData.filter(item => 
                    item.question.toLowerCase().includes(query.toLowerCase()) ||
                    item.answer.toLowerCase().includes(query.toLowerCase())
                );
                
                displayHelpResults(filteredData);
            }
            
            function displayHelpResults(results) {
                helpResultsContainer.innerHTML = "";

                if (results.length === 0) {
                    helpResultsContainer.innerHTML = '<p class="text-danger">No results found.</p>';
                    return;
                }

                results.forEach(item => {
                    const div = document.createElement("div");
                    div.className = "list-group-item";
                    div.innerHTML = `<h5 class="text-primary">${item.question}</h5><p class="text-secondary">${item.answer}</p>`;
                    helpResultsContainer.appendChild(div);
                });
            }
        });
    </script>
</body>
</html>
@endsection
