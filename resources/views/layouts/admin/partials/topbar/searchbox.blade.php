
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        #form-global-search {
            max-width: 400px;
       margin-right: 20px;
            margin-left: 20px;
        }

        #search-results {
            position: absolute;
            z-index: 1000;
            background: #fff;
            border: 1px solid #ccc;
            width: 50%;
            max-height: 300px;
            overflow-y: auto;
        }

        #search-results ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #search-results li {
            padding: 10px;
            border-bottom: 2px solid #ccc;
        }

        #search-results li:hover {
            background: #628292f5;
        }

        .highlight {
            background-color: rgb(0, 200, 255);
        }

        .text-danger {
            color: red;
        }
    </style>
    <div id="form-global-search" class="rounded">
        <form id="global-search-form">
            <div class="input-group position-relative">
                <input type="text" class="form-control" placeholder="Search..." id="top-search" name="query">
                <button type="submit">
                    <i class="fas fa-search text-highlight"></i>
                </button>
            </div>
        </form>
    </div>

    <div id="search-results" class="mt-3" aria-live="polite"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let debounceTimer;

            function highlightText(text, query) {
                const regex = new RegExp(`(${query})`, 'gi');
                return text.replace(regex, '<span class="highlight">$1</span>');
            }

            function performSearch(query) {
                $.ajax({
                    url: '{{ route("admin.search") }}',
                    type: 'GET',
                    data: { query: query },
                    success: function(response) {
                        if (response.success) {
                            let results = response.results;
                            let resultsHtml = '<ul class="list-group">';

                            results.forEach(function(result) {
                                let showUrl = '{{ route("jobs.show", ":id") }}'.replace(':id', result.id);
                                let title = highlightText(result.title, query);
                                let category = result.category ? highlightText(result.category.name, query) : '';
                                let tag = result.tag ? highlightText(result.tag.name, query) : '';
                                let location = result.location ? highlightText(result.location.name, query) : '';

                                resultsHtml += `<li class="list-group-item">
                                    <a href="${showUrl}">${title}</a> - ${category} - ${tag} - ${location}
                                </li>`;
                            });

                            resultsHtml += '</ul>';
                            $('#search-results').html(resultsHtml);
                        } else {
                            $('#search-results').html('<p class="text-danger">No results found.</p>');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error details:', xhr.responseText);
                        $('#search-results').html('<p class="text-danger">An error occurred while searching. Please try again later.</p>');
                    }
                });
            }

            $('#top-search').on('input', function() {
                clearTimeout(debounceTimer);
                let query = $(this).val();

                debounceTimer = setTimeout(function() {
                    if (query.length >= 3) { // Minimum length of query to start search
                        performSearch(query);
                    } else {
                        $('#search-results').empty();
                    }
                }, 300); // Delay in milliseconds
            });

            $('#global-search-form').on('submit', function(event) {
                event.preventDefault();
                let query = $('#top-search').val();
                if (query.length >= 3) {
                    performSearch(query);
                }
            });
        });
    </script>

